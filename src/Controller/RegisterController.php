<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
	private $entityManager;

	private $usersRepository;

	private $userPasswordEncoderInterface;

	public function __construct(EntityManagerInterface $entityManager, UserRepository $usersRepository, UserPasswordEncoderInterface $encoder)
	{
		$this->entityManager = $entityManager;
		$this->userRepository = $usersRepository;
		$this->userPasswordEncoderInterface = $encoder;
	}

	/**
	 * @Route("/utilisateur/create", name="utilisateur_create")
	 */
	public function create(Request $request)
	{
		$user = new User();
		$form = $this->createForm(RegisterType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//bien penser à encoder le mot de passe avec le UserPasswordEncoder !!!!
			$encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
			$user->setPassword($encodedPassword); //set du password encodé
			$user->setRoles(['ROLE_USER']); //définition des roles de l'utilisateur
			$this->entityManager->persist($user);
			$this->entityManager->flush();

			//return $this->redirectToRoute('app_login');

			// return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
		}

		return $this->render('utilisateurs/create.html.twig', ['formulaire' => $form->createView()]);
	}
}