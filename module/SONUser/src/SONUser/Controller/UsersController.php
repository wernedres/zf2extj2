<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SONUser\Form\User as UserForm;
use SONUser\Form\UserFilter;
//use SONUser\Entity\User as UserEntity;

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
        $this->doe = 'Doctrine\ORM\EntityManager';
        
    }

    public function indexAction() {

        $list = $this->getEm()->getRepository('SONUser\Entity\User')->findAll();
        return new ViewModel(array('data' => $list));
    }

    public function newAction() {

        $form = $this->form;
        $form->setInputFilter(new UserFilter());

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

    public function deleteAction() {
        $userService = $this->getServiceLocator()->get('SONUser\Service\User');
        if ($userService->delete($this->params()->fromRoute('id'))) {
            return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'users'));
        }
    }

    public function editAction() {
        $form = $this->form;
        $form->setInputFilter(new UserFilter());

        $request = $this->getRequest();

        $repository = $this->getEm()->getRepository('SONUser\Entity\User');
        $entity = $repository->find($this->params()->fromRoute('id', 0));

        if ($entity) {
            $form->setData($entity->toArray());
        }

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {


                /** @var $userService \SONUser\Service\User */
                $userService = $this->getServiceLocator()->get('SONUser\Service\User');
                $result = $userService->update($form->getData());



                if ($result) {
                    return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'users'));
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    /**
     * 
     * @return array \Doctrine\ORM\EntityManager
     */
    private function getEm() {
        return $this->getServiceLocator()->get(  $this->doe);
    }

}
