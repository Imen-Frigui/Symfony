<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Student;
use App\Form\StudentFormType;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/readStudent', name: 'app_readS')]
    public function readStudent(StudentRepository $r): Response
    {  
        //Utiliser findAll()
        $students=$r->findAll();
        return $this->render('student/readS.html.twig', [
            's' => $students,
        ]);
    }

    #[Route('/addStudent', name: 'app_addS')]
    public function addStudent(ManagerRegistry $doctrine,
    Request $request)
{
    $student= new Student();
$form=$this->createForm(StudentFormType::class,$student);
                   $form->handleRequest($request);
                   if($form->isSubmitted()){
                    //Action d'ajout
                       $em =$doctrine->getManager() ;
                       $em->persist($student);
                       $em->flush();
            return $this->redirectToRoute("app_readS");
        }
    return $this->renderForm("student/addS.html.twig",
                       array("f"=>$form));
                   }

}
