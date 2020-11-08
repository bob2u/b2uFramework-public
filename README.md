# b2uFramework
Lean PHP RESTful framework

b2uFramework is a minimalist's PHP framework to help developers get a website up and running quickly and follow some design & architecture rather than echoing out PHP content sprinkled in an HTML file. The framework supports a few core features out of the box to allow this minimalist approach to be achieved. Furthermore, b2uFramework supports an interface and plugin mechanism, allowing reusable system components and site content to be developed and used across projects.

The b2uFramework does what most PHP frameworks do for a typical process cycle:
1. Receive a request from a user
2. Parse the request to its components _i.e. API endpoint, methods, parameters_
3. Process the request via routing
4. Return a response to the request _i.e. JSON, file, HTML page, etc._

## Features Out-of-the-box
b2uFramework supports a set of feature that is ready to be used out-of-the-box:

* RESTFul API Architecture
* Session Management - Session Fixation, and Session Hijacking support
* OOP HTML Templates Utility
* Cross Site Request Forgery protection
* Abstract Plugin and Interface mechanism

## Licensing
(c) Manavi Solutions, LLC.

For licensing details please email:

contact [@t] manavi [.T] co

## Terminology
A few basic concepts have been established to help understand the flow of data within this framework. These key concepts are:
* **Plugin (Directory) -** Plugins in b2uFramework are reusable website/application-specific components. These components are organized under directories, and the given directory name corresponds to an API endpoint. A Plugin can contain one or many Actions.
* **Action (File/Class) -** An Action is a specific .php file where the file name corresponds to the API endpoint under the Plugin directory. The Action's .php file will contain a class with the same name as the Action file. An Action performs a set of specific tasks (i.e., Methods). 
* **Method (Function) -** A Method is a unique function within an Action class that will execute a task when requested.

A typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method`

@see [\B2U\Core\Action](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction) for more details about b2uFramework request URL

* **Interface -** The primary use of an Interface is to maintain single instance access to some resources that live once through the execution of the entire script, which is one that will generally not require multiple instances. These are entry points into new/extended functionality that can be added to the framework and used/re-used by the application's Plugins and other Interfaces. Each Interface can provide access to any number of modules they support. Common pre-defined Interface categories are:

  * Server - containing modules for server technology
  * Authorization - common modules could be _HeaderAuthorization_, _LDAP_, _DatabaseDriven_, etc.
  * Database - most common for PHP would be _MySQL_ modules, and _OCI8_ modules
  * File - file management classes
  * Encryption - modules used for specific encryption technology
  * Payment - common payment gateway API modules/wrappers
  * Utility - general purpose modules _(e.g. Google MAPs API, Captue, AI, etc.)_

## Getting Started
The base framework consists of 2 PHP files, a license file, and a web server configuration file. Simply place the ***index.php***, ***b2u.min.php*** file and the associated ***license.lic*** file in the root directory of a project. On Windows/IIS based servers use the ***web.config*** file, and for Linux/Apache based servers use the ***.htaccess*** file - placed in the root directory.

The entry point ***index.php*** has a `class index` defined, which will be the default Action/entry point of the application.

```PHP 
class index extends \B2U\Core\Action implements \B2U\Core\IAction {	
  ...
}
```
If the server configuration is set up correctly, accessing the root URL will run the site, and you should see a page with `Welcome to B2uFramework` displayed.

b2uFramework works by redirecting a request to the site through ***index.php*** and route it to the appropriate `Plugin / Action / Method` for processing.

## Understanding index.php
The ***index.php*** provided with the framework is required and contains a basic setup for any given site. First, it defines a default `class index`, which is optional, and can be removed once the site's root directory is re-defined. Second, it contains (2) two calls to the `\B2U\Core\Manager` that initialize and run the website. 

***index.php*** works as a default [**Action**](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction) for the _root directory_ **Plugin**, with a default `__constuct(...)` **Method**.
```php
<?php
include("b2u.min.php");

class index extends \B2U\Core\Action implements \B2U\Core\IAction {	
  function __construct($method, & $params, & $response) {
    parent::__construct($method, $params, $response);
    $this->Response->setHeader("Content-Type", "text/html")
                    ->setContent("<h1>Welcome to B2uFramework</h1>");
  }
}

\B2U\Core\Manager::instance()->setup([]);
\B2U\Core\Manager::instance()->run();
?>
```

## The B2U\Core Namespace
The ***B2U\Core*** namespace contains all modules and classes need to run a site/application built on this framework. The main components are:

[\B2U\Core\Manager](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MANAGER.md#b2ucoremanager) - main framework entry point (singletone architecture)

[\B2U\Core\Session](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_SESSION.md#b2ucoresession) - session managment class

[\B2U\Core\Response](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_RESPONSE.md#b2ucoreresponse) - class for response construction

\B2U\Core\Request - request pre-processor object

[\B2U\Core\HTMLTemplate](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_TEMPLATE.md#b2ucorehtmltemplate) - HTML templating interface

[\B2U\Core\Action](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction) - class definition for API endpoints

[\B2U\Core\Module](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MODULE.md#b2ucoremodule) - class definition for Interfaces (Database, Authorization, User, ...)

[\B2U\Core\Utility](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_UTILITY.md#b2ucoreutility) - static class with utility functions
