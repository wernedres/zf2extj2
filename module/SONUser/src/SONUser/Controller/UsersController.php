<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SONUser\Form\User as UserForm;
use SONUser\Entity\User as UserEntity;

class UsersController extends AbstractActionController {

    /**
     *
     * @var $em \Doctrine\ORM\EntityManager
     * 
     */
    private $em;
    private $form;

    public function __construct() {
        $this->form = new UserForm();
    }

    public function indexAction() {

        $list = $this->getEm()->getRepository('SONUser\Entity\User')
                ->findAll();

        return new ViewModel(array('data' => $list));
    }

    public function newAction() {


        $form = $this->form;
        $request = $this->getRequest();


        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();

                /** @var $userService \SONUser\Service\User */
                $userService = $this->getServiceLocator()->get('SONUser\Service\User');
                $userService->insert($form->getData());


                return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'users'));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    /**
     * 
     * @return array \Doctrine\ORM\EntityManager
     */
    private function getEm() {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
