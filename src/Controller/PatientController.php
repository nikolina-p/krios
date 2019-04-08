<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientForm;
use App\Service\PatientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    private $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * @Route ("/", name = "homepage")
     */
    public function showAll()
    {
        $patients = $this->patientService->findAll();

        return $this->render("patients/show_all.html.twig", [
            "patients" => $patients
        ]);
    }

    /**
     * @Route ("/new_patient", name="new_patient")
     */
    public function newPatient(Request $request)
    {
        $form = $this->createForm(PatientForm::class, $patient = new Patient());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->patientService->newPatient($patient);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('patients/patient_form.html.twig', array(
            'form' => $form->createView(), 'patient' => $patient
        ));


    }
}
