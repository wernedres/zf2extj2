<?php

namespace SONUser;

return array(
    'router' => array(
        'routes' => array(
            'sonuser-home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SONUser\Controller',
                        'controller' => 'users',
                        'action' => 'index',
                    ),
                ),
            ),
           
                'sonuser-admin' => array(
                'type' => 'Segment',    
                'options' => array(
                    'route' => '/admin/[:controller[/:action]]',
                    'defaults' => array(
                        'action'=>'index',
                        
                    ),
                ),
            ),            
                'sonuser-admin' => array(
                'type' => 'Segment',    
                'options' => array(
                    'route' => '/admin/[:controller[/][:action[/][:id[/]]]]',
                    'defaults' => array(
                        'controller' => 'users',
                        'action' => 'index',
                        ),
                     'constraints' => array(
                       'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9 -]*',
                         
                    ) ,      
                ),
            ),
            'sonuser-auth' => array(
                'type' => 'literal',    
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                    '__NAMESPACE__' => 'SONUser\Controller',
                     'controller'=>'auth',
                        'action'=>'index',
                        
                    ),
                ),
            ),         
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Index' => 'SONUser\Controller\IndexController',
            'users' => 'SONUser\Controller\UsersController',
            'auth' => 'SONUser\Controller\AuthController',
            'contatos' => 'SONUser\Controller\ContatosController',
            'setores' => 'SONUser\Controller\SetoresController',
            'categorias' => 'SONUser\Controller\CategoriasController',
            'produtos' => 'SONUser\Controller\ProdutoController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'son-user/index/index' => __DIR__ . '/../view/son-user/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    //Configuração do Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'data-fixture' => array(
        'SONUser_fixture' => __DIR__ . '/../SONUser/Fixture',
    ),
);
