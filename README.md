# Users plugin for CakePHP

> Note: This is a non-stable plugin for CakePHP 3.x at this time. It is currently under development and should be considered experimental.

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
`$this->Auth->config()` (after loading the component.

Documentation and tests will be able soon!

## CakeAdmin

The plugin is [CakeAdmin](https://github.com/cakemanager/cakephp-cakeadmin) compatible!


