<?php

namespace App\Form;

use App\Entity\Groupe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('nom', TextType::class, ['label' => 'Veuillez entrer votre nom']);
		$builder->add('prenom', TextType::class, ['label' => 'Veuillez entrer votre prenom']);
		$builder->add('groupe', EntityType::class, [
			'class' => Groupe::class,
			'label' => 'groupe',
			'choice_label' => 'nom',
			'multiple' => true,
			'expanded' => true,
		]);
		$builder->add('enregistrer', SubmitType::class, ['label' => 'enregistrer']);
	}
}