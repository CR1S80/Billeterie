<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', TextType::class, [
            'label' => 'label.lastname',
            'required' => true,
            'constraints' => [
                new NotBlank(['message' => 'constraint.contactType_lastname_notBlank'])
            ]])
            ->add('firstname', TextType::class, [
                'label' => 'label.firstname',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'constraint.contactType_firstname_notBlank'])
                ]])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'constraint.contactType_email_notBlank']),
                    new Email(['strict' => true, 'message' => "constraint.contactType_email_valide"])
                ]])
            ->add('subject', TextType::class, [
                'label' => 'label.subject',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'constraint.contactType_subject_notBlank'])]

            ])
            ->add('message', TextareaType::class, [
                'label' => 'label.message',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'constraint.contactType_message_notBlank'])
                ]]);
    }
    public function getName()
    {
        return 'Contact';
    }
}