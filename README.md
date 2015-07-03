# Users plugin for CakePHP

> Note: This is a non-stable plugin for CakePHP 3.x at this time. It is currently under development and should be considered experimental.


## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configurations](#configurations)
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


## CakeAdmin

The plugin is [CakeAdmin](https://github.com/cakemanager/cakephp-cakeadmin) compatible! This means that the Users and 
Roles can be managed in the Admin panel of the CakeAdmin plugin.


## Keep in touch

If you need some help or got ideas for this plugin, feel free to chat at 
[Gitter](https://gitter.im/cakemanager/cakephp-users). 

Pull Requests are always more than welcome!