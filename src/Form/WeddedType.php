<?php

namespace App\Form;

use App\Entity\Wedded;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeddedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mary', TextType::class, [
                'label' => 'Le Marie',
            ])
            ->add('wife', TextType::class, [
                'label' => 'La Femme',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => '6'],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('weddAt', DateType::class, [
                'label' => 'Date du mariage',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'peer input w-full'],
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => FileType::class,
                'label' => false,
                'entry_options' => ['attr' => ['class' => 'input']],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wedded::class,
        ]);
    }
}
