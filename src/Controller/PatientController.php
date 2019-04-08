<?php

namespace App\Controller;

use App\Service\PatientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render("Patients/show_all.html.twig", [
            "patients" => $patients
        ]);
    }

    /**
     * @Route ("/new_patient", name="new_patient")
     */
    public function newPatient()
    {

    }
}
