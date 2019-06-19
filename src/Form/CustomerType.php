<?php


namespace App\Form;

use App\Entity\Customer;
use App\Entity\Ticket;
use App\Entity\Visit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class CustomerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', TextType::class, [
            'label' => 'label.lastname.customer',
            'required' => true])
            ->add('firstname', TextType::class, [
                'label' => 'label.firstname.customer',
                'required' => true])
            ->add('email', EmailType::class, [
                'label' => 'label.email.customer',
                'required' => true])
            ->add('adress', TextType::class, [
                'label' => 'label.adress.customer',
                'required' => true])
            ->add('postalCode', TextType::class, [
                'label' => 'label.postalCode.customer',
                'required' => true])
            ->add('city', TextType::class, [
                'label' => 'label.city.customer',
                'required' => true])
            ->add('country', CountryType::class, [
                'label' => 'label.country.customer',
                'preferred_choices' => ['FR']]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'validation_groups' => '[address]'
        ]);
    }


}