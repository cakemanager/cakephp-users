<?php
namespace Users\Controller;

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
        
    }
    
    public function login()
    {
        if($this->authUser) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
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
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }

    public function activate($email = null, $requestKey = null)
    {
        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        // If the email and key doesn't match
        if (!$this->Users->validateRequestKey($email, $requestKey)) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect('/login');
        }

        // If the user has been activated
        if ($this->Users->activateUser($email, $requestKey)) {
            $this->Flash->success(__('Congratulations! Your account has been activated!'));
            return $this->redirect('/login');
        }

        // If noting happened. Just for safety :)
        $this->Flash->error(__('Your account could not be activated.'));
        return $this->redirect('/login');
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
        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        if ($this->request->is('post')) {
            $user = $this->Users->findByEmail($this->request->data['email']);
            if ($user->Count()) {
                $user = $user->first();
                $user->set('request_key', $this->Users->generateRequestKey());
                $this->Users->save($user);
            }

            $this->Flash->success(__('Check your e-mail to change your password.'));
            return $this->redirect($this->Auth->config('loginAction'));
        }
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
        // Redirect if user is already logged in
        if ($this->authUser) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect($this->Auth->config('loginAction'));
        }

        // If the email and key doesn't match
        if (!$this->Users->validateRequestKey($email, $requestKey)) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect($this->Auth->config('loginAction'));
        }

        // If we passed and the POST isset
        if ($this->request->is('post')) {
            $user = $this->Users->find()->where([
                'email' => $email,
                'request_key' => $requestKey,
            ])->first();

            if ($user) {
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user->set('active', 1);
                $user->set('request_key', null);

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your password has been changed.'));
                    return $this->redirect($this->Auth->config('loginAction'));
                }
            }
            $this->Flash->error(__('Your account could not be activated.'));
        }
    }

}
