<?php
namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use App\Service\PhotoPosition;
use App\Entity\Photo;
use App\Entity\Project;
use App\Form\PhotoType;
use Cocur\Slugify\Slugify;

class PhotoController extends Controller
{
    public function newPhoto(Request $request, FileUploader $fileUploader)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $photo->getImage();
            $directory = $this->getParameter('photo_directory');
            $fileName = $fileUploader->upload($file, $directory);
            $photo->setImage($fileName);

            $title = $photo->getTitle();
            $slugify = new Slugify();
            $photo->setSlug($slugify->slugify($title));

            $em->persist($photo);
            $em->flush();

            return $this->redirect($this->generateUrl('ProjectsRoute'));
        }

        return $this->render('admin/adminPhotos.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("project", class="App\Entity\Project", options={"mapping": {"project_slug": "slug"}})
     * @ParamConverter("photo", class="App\Entity\Photo", options={"mapping": {"photo_slug": "slug"}})
     */
    public function ViewPhoto(Project $project, Photo $photo, PhotoPosition $photoPosition)
    {
        $prevNextPhoto = $photoPosition->prevNextPhoto($project, $photo);

        return $this->render('home/photo.html.twig',array(
            'photo' => $photo,
            'project' => $project,
            'nextphoto' => $prevNextPhoto["next"],
            'prevPhoto' => $prevNextPhoto["prev"]));
    }

    /**
     * @ParamConverter("project", class="App\Entity\Project", options={"mapping": {"project_slug": "slug"}})
     */
    public function ViewProject(Project $project, PhotoPosition $photoPosition)
    {
        $photo = $this->getDoctrine()
            ->getRepository(Photo::class)
            ->findOneBy([
                'project' => $project->getId(),
                'position' => 1,
            ]);

        if($photo == NULL){
            throw $this->createNotFoundException('No Photos in Project '.$project->getTitle());
        }else{
            $prevNextPhoto = $photoPosition->prevNextPhoto($project, $photo);

            return $this->render('home/photo.html.twig',array(
                'photo' => $photo,
                'project' => $project,
                'nextphoto' => $prevNextPhoto["next"],
                'prevPhoto' => $prevNextPhoto["prev"]));
        }

    }
    
}