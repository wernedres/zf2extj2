<?php

namespace SONUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
//use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\Persistence\ObjectManager;
use SONUser\Entity\User;

class LoadUser extends AbstractFixture {

    function load(ObjectManager $manager) {


        $user = new User;
        $user
                ->setNome("Wérnedres Coutinho")
                ->setEmail("wernedres@hotmail.com")
                ->setPassword("12345")
                ->setActive(true);
        $manager->persist($user);

        $user = new User;
        $user
                ->setNome("Rogerio Regis")
                ->setEmail("RResgis@hotmail.com")
                ->setPassword("098776543")
                ->setActive(true);
        $manager->persist($user);
        $manager->flush();
    }

}
