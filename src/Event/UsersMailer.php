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
namespace Users\Event;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

class UsersMailer implements EventListenerInterface
{

    /**
     * Returns a list of events this object is implementing. When the class is registered
     * in an event manager, each individual method will be associated with the respective event.
     *
     * @return array associative array or event key names pointing to the function
     * that should be called in the object when the respective event is fired
     */
    public function implementedEvents()
    {
        return [
            'Model.Users.afterRegister' => 'afterRegister',
            'Controller.Users.afterForgot' => 'afterForgot',
        ];
    }

    public function afterRegister($event, $user)
    {
        if ($user->get('active') !== 1) {
            $email = new Email('default');

            $email->viewVars([
                'user' => $user,
                'activationUrl' => Router::fullBaseUrl() . Router::url([
                        'prefix' => false,
                        'plugin' => 'Users',
                        'controller' => 'Users',
                        'action' => 'activate',
                        $user['email'],
                        $user['request_key']
                    ]),
                'baseUrl' => Router::fullBaseUrl(),
                'loginUrl' => Router::fullBaseUrl() . '/login',
            ]);
            $email->from(Configure::read('Users.email.from'));
            $email->subject(Configure::read('Users.email.afterRegister.subject'));
            $email->emailFormat('both');
            $email->transport(Configure::read('Users.email.transport'));
            $email->template('Users.afterRegister', 'Users.default');
            $email->to($user['email']);
            $email->send();
        }
    }


    public function afterForgot($event, $user)
    {
        $email = new Email('default');

        $email->viewVars([
            'user' => $user,
            'resetUrl' => Router::fullBaseUrl() . Router::url([
                    'prefix' => false,
                    'plugin' => 'Users',
                    'controller' => 'Users',
                    'action' => 'reset',
                    $user['email'],
                    $user['request_key']
                ]),
            'baseUrl' => Router::fullBaseUrl(),
            'loginUrl' => Router::fullBaseUrl() . '/login',
        ]);
        $email->from(Configure::read('Users.email.from'));
        $email->subject(Configure::read('Users.email.afterForgot.subject'));
        $email->emailFormat('both');
        $email->transport(Configure::read('Users.email.transport'));
        $email->template('Users.afterForgot', 'Users.default');
        $email->to($user['email']);
        $email->send();
    }

}