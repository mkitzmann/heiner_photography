<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Photo;
use App\Entity\Project;

class PhotoPositioner
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository(Photo::class);
    }

    public function adjacentPhotos(Project $project, Photo $photo)
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
                'position' => ($photoPosition - 1),
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
                'position' => ($photoPosition + 1),
                'project' => $project->getId(),
            ]);
        }

        $response = array(
            "next" => $nextPhoto,
            "prev" => $prevPhoto
        );
        return $response;
    }

    public function changePosition(Photo $photo, $position)
    {
        $repo = $this->repository;

        //get total no of projects
        $allProjects = $repo->findAll();
        $totalProjects = count($allProjects);

        //check if sorting is ok + set position for each project
        foreach ($allProjects as $singleProject) {
            $currentPosition = $singleProject->getPosition();
            if ($currentPosition > $totalProjects) {
                throw new \Exception('position of photo with id ' .
                    $singleProject->getId() . ' higher then total');
            } elseif ($currentPosition == $photo->getPosition()) {
            } elseif ($currentPosition >= $position and $currentPosition < $photo->getPosition()) {
                $singleProject->setPosition(($currentPosition + 1));
                //dump($singleProject);
            } elseif ($currentPosition <= $position and $currentPosition > $photo->getPosition()) {
                $singleProject->setPosition(($currentPosition - 1));
                //dump($singleProject);
            }
        }

        $photo->setPosition($position);
        $this->em->flush();

        return ('Set position of photo with id ' .
            $photo->getId() . ' to position ' .
            $position);
    }
}