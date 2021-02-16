<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\GroupeType;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupeController extends AbstractController
{
	private $entityManager;

	private $groupeRepository;

	public function __construct(EntityManagerInterface $entityManager, GroupeRepository $groupeRepository)
	{
		$this->entityManager = $entityManager;
		$this->groupeRepository = $groupeRepository;
	}

	/**
	 * @Route("groupe/create", name="groupe_create")
	 */
	public function create_contact(Request $request)
	{
		$groupe = new Groupe();
		$form = $this->createForm(GroupeType::class, $groupe);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($groupe);
			$this->entityManager->flush();

			//return $this->redirectToRoute('app_login');

			// return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
		}

		return $this->render('groupes/create.html.twig', ['formulaire' => $form->createView()]);
	}
}