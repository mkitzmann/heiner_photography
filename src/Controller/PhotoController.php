<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use App\Entity\Photo;
use App\Entity\Project;
use App\Form\PhotoType;

class PhotoController extends Controller
{
    public function newPhoto(Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();

        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $photo->getImage();
            $directory = $this->getParameter('photo_directory');
            $fileName = $fileUploader->upload($file, $directory);
            $photo->setImage($fileName);

            $em->persist($photo);
            $em->flush();

            return $this->redirect($this->generateUrl('ProjectsRoute'));
        }

        return $this->render('admin/adminPhotos.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    
}