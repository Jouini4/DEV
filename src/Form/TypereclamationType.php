<?php

namespace App\Form;

use App\Entity\Typereclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class TypereclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tyrc', ChoiceType::class, [
                'choices'  => [
                    'reclamation' => 'reclamation',
                    'livraison' => 'livraison',
                    'autres' => 'autres',
                ],
            ])
            ->add('etrc')
            ->add('comrc')
            ->add('ida')
            ->add('color', ColorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Typereclamation::class,
        ]);
    }
}
