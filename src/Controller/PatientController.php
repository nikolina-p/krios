<?php

namespace App\Controller;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Entity\XRayFile;
use App\Exception\EntityNotDeletedException;
use App\Form\PatientForm;
use App\Form\SearchForm;
use App\Form\UploadForm;
use App\Service\PatientService;
use App\Service\XRayFileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PatientController extends AbstractController
{
    private $patientService;

    private $xRayFileService;

    public function __construct(PatientService $patientService, XRayFileService $xRayFileService)
    {
        $this->patientService = $patientService;
        $this->xRayFileService = $xRayFileService;
    }

    /**
     * @Route ("/", name = "homepage")
     * @Security("is_granted('ROLE_USER')")
     */
    public function showAll(Request $request)
    {
        $form = $this->createForm(SearchForm::class, $patientDTO = new PatientDTO());

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $patients = $this->patientService->searchPatients($patientDTO);
        } else {
            $patients = $this->patientService->findAll();
        }

        return $this->render("patients/show_all.html.twig", [
            "patients" => $patients,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route ("/new_patient", name="new_patient")
     * @Security("is_granted('ROLE_USER')")
     */
    public function newPatient(Request $request)
    {
        $patient = new Patient();
        $patient->setGender('MALE');
        $patient->setRegistrationDate(new \DateTime('now'));
        $form = $this->createForm(PatientForm::class, $patient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->patientService->newPatient($patient);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('patients/patient_form.html.twig', array(
            'form' => $form->createView(), 'patient' => $patient
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit_patient")
     * @Security("is_granted('ROLE_USER')")
     */
    public function editPatient(Request $request, Patient $patient)
    {
        $form = $this->createForm(PatientForm::class, $patient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->patientService->saveChanges($patient);
            return $this->redirectToRoute('homepage');
        }

        return $this->render('patients/patient_form.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient
        ]);

    }

    /**
     * @Route("/patient/{id}", name="show_patient")
     * @Security("is_granted('ROLE_USER')")
     */
    public function loadPatient(Request $request, Patient $patient)
    {
        $form = $this->createForm(UploadForm::class,
            $xRayFile = (new XRayFile())->setDate(new \DateTime('now'))
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $xRayFile->setPatient($patient);
            $patient->addXRayFile($xRayFile);
            $this->xRayFileService->uploadXRayFile($xRayFile);
            return $this->redirectToRoute('show_patient', [
                'id' => $patient->getId()
            ]);
        }

        return $this->render('patients/patient_data.html.twig',[
            "patient" => $patient,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/file/delete/{id}", name="delete_file")
     * @Security("is_granted('ROLE_USER')")
     */
    public function deleteXRayFile(int $id)
    {
        try {
            $this->patientService->deleteXRayFile($id);
            return new Response(null, 204);
        } catch (EntityNotDeletedException $exception) {
            return new Response($exception->getMessage(), 400);
        }
    }
}
