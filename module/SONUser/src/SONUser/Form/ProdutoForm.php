<?php 

namespace SONUser\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\File;
use Zend\Form\Element\Hidden;
use Zend\Form\Form;

class ProdutoForm extends Form
{
    public function __construct($name = null) {
        parent::__construct('produto');
        
        // setando o atributo enctype para envio de upload de arquivos
        $this->setAttribute('enctype', 'multipart/form-data');
        
        // criando o campo produto id hidden
        $id = new Hidden('produto_id');
        
        // criando o campo produto_nome
        $nome = new Text('produto_nome');
        $nome->setLabel('Nome do produto')
             ->setAttributes(array(
                 'style' => 'width:485px'
             ));
        
        // criando o campo produto_preco
        $preco = new Text('produto_preco');
        $preco->setLabel('Preço do produto')
             ->setAttributes(array(
                 'style' => 'width:100px'
             ));
        
        // criando o campo produto_foto
        $foto = new File('produto_foto');
        $foto->setLabel('Foto do produto');
        $foto->setAttributes(array(
            'style' => 'width: 500px;'
        ));
        
        // criando o campo produto_descricao
        $descricao = new Textarea('produto_descricao');
        $descricao->setLabel('Descrição do produto')
                  ->setAttributes(array(
                      'style' => 'width: 500px; height: 300px',
                      'id' => 'produto_descricao'
                  ));
        
        // criando o campo produto_status
        $status = new Checkbox('produto_status');
        $status->setLabel('Ativar o produto')
               ->setValue(1);
        
        // criando o botão submit
        $submit = new Button('submit');
        $submit->setLabel('Cadastrar')
               ->setAttributes(array(
                   'type' => 'submit'
               ));
        
        // setando os campos
        $this->add($id);
        $this->add($nome);
        $this->add($preco);
        $this->add($foto);
        $this->add($descricao);
        $this->add($status);
        $this->add($submit, array('priority' => -100));
    }
} ?>