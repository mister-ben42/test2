<?php


namespace MDQ\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class ResettingFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('captcha', CaptchaType::class, array(
					'as_url' => true,
					'reload' => true,
					'mapped' => false,// pas indispensable
					'width' => 150,
					'height' => 50,
					'length' => 6,
					'invalid_message'=>"Le code visuel est inexact",
						))
		
		
		;
    }

}
