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

    public function klausAction(Request $request, int $customerId)
    {
        return new Response("Deine customer id ist " . $customerId);
    }
}