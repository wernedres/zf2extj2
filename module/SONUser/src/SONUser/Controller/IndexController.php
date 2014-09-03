<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {

//          $nome = strtoupper('Wérnedres Coutinho de Souza');
        
      
            
        
        return new ViewModel(array('bobao'=>$nome));
    }

}
