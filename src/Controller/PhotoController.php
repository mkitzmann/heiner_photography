<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Photo;
use App\Form\PhotoType;


class PhotoController extends Controller
{
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $photo->getImage();


            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('photo_directory'),
                $fileName
            );

            $photo->setImage($fileName);

            //$project = $photo->getProject();
            //$project = $project->id;
            //var_dump($photo);
            //$photo->setProject($project);



            $em->persist($photo);

            $em->flush();

            return $this->redirect($this->generateUrl('ProjectsRoute'));
        }

        return $this->render('admin/adminPhotos.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function GalleryAction(Request $request, string $projectTitle)
    {
        return $this->render('home/gallery.html.twig',[
            'projectTitle' => $projectTitle
        ]);
    }

    /**
     * @return string
     */
    public function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}