<?php

namespace Ruian\UploadifyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'label' => 'file.upload',
                'attr'  => array(
                    'class'         => '',
                    'data-session'  => session_id()
                )
            ))
        ;
    }

    public function getName()
    {
        return 'ruian_uploadifybundle_ressourcetype';
    }
}
