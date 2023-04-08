<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
//Affichage : 1ere solution
    #[Route('/afficheC', name: 'afficheC')]
    public function afficheC(): Response
    {//récupérer le repo
        $repo=$this->getDoctrine()->getRepository(Classroom::class);
       //utiliser la fonction findAl()
        $classrooms=$repo->findAll();
        return $this->render('classroom/afficheC.html.twig', [
            'c' => $classrooms,
        ]);
    }
 //Affichage : 2eme solution
 #[Route('/afficheClassroom', name: 'afficheClassroom')]
 public function afficheClassroom(ClassroomRepository $r): Response
 {
    //utiliser la fonction findAl()
     $classrooms=$r->findAll();
     return $this->render('classroom/afficheC.html.twig', [
         'c' => $classrooms,
     ]);
 }   

 #[Route('/supprimerC/{id', name: 'supprimerC')]
    public function supprimerC($id): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
}
