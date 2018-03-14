<?php
namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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

            return $this->redirect($this->generateUrl('ProjectsRoute'));
        }

        return $this->render('admin/adminProjects.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function viewProjects()
    {
        $projectRepo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepo->findAll();

        return $this->render('home/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    public function ViewGallery(Request $request, string $projectTitle)
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findOneBy(['slug' => $projectTitle]);

        $photo = $project->getPhotos();


        return $this->render('home/photo.html.twig',array(
            'photo' => $photo[0],
            'nextphoto' => $photo[1]));
    }

    public function editProjects(Request $request, FileUploader $fileUploader)
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

        return $this->render('admin/adminProjects.html.twig', [
            'projects' => $projects,
            'form' => $form->createView(),
        ]);

    }

}