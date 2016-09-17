<p style="font-family: Calibri, Arial">
    <?= __d('users', 'Hello') ?> <?= $user->email ?>,
</p>

<p style="font-family: Calibri, Arial">
    <?= __d('users', "You've got this e-mail because you lost your password at") ?> <a href="<?= $baseUrl ?>"><?= $baseUrl ?></a>.<br>
    <?= __d('users', "Via the following url you will be able to set a new password:") ?> <a href="<?= $resetUrl ?>">Reset new Password</a>.
</p>

<p style="font-family: Calibri, Arial">
    <?= __d('users', "After you've chosen your new password you are able to login at:") ?> <a href="<?= $loginUrl ?>"><?= $loginUrl ?></a>.
</p>


<p style="font-family: Calibri, Arial">
    <?= __d('users', "If you didn't request a new password, you can ignore this e-mail.") ?>
</p>

<p style="font-family: Calibri, Arial">
    <?= __d('users', 'Greetz,') ?>
</p>

<p style="font-family: Calibri, Arial">
    <a href="<?= $baseUrl ?>"><?= $baseUrl ?></a>
</p>