<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
	private $entityManager;

	private $contactRepository;

	public function __construct(EntityManagerInterface $entityManager, ContactRepository $contactsRepository)
	{
		$this->entityManager = $entityManager;
		$this->contactRepository = $contactsRepository;
	}

	/**
	 * @Route("contact/create", name="contact_create")
	 */
	public function create_contact(Request $request)
	{
		$contact = new Contact();
		$form = $this->createForm(ContactType::class, $contact);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($contact);
			$this->entityManager->flush();

			//return $this->redirectToRoute('app_login');

			// return $this->redirectToRoute('commentaires_details', ['id' => $commentaire->getId()]);
		}

		return $this->render('contacts/create.html.twig', ['formulaire' => $form->createView()]);
	}

	/**
	 * @Route ("contact/{id}", name = "contact_detail",requirements={"id"="\d+"})
	 */
	public function getDetails(Request $request, int $id)
	{
		$contact = $this->contactRepository->find($id);

		return $this->render('contacts\detail.html.twig', ['contact' => $contact, ]);
	}
}