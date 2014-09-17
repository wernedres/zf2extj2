<?php

namespace SONUser\Service;

use SONUser\Entity\User as UserEntity;
use Doctrine\ORM\EntityManager;

class User {

    /**
     *
     * @var \Doctrine\ORM\EntityManager;
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function insert(array $data) {


        $entity = new UserEntity();

        $entity->setNome($data['nome'])
                ->setEmail($data['email'])
                ->setPassword($data['password'])
                ->setActive(true);

        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

}
