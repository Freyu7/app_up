<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Control1Controller extends AbstractController
{
    /**
     * @Route("/control1", name="control1")
     */
    public function index()
    {
        return $this->render('control1/index.html.twig', [
            'controller_name' => 'Control1Controller',
        ]);
    }
}
