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
    public function new(Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();

        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $project->getThumbnail();

            $title = $project->getTitle();

            $fileName = $fileUploader->upload($file);

            $project->setThumbnail($fileName);
            $project->setTitle($title);

            $em->persist($project);

            $em->flush();

            return $this->redirect($this->generateUrl('ProjectsRoute'));
        }

        return $this->render('admin/adminProjects.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function view()
    {
        $projectRepo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepo->findAll();

        //var_dump($projects);

        return $this->render('home/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

}