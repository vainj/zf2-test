<?php

return array(
    'controllers' => array(
        // 'invokables' => array(
        //     'Blog\Controller\List' => 'Blog\Controller\ListController'
        // )
        'factories' => array(
            'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory',
            'Blog\Controller\Write' => 'Blog\Factory\WriteControllerFactory'
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        // 'invokables' => array(
        //     'Blog\Service\PostServiceInterface' => 'Blog\Service\PostService'
        // ),
        'factories' => array(
            'Blog\Service\PostServiceInterface' => 'Blog\Factory\PostServiceFactory',
            'Blog\Mapper\PostMapperInterface'   => 'Blog\Factory\ZendDbSqlMapperFactory',
            'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    ),
    'db' => array(
        'driver'         => 'Pdo',
        'username'       => 'root',
        'password'       => 'root',
        'dsn'            => 'mysql:dbname=blog;host=localhost',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\List',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'detail' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/:id',
                            'defaults' => array(
                                'action' => 'detail'
                            ),
                            'constraints' => array(
                                'id' => '[1-9]\d*'
                            )
                        )
                    ),
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action' => 'add'
                            )
                        )
                    ),
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action'     => 'edit'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    ),
                )
            )
        )
    )
);
