<?php

namespace App\Controller;

use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }



    /**
     * @Route("/inscription", name="app_inscription")
     */
	public function inscription(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
		//Création de l'objet utilisateur
		$utilisateur = new User();
		
		//Création du formulaire de création de l'utilisateur
		$formulaireCreationUtilisateur = $this -> createForm(UserType::class, $utilisateur);
		
		$formulaireCreationUtilisateur->handleRequest($request);
		
		if($formulaireCreationUtilisateur->isSubmitted() && $formulaireCreationUtilisateur->isValid()){
            //attribuer rôle à utilisateur
            $utilisateur->setRoles(['ROLE_USER']);

            //encoder mdp utilisateur
            $encodagePassword = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($encodagePassword);

			//Enregistrer utilisateur en BD
			$manager->persist($utilisateur);
			$manager->flush();
			
			//rediriger utilisateur vers la page d'accueil
			return $this->redirectToRoute("app_login");
		}
		
		//envoi du formulaire à la vue
		return $this->render('security/inscription.html.twig',['vueFormulaire' => $formulaireCreationUtilisateur->createView()]);
	}

}
