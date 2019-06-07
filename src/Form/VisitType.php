<?php


namespace App\Form;


use App\Entity\Visit;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('visitDate', DateType::class, [
                'label' => 'Date de visite',
                'data' => new \DateTime(),
                'attr' => ['class' => 'js-datepicker'],
                'required' => true,
                'format' => 'dd-MM-yyyy'
            ]
        )
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Journée' => Visit::TYPE_FULL_DAY,
                    'Demi-Journée' => Visit::TYPE_HALF_DAY
            ],
                'label' => 'Type',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('numberOfTicket', ChoiceType::class,['label' => 'Nombre de place','choices' => array_combine(range(1, 10), range(1, 10))]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Visit::class,
            'validation_groups' => array('order_registration')
        ));
    }

}