<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SONUser\Form\User as UserForm;


class SetoresController extends AbstractActionController {

    protected $em;
    protected $form;

    public function __construct() {
      
        $this->form = 'SONUser\Form\User';
        $this->sl = 'SONUser\Service\Setor';
        $this->gr = 'SONUser\Entity\Setor';
    }

    public function indexAction() {
        $list = $this->getEm()->getRepository($this->gr)->findAll();
        return new ViewModel(array('data' => $list));
    }

    public function newAction() {

        $form = new $this->form;
        $request = $this->getRequest();


        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                /** @var $userService \SONUser\Service\Contatos */
                $userService = $this->getServiceLocator()->get('SONUser\Service\Setor');
                $userService->insert($form->getData());


                return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'setores'));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function deleteAction() {

        $setorService = $this->getServiceLocator()->get($this->sl);
        if ($setorService->delete($this->params()->fromRoute('id'))) {
            return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'setores'));
        }
    }

    private function getEm() {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
