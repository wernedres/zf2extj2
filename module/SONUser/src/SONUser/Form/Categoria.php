<?php

namespace SONUser\Form;

use Zend\Form\Form;


class Categoria extends Form {

public function __construct($name = null) {
    
        parent::__construct('contato');

        $this->setAttribute('method', 'post');
    
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel("Nome:");
        $nome->setAttribute("classglyphicon glyphicon-user", "form-control");
        $this->add($nome);


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
