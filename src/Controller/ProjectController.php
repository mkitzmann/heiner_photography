<?php
namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use App\Entity\Project;
use App\Form\ProjectType;
use Cocur\Slugify\Slugify;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class ProjectController extends Controller
{
    public function newProject(Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $project->getThumbnail();
            $directory = $this->getParameter('thumbnail_directory');
            $fileName = $fileUploader->upload($file, $directory);
            $project->setThumbnail($fileName);

            $title = $project->getTitle();
            $slugify = new Slugify();
            $project->setSlug($slugify->slugify($title));

            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl('ProjectsRoute'));
        }

        return $this->render('admin/adminProjects.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function viewProjects()
    {
        $projectRepo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepo->findAll(['position' => 'ASC']);

        return $this->render('home/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    public function editProjects(Request $request, FileUploader $fileUploader, SerializerInterface $serializer)
    {
        $projectRepo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepo->findAll();

        $em = $this->getDoctrine()->getManager();

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $project->getThumbnail();
            $directory = $this->getParameter('thumbnail_directory');
            $fileName = $fileUploader->upload($file, $directory);
            $project->setThumbnail($fileName);

            $title = $project->getTitle();
            $slugify = new Slugify();
            $project->setSlug($slugify->slugify($title));

            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl('AdminProjectsRoute'));
        }

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('photos'));
        $normalizers = array($normalizer);

        $serializer = new Serializer($normalizers, $encoders);

        $jsonProjects = $serializer->serialize($projects, 'json');

        return $this->render('admin/adminProjects.html.twig', [
            'projects' => $jsonProjects,
            'form' => $form->createView(),
        ]);

    }


    public function updateProjectPosition(project $project, $position){

        if($project->getPosition() == $position){
            return new Response('Position of project with id '.$project->getId().' is already position '.$position);
        }
        else
            {
            $entityManager = $this->getDoctrine()->getManager();

            //get total no of projects
            $projectsRepo = $entityManager->getRepository(Project::class);
            $allProjects = $projectsRepo->findAll();
            $totalProjects = count($allProjects);

            //check if sorting is ok + set position for each project
            foreach($allProjects as $singleProject){
                $currentPosition = $singleProject->getPosition();
                if($currentPosition > $totalProjects){
                    throw new \Exception('position of project with id '.
                        $singleProject->getId().' higher then total');
                }
                elseif($currentPosition == $project->getPosition()) {}
                elseif($currentPosition >= $position and $currentPosition < $project->getPosition()){
                    $singleProject->setPosition(($currentPosition+1));
                    //dump($singleProject);
                }
                elseif($currentPosition <= $position and $currentPosition > $project->getPosition()){
                    $singleProject->setPosition(($currentPosition-1));
                    //dump($singleProject);
                }
            }

            $project->setPosition($position);
            $entityManager->flush();

            return new Response('Set position of project with id '.
                $project->getId().' to position '.
                $position);

        }
            }

}