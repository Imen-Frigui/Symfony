<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'TITRE' => 'WEB',
        ]);
    }

    #[Route('/show', name: 'app_show')]
    public function show(): Response
    {
        return new Response('Bonne soirée');
    }

    #[Route('/affiche/{name}', name: 'app_affiche')]
    public function affiche($name): Response
    {
        return $this->render('teacher/show.html.twig', [
            'n' => $name,
        ]);
    }
}
