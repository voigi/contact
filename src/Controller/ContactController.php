<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Groupe;
use App\Entity\Telephone;
use App\Form\ContactType;
use App\Form\TelephoneType;
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

			return $this->redirectToRoute('home');

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

		$telephone = new Telephone;

		$telephone->setContact($contact);

		$form = $this->createForm(TelephoneType::class, $telephone);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->entityManager->persist($telephone);
			$this->entityManager->flush();
		}

		return $this->render('contacts\detail.html.twig', ['contact' => $contact,  'formulaire' => $form->createView()]);
	}

	/**
	 * @Route ("contact/list", name = "contact_list",requirements={"id"="\d+"})
	 */
	public function getList(Request $request)
	{
		$contactList = $this->contactRepository->findAll();

		return $this->render('contacts\list.html.twig', ['contactList' => $contactList]);
	}
}