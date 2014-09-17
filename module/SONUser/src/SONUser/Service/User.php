<?php

namespace SONUser\Service;

use SONUser\Entity\User as UserEntity;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class User {

    /**
     *
     * @var \Doctrine\ORM\EntityManager;
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->entity = 'SONUser\Entity\User';
    }

    public function insert(array $data) {


        $entity = new UserEntity();
        (new ClassMethods)->hydrate($data, $entity);

        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function update(array $data) {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new ClassMethods)->hydrate($data, $entity);
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function delete($id) {
        $entity = $this->em->getReference($this->entity, $id);
        $this->em->remove($entity);
        $this->em->flush();
        return $id;
    }

}
