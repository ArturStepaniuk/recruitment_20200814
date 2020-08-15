<?php

namespace AppBundle\Form;

use AppBundle\Entity\BlogPost;
use AppBundle\Entity\BlogPostSocialTarget;
use AppBundle\Entity\Enum\BlogPostSocialTargetEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogPostTargetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('target',ChoiceType::class,[
            'choices' =>BlogPostSocialTargetEnum::getTargetGlossary()
        ]);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BlogPostSocialTarget::class,
            'csrf_protection'=>false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_blogpost';
    }


}
