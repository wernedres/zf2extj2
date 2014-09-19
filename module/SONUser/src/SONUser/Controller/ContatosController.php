<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SONUser\Form\Contato as ContatoForm;
use SONUser\Entity\Contato as ContatoEntity;

class ContatosController extends AbstractActionController {

    /**
     *
     * @var $em \Doctrine\ORM\EntityManager
     * 
     */
    private $em;
    private $form;

    public function __construct() {

        $this->form = new ContatoForm();
        $this->gr = 'SONUser\Entity\Contato';
        $this->sl= 'SONUser\Service\Contato';
    }

    public function indexAction() {

        $list = $this->getEm()->getRepository($this->gr)->findAll();
        return new ViewModel(array('data' => $list));
    }

    public function newAction() {

        $form = $this->form;
//        $form->setInputFilter(new UserFilter());

        $request = $this->getRequest();


        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();

                /** @var $contatoService \SONUser\Service\Contato */
                $contatoService = $this->getServiceLocator()->get(  $this->sl);
                $contatoService->insert($form->getData());


                return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'contatos'));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function deleteAction() {
        $contatoService = $this->getServiceLocator()->get($this->sl);
        if ($contatoService->delete($this->params()->fromRoute('id'))) {
            return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'contatos'));
        }
    }
     public function editAction() {
        $form = $this->form;
//        $form->setInputFilter(new UserFilter());

        $request = $this->getRequest();

        $repository = $this->getEm()->getRepository('SONUser\Entity\Contato');
        $entity = $repository->find($this->params()->fromRoute('id', 0));

        if ($entity) {
            $form->setData($entity->toArray());
        }

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {


                /** @var $userService \SONUser\Service\Contato */
                $userService = $this->getServiceLocator()->get('SONUser\Service\Contato');
                $result = $userService->update($form->getData());


                if ($result) {
                    return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'contatos'));
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
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
