<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Typereclamation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numcmd')
            ->add('idc')
            ->add('nomc')
            ->add('pnomc')
            ->add('mailc')
            ->add('numclient')
            ->add('drc',DateType::class,['widget' => 'single_text','format' => 'yyyy-MM-dd',])
            ->add('obrc')
            ->add('desrec')
            ->add('screenshot',FileType::class,array('label'=>'inserer une image','data_class' => null))

            ->add('Typereclamation', EntityType::class,['class'=>Typereclamation::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}