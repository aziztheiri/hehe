<?php

namespace App\Controller;

use App\Form\PatientType;
use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class PatientController extends AbstractController
{
    #[Route('patient', name: 'new_app_patient')]
    public function addPatient(Request $request, ManagerRegistry $doctrine): Response
    {
        $patient = new Patient();
        $form=$this->createform(PatientType::class, $patient);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager = $doctrine->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            return new Response('patient ajouté !');
        }
        return $this->renderForm('patient/add.html.twig',[
            'form'=>$form,
            'controller_name'=>'Add Patient'
            
        ]);
      
    }
    #[Route('list', name: 'new_app_list')]
    public function patient_list(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Patient::class);
        $patients = $repository->findAll();
        return $this->render('PatientList.html.twig',array('patients'=>$patients));

    }
    #[Route('edit/{id}', name: 'patient_edit')]
    public function edit(ManagerRegistry $doctrine,Request $request,Patient $patient){
        $form=$this->createform(PatientType::class, $patient);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return new Response('patient modifié !');
        }
        return $this->renderForm('patient/add.html.twig',[
            'form'=>$form,
            'controller_name'=>'Add Patient'
            
        ]);

    }
}
