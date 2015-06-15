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

        $this->Auth->allow([
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

    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
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

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

//    /**
//     * Edit method
//     *
//     * @param string|null $id User id.
//     * @return void Redirects on successful edit, renders view otherwise.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
//    public function edit($id = null)
//    {
//        $user = $this->Users->get($id, [
//            'contain' => []
//        ]);
//        if ($this->request->is(['patch', 'post', 'put'])) {
//            $user = $this->Users->patchEntity($user, $this->request->data);
//            if ($this->Users->save($user)) {
//                $this->Flash->success(__('The user has been saved.'));
//                return $this->redirect(['action' => 'index']);
//            } else {
//                $this->Flash->error(__('The user could not be saved. Please, try again.'));
//            }
//        }
//        $this->set(compact('user'));
//        $this->set('_serialize', ['user']);
//    }

}
