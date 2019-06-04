<?php


namespace App\Form;

use App\Entity\Customer;
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
            'label' => 'Nom',
            'required' => true])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'required' => true])
            ->add('postalCode', TextType::class, [
                'label' => 'Code Postal',
                'required' => true])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => true])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'preferred_choices' => ['FR']]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Customer::class
        ));
    }


}