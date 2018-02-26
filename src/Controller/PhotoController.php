<?php
namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
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

    public function ViewPhoto(Request $request)
    {
        $projectTitle = $request->get('projectTitle');
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findOneBy(['slug' => $projectTitle]);
        $projectId = $project->getId();

        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);

        $photoCount = $photoRepo->count(['project' => $projectId]);

        if ($photoTitle = $request->get('photoTitle')) {
            $currentPhoto = $photoRepo->findOneBy([
                'slug' => $photoTitle,
                'project' => $projectId
                ]);
            $photoPosition = $currentPhoto->getPosition();
        }else{
            $currentPhoto = $photoRepo->findOneBy([
                'position' => 1,
                'project' => $projectId
            ]);
            $photoPosition = 1;
        }

        $nextPhoto = $photoRepo->findOneBy([
            'project' => $projectId,
            'position' => $photoPosition+1
        ]);

        if ($nextPhoto == NULL){
            $nextPhoto = $photoRepo->findOneBy([
                'position' => 1,
                'project' => $projectId
            ]);
        }

        $prevPhoto = $photoRepo->findOneBy([
            'project' => $projectId,
            'position' => $photoPosition-1
        ]);


        if ($prevPhoto == NULL){
            $prevPhoto = $photoRepo->findOneBy([
                'position' => $photoCount,
                'project' => $projectId,
            ]);
        }

        return $this->render('home/photo.html.twig',array(
            'photo' => $currentPhoto,
            'project' => $projectTitle,
            'nextphoto' => $nextPhoto,
            'prevPhoto' => $prevPhoto));
    }


    
}