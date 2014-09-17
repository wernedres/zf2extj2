<?php

namespace SONUser\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress as EmailValidator;


class UserFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array('isEmpty' => 'Nome nao pode esta em branco'),
                    )
                )
            )
                )
        );


        $validator = new EmailValidator();
        $validator->setOptions(array('domain' => false));

        $this->add(array(
            'name' => 'email',
            'validators' => array($validator)
          )
        );

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array('isEmpty' => 'Senha nao pode esta em branco'),
                    )
                )
            )
                )
        );
    }

}
