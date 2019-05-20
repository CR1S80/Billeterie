<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', TextType::class, array(
            'label' => 'Nom',
            'required' => true))
            ->add('Prénom', TextType::class, array(
                'label' => 'label.firstname.visitor',
                'required' => true))
            ->add('country', CountryType::class, array(
                'label' => 'Nationalité',
                'preferred_choices' => array('FR'),
                'required' => true))
            ->add('birthday', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'required' => true))
            ->add('discount', CheckboxType::class, array(
                'label' => 'Prix réduit',
                'required' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class
        ));
    }

}