<?php


namespace App\Form;


use App\Entity\Customer;
use App\Entity\Ticket;
use DateTime;
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
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', TextType::class, [
            'label' => 'label.lastname.visitor',
            'required' => true])
            ->add('firstname', TextType::class, [
                'label' => 'label.firstname.visitor',
                'required' => true])
            ->add('country', CountryType::class, [
                'label' => 'label.country.visitor',
                'preferred_choices' => ['FR'],
                'required' => true])
            ->add('birthday', BirthdayType::class, [
                'label' => 'label.birthday.visitor',
                'required' => true,
                'attr' => ['class' => 'datepicker'],

                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'widget' => 'single_text',

                ])
            ->add('reducedPrice', CheckboxType::class, [
                'label' => 'label.discount.visitor',
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