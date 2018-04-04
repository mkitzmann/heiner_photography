<?php
namespace App\Controller;

use App\Service\TypeConverter;
use App\Service\ProjectPositioner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use App\Entity\Project;
use App\Form\ProjectType;
use Cocur\Slugify\Slugify;

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

            return $this->redirect($this->generateUrl('AdminProjectsRoute'));
        } else {
            throw new \Exception('form is not valid or was not submitted');
        }


    }

    public function viewProjects()
    {
        $projectRepo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepo->findAll(['position' => 'ASC']);

        return $this->render('home/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    public function adminProjects(Request $request, FileUploader $fileUploader, TypeConverter $typeConverter)
    {
        $projectRepo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepo->findAll();

        $jsonProjects = $typeConverter->jsonConvert($projects);

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        return $this->render('admin/adminProjects.html.twig', [
            'projects' => $jsonProjects,
            'form' => $form->createView(),
            'thumbnail_directory' => '/img/thumbnails/'
        ]);

    }


    public function updateProjectPosition(project $project, $position, ProjectPositioner $projectPosition)
    {
        if ($project->getPosition() == $position) {
            return new Response('Position of project with id ' . $project->getId() . ' is already position ' . $position);
        } else {
            return new Response($projectPosition->changePosition($project, $position));

        }

    }

}