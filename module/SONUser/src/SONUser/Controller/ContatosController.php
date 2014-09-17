<?php


namespace SONUser\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

//use SONUser\Entity\Contato as ContatoEntity;

class ContatosController extends AbstractActionController {

    /**
     *
     * @var $em \Doctrine\ORM\EntityManager
     * 
     */
//    protected $em;
//    protected $form;
//
// 
    public function indexAction() {

        $list = $this->getEm()->getRepository('SONUser\Entity\Contato')
                ->findAll();

        return new ViewModel(array('data' => $list));
    }
    
     private function getEm() {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }


}
