<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class ContactType
 * @package AppBundle\Admin\Form\Type
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Insert your name',
                    'autocomplete' => 'off',
                ]
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'So we can contact you',
                    'autocomplete' => 'off',
                ]
            ])
            ->add('message', 'textarea', [
                'label' => 'Message',
                'attr' => [
                    'cols' => 90,
                    'rows' => 10,
                    'placeholder' => 'What do you need?',
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection([
            'name' => [
                new NotBlank(),
            ],
            'email' => [
                new NotBlank(),
                new Email(),
            ],
            'message' => [
                new NotBlank(),
                new Length(['min' => 5]),
            ],
        ]);

        $resolver->setDefaults([
            'constraints' => $collectionConstraint
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }
}
