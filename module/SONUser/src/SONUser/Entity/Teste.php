<?php

namespace SONUser\Entity;

//use Doctrine\Common\Persistence\Mapping\MappingException ;

use Doctrine\ORM\Tools\ToolsException; 


use Doctrine\ORM\Mapping as ORM;
//use Zend\Stdlib\Hydrator\ClassMethods;
//use Zend\Crypt\Key\Derivation\Pbkdf2;

/**
 * @ORM\Entity
 * @ORM\Table(name="teste")
 

 */
class Teste{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var  int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    
    
    
    function getId() {
        return $this->id;
    }
    
       function setId($id) {
        $this->id = $id;
        return $this;
    }


    function getNome() {
        return $this->nome;
    }
    
     function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

}