<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use App\Entity\Project;
use App\Form\ProjectType;

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
            ->findOneBy(['title' => $projectTitle]);

        $photos = $project->getPhotos();

        return $this->render('home/gallery.html.twig',array(
            'photos' => $photos));
    }

}