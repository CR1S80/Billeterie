<?php


namespace App\Form;


use App\Entity\Ticket;
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
        $builder->add('')
            ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'required' => true])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true])
            ->add('country', CountryType::class, [
                'label' => 'Nationalité',
                'preferred_choices' => ['FR'],
                'required' => true])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'required' => true])
            ->add('discount', CheckboxType::class, [
                'label' => 'Prix réduit',
                'required' => false
            ]);
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