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

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\EventManager;
use Users\Event\UsersMailer;

# Plugins
Plugin::load('Utils');


# Settings
Configure::write('Users.fields', [
    'username' => 'email',
    'password' => 'password'
]);

Configure::write('Users.email.from', ['admin@cakemanager.org' => 'Bob | CakeManager']);

Configure::write('Users.email.afterRegister', [
    'subject' => __('Registration')
]);

Configure::write('Users.email.afterForgot', [
    'subject' => __('Password request')
]);

Configure::write('Users.email.transport', 'default');


# Settings for CakeAdmin
Configure::write('CA.Models.users', 'Users.Users');

Configure::write('CA.Models.roles', 'Users.Roles');

Configure::write('Notifier.templates.new_user', [
    'title' => ':email has been registered.',
    'body' => ':email has been registered at :created.'
]);

Configure::write('Users.defaultController', false);

# Events
EventManager::instance()->on(new UsersMailer());