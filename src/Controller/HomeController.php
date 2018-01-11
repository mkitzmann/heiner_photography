<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function indexAction(Request $request)
    {
        $name = $request->get('name', 'Ich habe keinen namen');

        return $this->render('home/index.html.twig', [
            'name' => $name,
            'customers' => [],
        ]);
    }

    public function klausAction(Request $request, int $customerId)
    {
        return new Response("Deine customer id ist " . $customerId);
    }
}