<?php

namespace App\Controller;

use App\Entity\Contact;
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
	 * @Route ("groupe/{id}", name = "detail_groupe",requirements={"id"="\d+"})
	 */
	public function getDetails(Request $request, int $id)
	{
		$groupe = $this->groupeRepository->find($id);
		// foreach ($groupe->getContacts() as $contact) {
		// 	dump($contact);
		// }

		return $this->render('groupes\detail.html.twig', ['groupe' => $groupe]);
	}

	/**
	 * @Route("groupe/create", name="groupe_create")
	 */
	public function create_groupe(Request $request)
	{
		$groupe = new Groupe();
		$form = $this->createForm(GroupeType::class, $groupe);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($groupe);
			$this->entityManager->flush();

			return $this->redirectToRoute('groupe_valide');

			// return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
		}

		return $this->render('groupes/create.html.twig', ['formulaire' => $form->createView()]);
	}

	/**
	* @Route ("groupe/list", name = "groupe_list",requirements={"id"="\d+"})
	*/
	public function getList(Request $request)
	{
		$groupeList = $this->groupeRepository->findAll();

		return $this->render('groupes\list.html.twig', ['groupeList' => $groupeList]);
	}

	/**
	 * @Route("groupe/validate",name ="groupe_valide")
	 */
	public function validate_groupe(Request $request)
	{
		return $this->render('groupes/validate.html.twig');
	}
}