<?php

namespace SONUser\Form;

use Zend\Form\Form;


class Contato extends Form {

public function __construct($name = null) {
    
        parent::__construct('contato');

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

        $telefone = new \Zend\Form\Element\Text('telefone');
        $telefone->setLabel("Telfone");
        $telefone->setAttribute("class", "form-control");
        $this->add($telefone);
        
        $endereco = new \Zend\Form\Element\Text('endereco');
        $endereco->setLabel("Endereco");
        $endereco->setAttribute("class", "form-control");
        $this->add($endereco);
        
        $bairro = new \Zend\Form\Element\Text('bairro');
        $bairro->setLabel("Bairro");
        $bairro->setAttribute("class", "form-control");
        $this->add($bairro);

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
