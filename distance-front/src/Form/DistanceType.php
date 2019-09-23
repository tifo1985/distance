<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class DistanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class)
            ->add('postcode', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('ipAddress', TextType::class)
        ;
    }
}