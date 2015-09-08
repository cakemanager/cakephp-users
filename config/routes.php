<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Routing\Router;
use Cake\Core\Configure;

if (Configure::read('Users.defaultController')) {

    Router::plugin('Users', ['path' => '/users'], function ($routes) {

        $routes->connect(
            '/', ['controller' => 'Users', 'action' => 'login']
        );

        $routes->fallbacks('InflectedRoute');
    });

    /**
     * Default login-url
     */
    Router::connect('/login', ['plugin' => 'Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'login']);

    /**
     * Default login-url
     */
    Router::connect('/logout', ['plugin' => 'Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'logout']);

}
