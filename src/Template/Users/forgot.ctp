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
?>
<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __d('users', 'Forgot password') ?></legend>
        <?= $this->Form->input(Configure::read('Users.fields.username')) ?>
    </fieldset>
    <?= $this->Form->button(__d('users', 'Request')); ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link(__d('users', 'Login'), ['action' => 'login']); ?>
</div>