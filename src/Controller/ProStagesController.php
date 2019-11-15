<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="ProStage_Accueil")
     */
    public function index()
    {
        return $this->render('pro_stages/index.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }

    /**
     * @Route("/entreprises", name="ProStage_Entreprises")
     */
    public function afficherListeEntreprises()
    {
        return $this->render('pro_stages/listeEntreprises.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }
}
