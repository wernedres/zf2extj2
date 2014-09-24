<?php

namespace SONUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="setores")
 */
class Setor {

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

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getNome(){
        return $this->nome;
        
    }
    public function setNome($nome){
        $this->nome =  $nome;
        return $this;
    }
    
    public function toArray(){
       return (new ClassMethods)->extract($this);
    }
        

}
