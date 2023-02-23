<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Classroom;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/readC', name: 'app_readC')]
    public function readC(): Response
    {
        //récupérer le repository 
        $r=$this->getDoctrine()->getRepository(Classroom::class);
        //Utiliser findAll()
        $classrooms=$r->findAll();
        return $this->render('classroom/readC.html.twig', [
            'c' => $classrooms,
        ]);
    }

    #[Route('/deleteC/{id}', name: 'app_deleteC')]
    public function delecteC($id, ClassroomRepository $rep, 
    ManagerRegistry $doctrine): Response
    {
        //récupérer la classe à supprimer
        $classroom=$rep->find($id);
        //Action de suppression
        //récupérer l'Entitye manager
        $em=$doctrine->getManager();
        $em->remove($classroom);
        //La maj au niveau de la bd
        $em->flush();
        return $this->redirectToRoute('app_readC');
    }
    #[Route('/addC', name: 'app_addC')]
    public function addC(ManagerRegistry $doctrine,
    Request $request)
{
    $classroom= new Classroom();
$form=$this->createForm(ClassroomFormType::class,$classroom);
                   $form->handleRequest($request);
                   if($form->isSubmitted()){
                    //Action d'ajout
                       $em =$doctrine->getManager() ;
                       $em->persist($classroom);
                       $em->flush();
            return $this->redirectToRoute("app_readC");
        }
    return $this->renderForm("classroom/addC.html.twig",
                       array("f"=>$form));
                   }

 #[Route('/updateC/{id}', name: 'app_updateC')]
  public function updateC($id,ClassroomRepository $rep,
  ManagerRegistry $doctrine,Request $request)
               {
      //récupérer la classe à modifier
      $classroom=$rep->find($id);
    $form=$this->createForm(ClassroomFormType::class,$classroom);
                 $form->handleRequest($request);
                if($form->isSubmitted()){
             //Action de MAJ
                 $em =$doctrine->getManager() ;
                $em->flush();
             return $this->redirectToRoute("app_readC");
                       }
        return $this->renderForm("classroom/addC.html.twig",
                                      array("f"=>$form));
                                  }
}
