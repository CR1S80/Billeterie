<?php


namespace App\Form;



use App\Entity\Ticket;
use App\Entity\Visit;
use App\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitTicketsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tickets',CollectionType::class, [
            'entry_type' => TicketType::class,
            'allow_add' => true
    ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
            //'validation_groups' => array('identification_registration')
        ));
    }

}