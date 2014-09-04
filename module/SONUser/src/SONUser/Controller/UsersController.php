<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsersController extends AbstractActionController  {

    
    /**
     *
     * @var $em \Doctrine\ORM\EntityManager
     * 
     */
    private $em;

    public function indexAction() {

        $list = $this->getEm()->getRepository('SONUser\Entity\User')
                ->findAll();

        return new ViewModel(array('data' => $list));
    }
    public function newAction(){
        
    }

    /**
     * 
     * @return array \Doctrine\ORM\EntityManager
     */
    private function getEm() {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
