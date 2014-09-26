<?php

namespace SONUser\Service;

use SONUser\Entity\Setor as SetorEntity;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class Setor {

    /**
     *
     * @var \Doctrine\ORM\EntityManager;
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->entity = 'SONUser\Entity\Setor';
    }
       public function insert(array $data) {


        $entity = new SetorEntity();
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
