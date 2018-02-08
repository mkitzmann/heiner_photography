<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{

    public function GalleryAction(Request $request, string $projectTitle)
    {
        return $this->render('home/gallery.html.twig');
    }
}