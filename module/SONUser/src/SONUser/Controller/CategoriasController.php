<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SONUser\Entity\Categoria as CategoriaEntity;

class CategoriasController extends AbstractActionController {

    /**
     *
     * @var $em \Doctrine\ORM\EntityManager
     * 
     */
    protected $em;

    public function __construct() {
        $this->gr = 'SONUser\Entity\Categoria';
        $this->sl = 'SONUser\Service\Categoria';
    }

    public function indexAction() {
        $list = $this->getEm()->getRepository($this->gr)->findAll();
        return new ViewModel(array('data' => $list));
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
