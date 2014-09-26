<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use SONUser\Form\Categoria as CategoriaForm;
use SONUser\Entity\Categoria as CategoriaEntity;

class CategoriasController extends AbstractActionController {

    /**
     *
     * @var $em \Doctrine\ORM\EntityManager
     * 
     */
    protected $em;

    public function __construct() {
              $this->form = new CategoriaForm();
        $this->gr = 'SONUser\Entity\Categoria';
        $this->sl = 'SONUser\Service\Categoria';
    }

    public function indexAction() {
        $list = $this->getEm()->getRepository($this->gr)->findAll();
        return new ViewModel(array('data' => $list));
    }

    public function newAction() {
        
        
        $form = $this->form;
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());


            if ($form->isValid()) {
                $data = $form->getData();

                $cateService = $this->getServiceLocator()->get($this->sl);
                $cateService->insert($form->getData());
                
                
                return $this->redirect()->toRoute('sonuser-admin',array("controller"=>'categorias'));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function deleteAction() {
        $contatoService = $this->getServiceLocator()->get($this->sl);
        if ($contatoService->delete($this->params()->fromRoute('id'))) {
            return $this->redirect()->toRoute('sonuser-admin', array('controller' => 'categorias'));
        }
    }

    /**
     * 
     * @return array \Doctrine\ORM\EntityManager
     */
    private function getEm() {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
