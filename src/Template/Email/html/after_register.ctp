<p style="font-family: Calibri, Arial">
    <?= __d('users', 'Hello') ?> <?= $user->email ?>,
</p>

<p style="font-family: Calibri, Arial">
    <?= __d('users', 'Welcome to')?> <a href="<?= $baseUrl ?>"><?= $baseUrl ?></a>!<br>
    <?= __d('users', 'You need to activate your account first via this url:') ?> <a href="<?= $activationUrl ?>"><?= __d('users', 'Activation') ?></a>.
</p>

<p style="font-family: Calibri, Arial">
    <?= __d('users', 'After activating you are able to login at:') ?> <a href="<?= $loginUrl ?>"><?= $loginUrl ?></a>.
</p>

<p style="font-family: Calibri, Arial">
    <?= __d('users', 'Greetz,') ?>
</p>

<p style="font-family: Calibri, Arial">
    <a href="<?= $baseUrl ?>"><?= $baseUrl ?></a>
</p>