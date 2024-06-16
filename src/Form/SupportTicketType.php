<?php

namespace App\Form;

use App\Entity\SupportTicket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, ['label' => 'Escribe tu nombre'])
            ->add('email', EmailType::class, ['label' => 'Escribe tu corre'])
            ->add('mensaje', TextareaType::class, ['label' => 'Mensage']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportTicket::class,
        ]);
    }
}
