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
namespace Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;

/**
 * UserManager component
 */
class UserManagerComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'auth' => [
            'authorize' => 'Controller',
            'authenticate' => [
                'Basic' => [
                    'userModel' => 'Users.Users'
                ],
                'Form' => [
                    'userModel' => 'Users.Users',
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ],
                    'scope' => ['Users.active' => true],
                ],
            ],
            'loginAction' => [
                'plugin' => 'Users',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'plugin' => 'Users',
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'plugin' => 'Users',
                'controller' => 'Users',
                'action' => 'login'
            ],
        ]
    ];

    /**
     * Controller
     *
     * @var Controller
     */
    protected $Controller = null;

    public function initialize(array $options)
    {
        $this->Controller = $this->_registry->getController();

        if ($this->config('auth')) {
            $this->Controller->loadComponent('Auth', $this->config('auth'));
        }
    }

    public function beforeFilter(Event $event)
    {
        $this->Controller->authUser = $this->Controller->Auth->user();

    }

    public function beforeRender(Event $event)
    {

        $this->Controller->set('authUser', $this->Controller->authUser);
    }
}
