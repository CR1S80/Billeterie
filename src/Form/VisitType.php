<?php


namespace App\Form;


use App\Entity\Visit;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('visitDate', DateType::class, [
                'label' => 'label.visit.date',

                'attr' => ['class' => 'datepicker'],
                'required' => true,
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'widget' => 'single_text',
            ]
        )
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'label.full.day.ticket' => Visit::TYPE_FULL_DAY,
                    'label.half.day.ticket' => Visit::TYPE_HALF_DAY
            ],
                'label' => 'label.visit.type',
                'expanded' => true,
                'multiple' => false,

            ])
            ->add('numberOfTicket', ChoiceType::class,['label' => 'label.visit.nb.tickets','choices' => array_combine(range(1, 10), range(1, 10))]);


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }

}