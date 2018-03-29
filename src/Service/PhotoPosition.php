<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Photo;
use App\Entity\Project;

class PhotoPosition
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Photo::class);
    }

    public function prevNextPhoto(Project $project, Photo $photo)
    {
        $photoPosition = $photo->getPosition();
        $photoCount = $this->repository->count(['project' => $project->getId()]);

        if($photoPosition == 1){
            $prevPhoto = $this->repository->findOneBy([
                'position' => $photoCount,
                'project' => $project->getId(),
            ]);
        }else{
            $prevPhoto = $this->repository->findOneBy([
                'position' => $photoPosition-1,
                'project' => $project->getId(),
            ]);
        }

        if($photoPosition == $photoCount){
            $nextPhoto = $this->repository->findOneBy([
                'position' => 1,
                'project' => $project->getId(),
            ]);
        }else{
            $nextPhoto = $this->repository->findOneBy([
                'position' => $photoPosition+1,
                'project' => $project->getId(),
            ]);
        }

        $response = array(
            "next" => $nextPhoto,
            "prev" => $prevPhoto
        );
        return $response;
    }

   
}