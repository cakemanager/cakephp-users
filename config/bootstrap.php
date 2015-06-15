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

Plugin::load('Utils');

Configure::write('Users.fields', [
    'username' => 'email',
    'password' => 'password'
]);

Configure::write('CA.Models.users', 'Users.Users');

Configure::write('CA.Models.roles', 'Users.Roles');

Configure::write('Notifier.templates.new_user', [
    'title' => 'New user has been registered',
    'body' => 'A new user has been registered: :email'
]);