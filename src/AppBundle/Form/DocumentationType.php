<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Vich\UploaderBundle\Form\Type\VichImageType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class DocumentationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('description', CKEditorType::class)
            ->add('titre', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control',
                    'autocomplete'  => 'off',
                )
          ))
            ->add('statut')
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true,
            ))
            ->add('departement', null, array(
                'attr'  => array(
                    'class' => 'form-control',
                )
          ))
            //->add('imageName')->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Documentation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_documentation';
    }


}
