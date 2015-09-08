# Users plugin for CakePHP

> Note: This is a non-stable plugin for CakePHP 3.x at this time. It is currently under development and should be considered experimental.


## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configurations](#configurations)
- [UserManager Component(#usermanager-component)
- [CakeAdmin](#cakeadmin)
- [Keep in Touch](#keep-in-touch)


## Features
- [CakeAdmin](https://github.com/cakemanager/cakephp-cakeadmin) compatible
- Forgot Password functionality
- Role-management (Set up your own roles)
- E-mail integration
- Easy to install


## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require cakemanager/cakephp-users
```

Now load the plugin with the command:

``` 
$ bin/cake plugin load -r -b Users
```

Run the database migrations with:

```
$ bin/cake migrations migrate --plugin Users
```

## Usage

Using the users-plugin is very easy. Use the following code in your `AppController`:

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Users.UserManager');
    }

You can change configurations of the `AuthComponent` with `$this->Users->config('auth.*settings*);` or
`$this->Auth->config()` (after loading the `UserManagement` component).

From now on you will be able to register and login. Use the 
[CakeAdmin Plugin](https://github.com/cakemanager/cakephp-cakeadmin) to manage your roles and users easily.


## Configurations

The following configurations are available. All configurations can be set via `Configure::write()` in your 
`config/bootstrap.php` file.

### Users.fields
By default you will register and login with `email` and `password`. When you want to use your own fields, like 
`username` and `passwrd` you can use the following:

    Configure::write('Users.fields', [
        'username' => 'username',
        'password' => 'passwrd'
    ]);

### Users.email
There are some configurations for email:
- `Users.email.from` - Array to define the sender. Default `['admin@cakemanager.org' => 'Bob | CakeManager']`.
- `Users.email.transport` - The transport to use. Default set to `default`.
- `Users.email.afterRegister.subject` - The subject of the email sent when an user has been registered.
- `Users.email.afterForget.subject` - The subject of the email sent when an user forgot his password.

### Users.defaultController
The plugin has a default controller which contains all default user-related actions (login, logout, reset, forgot).
There may be times that you want to use your own controller. You can disable the default built-in controller by setting
`Users.defaultController` to `false`:

    Configure::write('Users.defaultController', false);

When you do this, the routes for the plugin are not set, and trying to reach te controller will fail because you will be
redirected to the previous location.

> Note: This feature can be helpfull by using the user-management only for your
[API](https://github.com/cakemanager/cakephp-api).


## UserManager Component

The UserManager Component default handles the Auth for your app. However, this component is also helpful to add user-
related actions to your system! By calling the login-function (`$this->UserManager->login()`) you are using the
login-action. The same is for:

- `login()` - Logs the user in.
- `logout()` - Logs the user off.
- `activate($email, $requestKey)` - Activates the user. Don't forget to pass the variables.
- `forgot` - User leaves his e-mailaddress to receive an e-mail to set a new password.
- `reset($email, $requestKey)` - Creates a new password for the user. Don't forget to pass the variables.

This methods can be helpful when you want to customize your user-related actions.

> Note: Don't forget to set the `Users.defaultController` configuration to `false`, mentioned above!


## CakeAdmin

The plugin is [CakeAdmin](https://github.com/cakemanager/cakephp-cakeadmin) compatible! This means that the Users and 
Roles can be managed in the Admin panel of the CakeAdmin plugin.


## Keep in touch

If you need some help or got ideas for this plugin, feel free to chat at 
[Gitter](https://gitter.im/cakemanager/cakephp-users). 

Pull Requests are always more than welcome!