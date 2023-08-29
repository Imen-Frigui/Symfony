<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ClassroomFormType;


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

 #[Route('/supprimerC/{id}', name: 'supprimerC')]
    public function supprimerC($id,ClassroomRepository $r): Response
    {
        //Récupérer classroom à supprimer
        $classroom=$r->find($id);
        //Action de suppression
     //récupérer entity manager
     $em=$this->getDoctrine()->getManager();
     //supprimer
     $em->remove($classroom);
     $em->flush();
        return $this->redirectToRoute('afficheClassroom');
    }

    #[Route('/addclassroom', name: 'addclassroom')]
    public function addclassroom(ManagerRegistry $doctrine,Request $request){
  $classroom= new Classroom();
  $form=$this->createForm(ClassroomFormType::class,$classroom);
  $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute("afficheC");}
        return $this->renderForm("classroom/addClassroom.html.twig",
            array("f"=>$form));
     }


     #[Route('/modifierclassroom/{id}', name: 'ModifierC')]
    public function modifierclassroom(ManagerRegistry $doctrine,Request $request,ClassroomRepository $r,$id)
   {
    //Récupérer classroom à modifier
   $classroom=$r->find($id);
  $form=$this->createForm(ClassroomFormType::class,$classroom);
  $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $em->flush();
            return $this->redirectToRoute("afficheC");}
        return $this->renderForm("classroom/addClassroom.html.twig",
            array("f"=>$form));
     }

}
