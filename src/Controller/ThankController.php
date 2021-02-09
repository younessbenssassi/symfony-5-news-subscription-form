<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThankController extends AbstractController
{
    /**
     * @Route("/thank", name="thank")
     */
    public function index(): Response
    {
        return $this->render('thank/index.html.twig', [
            'controller_name' => 'ThankController',
        ]);
    }
}
