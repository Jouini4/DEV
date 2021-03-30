<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_event')
            ->add('description_event')
            ->add('lieu_event')
            ->add('date',DateType::class,['widget' => 'single_text'])
            ->add('prix_event')
            ->add('nbr_place')
            ->add('image',FileType::class,array('label'=>'inserer une image',
                'data_class' => null));

        ;
    }


}
