<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('nom', TextType::class, ['label' => 'Veuillez entrer votre nom']);
		$builder->add('prenom', TextType::class, ['label' => 'Veuillez entrer votre prenom']);
		$builder->add('email', EmailType::class, ['label' => 'Veuillez entrer votre email']);
		$builder->add('password', RepeatedType::class, [
			'type' => PasswordType::class,
			'invalid_message' => 'Les mots de passe doivent être identiques',
			'required' => true,
			'first_options' => ['label' => 'Mot de passe  '],
			'second_options' => ['label' => ' Repeter mot de passe'],
		]);
		$builder->add('inscription', SubmitType::class, ['label' => 'Inscription']);
	}
}