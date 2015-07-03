<p style="font-family: Calibri, Arial">
    Hello <?= $user->email ?>,
</p>

<p style="font-family: Calibri, Arial">
    Welcome to <a href="<?= $baseUrl ?>"><?= $baseUrl ?></a>!<br>
    You need to activate your account first via this url: <a href="<?= $activationUrl ?>">Activation</a>.
</p>

<p style="font-family: Calibri, Arial">
    After activating you are able to login at: <a href="<?= $loginUrl ?>"><?= $loginUrl ?></a>.
</p>

<p style="font-family: Calibri, Arial">
    Greetz,
</p>

<p style="font-family: Calibri, Arial">
    <a href="<?= $baseUrl ?>"><?= $baseUrl ?></a>
</p>