<?php  // src/App/Form/QuestionType.php

namespace App\Form;

use Forum\Question\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class);
        $builder->add('description', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'empty_data' => function (Options $options) {
                return function (FormInterface $form) use ($options) {
                    return new Question(
                        $form['title']->getData(),
                        $form['description']->getData(),
                        $options['author']
                    );
                };
            },
        ]);

        $resolver->setRequired('author');
        $resolver->setAllowedTypes('author', 'string');
    }
}
