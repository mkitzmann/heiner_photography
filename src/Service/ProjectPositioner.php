<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;

class ProjectPositioner
{
    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository(Project::class);
    }

    public function changePosition(Project $project, $position)
    {
        $projectsRepo = $this->repository;

        //get total no of projects
        $allProjects = $projectsRepo->findAll();
        $totalProjects = count($allProjects);

        //check if sorting is ok + set position for each project
        foreach ($allProjects as $singleProject) {
            $currentPosition = $singleProject->getPosition();
            if ($currentPosition > $totalProjects) {
                throw new \Exception('position of project with id ' .
                    $singleProject->getId() . ' higher then total');
            } elseif ($currentPosition == $project->getPosition()) {
            } elseif ($currentPosition >= $position and $currentPosition < $project->getPosition()) {
                $singleProject->setPosition(($currentPosition + 1));
                //dump($singleProject);
            } elseif ($currentPosition <= $position and $currentPosition > $project->getPosition()) {
                $singleProject->setPosition(($currentPosition - 1));
                //dump($singleProject);
            }
        }

        $project->setPosition($position);
        $this->em->flush();

        return ('Set position of project with id ' .
            $project->getId() . ' to position ' .
            $position);
    }
}