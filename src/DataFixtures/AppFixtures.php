<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {		
		//CREER DES USERS
		$thomas_admin = new User();
		$thomas_admin->setUsername("thomas_admin");
		$thomas_admin->setPassword('$2y$10$DSUjCDbQHnoTKJWfvEgt5eq6gAIIBozE2tNqJoRlLJ2KySSMuY/3O');
		$thomas_admin->setRoles(["ROLE_ADMIN"]);
		$manager->persist($thomas_admin);
		
		$thomas_user = new User();
		$thomas_user->setUsername("thomas_user");
		$thomas_user->setPassword('$2y$10$E3HPrjCcAFlQZ1vmaab4X.Mx7IdkyRYnygyaljZCAnRkbGilqMFQy');
		$thomas_user->setRoles(["ROLE_USER"]);
		$manager->persist($thomas_user);
		
		//utiliser faker pour générer des données
		$faker = \Faker\Factory::create('fr_FR');
		
		//CREER DES ENTREPRISES
				$listeEntreprises = array();
		
				$nbEntreprisesAGenerer = $faker->numberBetween(0,9);
				
				for($numEnt = 0; $numEnt < $nbEntreprisesAGenerer; $numEnt++){
					//Création d'un Stage
					$entreprise = new Entreprise();
					$entreprise->setNom($faker->company);
					$entreprise->setActivite($faker->jobTitle);
					$entreprise->setAdresse($faker->address);
					$entreprise->setAdresseWeb($faker->url);
					
					//ajout de l'entreprise à la liste des entreprises
					$listeEntreprises[$numEnt] = $entreprise;
				}
				
				//Mise en persistence des objets entreprise
				foreach($listeEntreprises as $entreprise){
					$manager->persist($entreprise);
				}
		
		
		//CREER 3 FORMATIONS
			$listeFormations = array(
				"DUT Informatique" => "DUT INFO",
				"DUT Universitaire en Technologies de l'information et de la Communication" => "DUT TIC",
				"Licence Professionnelle Multimédia" => "LP MM",
			);
			
			foreach($listeFormations as $nomLongFormation => $nomCourtFormation){
			
				//génération d'un tuple test de Formation
				$formation = new Formation();
				$formation->setNomCourt($nomCourtFormation);
				$formation->setNomLong($nomLongFormation);
				//$formation->addStage();
				
				$manager->persist($formation);
			
				//CREER LES STAGES ASSOCIES AUX FORMATIONS
						
						$nbStagesAGenerer = $faker->numberBetween(0,9);
						
						for($numStage = 0; $numStage < $nbStagesAGenerer; $numStage++){
							//Création d'un Stage
							$stage = new Stage();
							$stage->setTitre($faker->jobTitle);
							$stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
							$stage->setContact($faker->regexify('06 ([0-9][0-9] ){4}'));
								//création de la relation Stage --> Formation
							$stage->addFormation($formation);
							
							
							//Créer la relation Stage --> Entreprise
							$numEntreprise = $faker->numberBetween(0,($nbEntreprisesAGenerer-1));
							$stage->setEntreprise($listeEntreprises[$numEntreprise]);
							$listeEntreprises[$numEntreprise]->addStage($stage);
						
							$manager->persist($stage);
							$manager->persist($listeEntreprises[$numEntreprise]);
						}
			}
		
		//ENVOI DES OBJETS CREES A LA BD
        $manager->flush();
    }
}
