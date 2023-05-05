<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Form\StudentFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use App\Form\SearchStudentFormType;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/afficheStudent', name: 'afficheStudent')]
 public function afficheStudent(StudentRepository $r): Response
 {
    //utiliser la fonction findAl()
     $students=$r->findAll();
     return $this->render('student/afficheS.html.twig', [
         's' => $students,
     ]);
 } 

 #[Route('/addStudent', name: 'addStudent')]
 public function addStudent(ManagerRegistry $doctrine,Request $request)
 {
$student= new Student();
$form=$this->createForm(StudentFormType::class,$student);
$form->handleRequest($request);
     if($form->isSubmitted()){
         $em =$doctrine->getManager() ;
         $em->persist($student);
         $em->flush();
         return $this->redirectToRoute("afficheStudent");}
     return $this->renderForm("student/addStudent.html.twig",
         array("f"=>$form));
  }


  #[Route('/afficheStudentEmail', name: 'afficheStudentEmail')]
  public function afficheStudentEmail(StudentRepository $r): Response
  {
     //utiliser la fonction findByEmail()
      $students=$r->findByEmail();
      return $this->render('student/afficheSemail.html.twig', [
          's' => $students,
      ]);
  } 

  #[Route('/searchStudentByAVG', name: 'searchStudentByAVG')]
  public function searchStudentByAVG(Request $request,StudentRepository $student){

          $students= $student->findByEmail();
          $searchForm = $this->createForm(SearchStudentFormType::class);
          $searchForm->handleRequest($request);
          if ($searchForm->isSubmitted()) {
          //récupérer le contenu de l'input min
              $minMoy=$searchForm['min']->getData();
              $maxMoy=$searchForm['max']->getData();
              $resultOfSearch = $student->searchByAVG($minMoy,$maxMoy);
              return $this->renderForm('student/searchStudentByAVG.html.twig', [
                  'Students'=>$resultOfSearch,
                  'searchStudentByAVG' => $searchForm,]);
          }
return $this->renderForm('student/searchStudentByAVG.html.twig',
array('Students' => $students,'searchStudentByAVG'=>$searchForm,
              ));

}
}
