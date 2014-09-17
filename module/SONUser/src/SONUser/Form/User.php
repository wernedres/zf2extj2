<?php

namespace SONUser\Form;

use Zend\Form\Form;


class User extends Form {

public function __construct($name = null) {
    
        parent::__construct('user');

        $this->setAttribute('method', 'post');
    
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel("Nome:");
        $nome->setAttribute("class", "form-control");
        $this->add($nome);

        $email = new \Zend\Form\Element\Text('email');
        $email->setLabel("Email:");
        $email->setAttribute("class", "form-control");
        $this->add($email);

        $password = new \Zend\Form\Element\Password('password');
        $password->setLabel("Senha");
        $password->setAttribute("class", "form-control");
        $this->add($password);

//        $csrf = new \Zend\Form\Element(\Csrf("security"));
//        $this->add($csrf);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-success'
            )
        ));
    }

}
