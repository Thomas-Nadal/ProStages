<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

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
    public function entreprises(EntrepriseRepository $repEntreprise)
    {
        // Récupérer les entreprises enregistrées en BD
        $entreprises = $repEntreprise->findAll();
		
        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/listeEntreprises.html.twig',['name' => 'Entreprises','entreprises' => $entreprises]);
    }

    /**
     * @Route("/formations", name="ProStages_Formations")
     */
    public function formations(FormationRepository $repFormation)
    {
        // Récupérer les formations enregistrées en BD
        $formations = $repFormation->findAll();
		
        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/listeFormations.html.twig',['name' => 'Formations','formations' => $formations]);
    }

    /**
     * @Route("pro_stages/", name="ProStages_Stages")
     */
    public function stages(StageRepository $repStage)
    {
        // Récupérer les stages enregistrées en BD
        $stages = $repStage->findAll();
		
        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',['stages' => $stages]);
    }
}
