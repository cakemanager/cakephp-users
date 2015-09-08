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
                'prefix' => false,
                'plugin' => 'Users',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'prefix' => false,
                'plugin' => 'Users',
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'prefix' => false,
                'plugin' => 'Users',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => false,
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

    public function login()
    {
        if ($this->Controller->authUser) {
            return $this->Controller->redirect($this->Controller->Auth->redirectUrl());
        }
        if ($this->Controller->request->is('post')) {
            $user = $this->Controller->Auth->identify();
            if ($user) {
                $this->Controller->Auth->setUser($user);
                return $this->Controller->redirect($this->Controller->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $this->Controller->Flash->success(__('You are now logged out.'));
        return $this->Controller->redirect($this->Controller->Auth->logout());
    }

    public function activate($email, $requestKey)
    {
        // Redirect if user is already logged in
        if ($this->Controller->authUser) {
            return $this->Controller->redirect('/login');
        }

        // If the email and key doesn't match
        if (!$this->Controller->Users->validateRequestKey($email, $requestKey)) {
            $this->Controller->Flash->error(__('Your account could not be activated.'));
            return $this->Controller->redirect('/login');
        }

        // If the user has been activated
        if ($this->Controller->Users->activate($email, $requestKey)) {
            $this->Controller->Flash->success(__('Congratulations! Your account has been activated!'));
            return $this->Controller->redirect('/login');
        }

        // If noting happened. Just for safety :)
        $this->Controller->Flash->error(__('Your account could not be activated.'));
        return $this->Controller->redirect('/login');
    }

    public function forgot()
    {
        // Redirect if user is already logged in
        if ($this->Controller->authUser) {
            return $this->Controller->redirect('/login');
        }

        if ($this->Controller->request->is('post')) {
            $user = $this->Controller->Users->findByEmail($this->Controller->request->data['email']);
            if ($user->Count()) {
                $user = $user->first();
                $user->set('request_key', $this->Controller->Users->generateRequestKey());
                $this->Controller->Users->save($user);

                $event = new Event('Controller.Users.afterForgot', $this->Controller, [
                    'user' => $user
                ]);
                EventManager::instance()->dispatch($event);
            }

            $this->Controller->Flash->success(__('Check your e-mail to change your password.'));
            return $this->Controller->redirect($this->Controller->Auth->config('loginAction'));
        }
    }

    public function reset($email, $requestKey)
    {
        // Redirect if user is already logged in
        if ($this->Controller->authUser) {
            $this->Controller->Flash->error(__('Your account could not be activated.'));
            return $this->Controller->redirect($this->Controller->Auth->config('loginAction'));
        }

        // If the email and key doesn't match
        if (!$this->Controller->Users->validateRequestKey($email, $requestKey)) {
            $this->Controller->Flash->error(__('Your account could not be activated.'));
            return $this->Controller->redirect($this->Controller->Auth->config('loginAction'));
        }

        // If we passed and the POST isset
        if ($this->Controller->request->is('post')) {
            $user = $this->Controller->Users->find()->where([
                'email' => $email,
                'request_key' => $requestKey,
            ])->first();

            if ($user) {
                $user = $this->Controller->Users->patchEntity($user, $this->Controller->request->data);
                $user->set('active', 1);
                $user->set('request_key', null);

                if ($this->Controller->Users->save($user)) {
                    $this->Controller->Flash->success(__('Your password has been changed.'));
                    return $this->Controller->redirect($this->Controller->Auth->config('loginAction'));
                }
            }
            $this->Controller->Flash->error(__('Your account could not be activated.'));
        }
    }
}
