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

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{

    public function beforeFilter(Event $event)
    {
        if ($this->authUser) {
            $this->layout = 'Users.default';
        } else {
            $this->layout = 'Users.login';
        }

    }

}
