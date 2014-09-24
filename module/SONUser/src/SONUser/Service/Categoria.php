<?php

namespace SONUser\Service;

use SONUser\Entity\Categoria as CategoriaEntity;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

class Categoria {

    /**
     *
     * @var \Doctrine\ORM\EntityManager;
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->entity = 'SONUser\Entity\Categoria';
    }

    public function delete($id) {
        $entity = $this->em->getReference($this->entity, $id);
        $this->em->remove($entity);
        $this->em->flush();
        return $id;
    }

}
