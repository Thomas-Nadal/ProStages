<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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
    public function index(StageRepository $repStage)
    {
        // Récupérer les stages enregistrées en BD
        $stages = $repStage->findAll();
		
        return $this->render('pro_stages/index.html.twig', [
            'controller_name' => 'ProStagesController',
			'stages' => $stages,
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
	
	
	/**
     * @Route("pro_stages/{nomEntreprise}", name="ProStages_Stages_Par_Nom_Entreprise")
     */
    public function stagesParNomEntreprise(StageRepository $repositoryStage, $nomEntreprise)
    {
        // Récupérer les stages enregistrées en BD avec le nom de l'entreprise "nomEntreprise"
        $stages = $repositoryStage->findByNomEntreprise($nomEntreprise);
		
        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',['stages' => $stages]);
    }
	
	
	/**
     * @Route("pro_stages/{nomFormation}", name="ProStages_Stages_Par_Nom_Formation")
     */
    public function stagesParNomFormation(StageRepository $repositoryStage, $nomFormation)
    {
        // Récupérer les stages enregistrées en BD avec le nom de l'entreprise "nomFormation"
        $stages = $repositoryStage->findByNomFormation($nomFormation);
		
        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',['stages' => $stages]);
    }
	
	/**
     * @Route("ajouter_entreprise", name="ProStages_AjouterEntreprise")
     */
	public function ajouterEntreprise(Request $request, ObjectManager $manager){
		//Création de l'objet entreprise
		$entreprise = new Entreprise();
		
		//Création du formulaire de création d'entreprise
		$formulaireCreationEntreprise = $this -> createFormBuilder($entreprise)
											  -> add('nom')
											  -> add('activite')
											  -> add('adresse')
											  -> add('adresseWeb')
											  -> getForm();
		
		$formulaireCreationEntreprise->handleRequest($request);
		
		if($formulaireCreationEntreprise->isSubmitted()){
			//injecter les données en BD
			$manager->persist($entreprise);
			$manager->flush();
			
			//rediriger utilisateur vers la page entreprises
			return $this->redirectToRoute("ProStages_Entreprises");
		}
		
		//envoi du formulaire à la vue
		return $this->render('pro_stages/ajouterModifierEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireCreationEntreprise->createView(), 'action' => 'ajouter']);
	}
	
	/**
     * @Route("modifier_entreprise/{id}", name="ProStages_ModifierEntreprise")
     */
	public function modifierEntreprise(Request $request, ObjectManager $manager, Entreprise $entreprise){
		
		//Création du formulaire de modification d'entreprise
		$formulaireModificationEntreprise = $this -> createFormBuilder($entreprise)
											  -> add('nom')
											  -> add('activite')
											  -> add('adresse')
											  -> add('adresseWeb')
											  -> getForm();
		
		$formulaireModificationEntreprise->handleRequest($request);
		
		if($formulaireModificationEntreprise->isSubmitted()){
			//injecter les données en BD
			$manager->persist($entreprise);
			$manager->flush();
			
			//rediriger utilisateur vers la page entreprises
			return $this->redirectToRoute("ProStages_Entreprises");
		}
		
		//envoi du formulaire à la vue
		return $this->render('pro_stages/ajouterModifierEntreprise.html.twig',['vueFormulaireEntreprise' => $formulaireModificationEntreprise->createView(), 'action' => 'modifier']);
	}
	
	

	
	
	
	
}
