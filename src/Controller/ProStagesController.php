<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="ProStages_Accueil")
     */
    public function index()
    {
        return $this->render('pro_stages/index.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }

    /**
     * @Route("/entreprises", name="ProStages_Entreprises")
     */
    public function afficherListeEntreprises()
    {
        return $this->render('pro_stages/listeEntreprises.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }

    /**
     * @Route("/formations", name="ProStages_Formations")
     */
    public function afficherListeFormations()
    {
        return $this->render('pro_stages/listeFormations.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }

    /**
     * @Route("/stages", name="ProStages_Stages")
     */
    public function afficherStage()
    {
        return $this->render('pro_stages/listeStages.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }
}
