<?php

namespace SONUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator\ClassMethods;


use Zend\Crypt\Key\Derivation\Pbkdf2;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
  * @ORM\Entity(repositoryClass="SONUser\Entity\UserRepository")

 */
class User {

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

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

     /**
     * @ORM\Column(type="string")
     */
    protected $salt;

    /**
     * @ORM\Column(type="boolean", nullable= True)
     */
    protected $active;

    /**
     * @ORM\Column(type="string", name="activation_key")
     */
    protected $activationKey;

    /**
     * @ORM\Column(type="string", name="token")
     */
    protected $token;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $administrador;
    

    /**
     * @param mixed $email
     */
    public function __construct($options = null) {
        date_default_timezone_set("America/Boa_Vista");
//        Configurator::configure($this, $options);
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
        $this->activationKey = sha1($this->email . $this->salt);
        $this->token = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    public function getActivationKey() {
        return $this->activationKey;
    }

    public function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }
    public function getAdministrador() {
        return $this->administrador;
    }

    public function setAdministrador($administrador) {
        $this->administrador = $administrador;
        return $this;
    }
    
     public function encryptPassword($password) {
         
   return base64_encode(
           Pbkdf2::calc('sha256', $password ,$this->salt,10000,  strlen($password)*2)
           
           );
 
//        for ($i = 0; $i < 64000; $i++)
//            $hashSenha = hash('sha512', $hashSenha);

        return $hashSenha;
    }
    
    public function toArray(){
       return (new ClassMethods)->extract($this); 
    }

}
