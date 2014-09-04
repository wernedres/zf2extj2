<?php

namespace SONUser\Form;

use Zend\Form\Form;

class User extends Form {

    public function __construct($name = null) {
        parent::__construct('user');

        $this->setAttribute('method', 'post');
        #$this->setInputFilter(new UserFilter);

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text('nome');
        $this->setLabel("Nome");
        $this->add($nome);

        $email = new \Zend\Form\Element\Text('email');
        $this->setLabel("Email");
        $this->add($email);

        $password = new \Zend\Form\Element\Password('password');
        $this->setLabel("Senha");
        $this->add($password);

        $csrf = new \Zend\Form\Element(\Csrf("security"));
        $this->add($csrf);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn-success'
            )
        ));
    }

}
