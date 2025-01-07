<?php

// src/Form/TaskType.php
namespace App\Form;

use App\Entity\Task;
use App\Entity\Collaboration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la tâche',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('collaboration', EntityType::class, [
                'class' => Collaboration::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une collaboration',
                'attr' => ['class' => 'form-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}

