<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    public function indexAction(Request $request)
    {
        $name = $request->get('name', 'Ich habe keinen namen');

        $customerRepo = $this->getDoctrine()->getRepository(Customer::class);
        $customers = $customerRepo->findAll();

        return $this->render('home/index.html.twig', [
            'name' => $name,
            'customers' => $customers
        ]);
    }

    public function OverviewAction()
    {
        return $this->render('home/overview.html.twig');
    }

    public function AboutAction()
    {
        return $this->render('home/about.html.twig');
    }

    public function GalleryAction(Request $request, int $projectId)
    {
        return $this->render('home/gallery.html.twig');
    }


}
