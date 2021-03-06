<?php

namespace SONUser;

use Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent;
use SONUser\Service\User as UserService;
use SONUser\Service\Contato as ContatoService;
use SONUser\Service\Setor as SetorService;
use SONUser\Service\Categoria as CategoriaService;
use Zend\Db\Adapter\Adapter;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ . 'Admin' => __DIR__ . '/src/' . __NAMESPACE__ . "Admin",
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'SONUser\Service\User' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return new UserService($em);
                },
                'produto-table' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ProdutoTable($dbAdapter);
                    return $table;
                },
                'SONUser\Auth\Adapter' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return new Auth\Adapter($em);
                },
                'SONUser\Service\Contato' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return new ContatoService($em);
                },
                'SONUser\Service\Setor' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return new SetorService($em);
                },
                'SONUser\Service\Categoria' => function($sm) {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    return new CategoriaService($em);
                },
            )
        );
    }

    public function onBootstrap($e) {
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
    }

}
