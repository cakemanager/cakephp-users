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
namespace Users\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Users\Controller\AppController;

/**
 * Users Controller
 *
 * @property \Users\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        if(!Configure::read('Users.defaultController')) {
            $this->redirect($this->referer());
        }

        parent::initialize();

    }

    /**
     * beforeFilter
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow([
            'login',
            'activate',
            'forgot',
            'reset',
        ]);
    }

    public function index()
    {
        // index page for logged in users. Used by default
    }

    public function login()
    {
        return $this->UserManager->login();
    }

    public function logThrough($id)
    {
        // in development
        if ($this->Users->identifyLogThrough($id)) {
            $this->Auth->setUser($this->Users->get($id));
            return $this->redirect($this->Auth->redirectUrl);
        }
        $this->Flash->error(__d('users', 'Invalid username or password, try again'));
        return $this->redirect('/login');
    }

    /**
     * Logout action
     *
     * Logs out the logged in user.
     *
     * @return \Cake\Network\Response|void
     */
    public function logout()
    {
        return $this->UserManager->logout();
    }

    public function activate($email = null, $requestKey = null)
    {
        return $this->UserManager->activate($email, $requestKey);
    }

    /**
     * Forgot password action
     *
     * Via this action you are able to request a new password.
     * After the post it will send a mail with a link.
     * This link will redirect to the action 'reset_password'.
     *
     * This action always gives a success-message.
     * That's because else hackers (or other bad-guys) will be able
     * to see if an e-mail is registered or not.
     *
     * @return void|\Cake\Network\Response
     */
    public function forgot()
    {
        return $this->UserManager->forgot();
    }

    /**
     * Reset password action
     *
     * Users will reach this action when they need to set a new password for their account.
     * This action will set a new password and redirect to the login page
     *
     * @param string $email The e-mailaddress from the user.
     * @param string $requestKey The refering activation key.
     * @return void|\Cake\Network\Response
     */
    public function reset($email, $requestKey = null)
    {
        return $this->UserManager->reset($email, $requestKey);
    }

}
