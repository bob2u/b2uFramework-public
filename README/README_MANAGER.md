# \B2U\Core\Manager

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

The ***Manager*** is a Singletone object, which means it will only have one instance of it allocated for the script execution duration. It provides interfaces to access most of the framework's objects via defined accessors.

# Methods
```PHP 
Manager::instance()
```
@return - `\B2U\Core\Manager` - Returns the single instance of the manager object when called from any .php script in the framework.
##
```PHP 
Manager::log($message, $args, $detailed = false)
```
@param **$message** - `string` - An identifying message for the log entry.

@param **$args** - `Array` - An array of parameters and arguments to be saved as JSON with the log entry.

@param **$detailed** - `bool` - Default `false`, set to `true` to indicate the log entry will only be available in the `Logging::Callback` when `Logging::Detailed` is set to true.

Function is used to trigger log events that can be captured and processed using the `setup()` `Logging` definition. 
##
```PHP 
Manager::instance()->getSession()
```
@return - `\B2U\Core\Session` - Returns the session object's single instance, which encapsulates the current `$_SESSION` superglobal, and provides functionalities for session management.
##
```PHP 
Manager::instance()->getResponse()
```
@return - `\B2U\Core\Response` - Returns the response object to be populated by the application and sent back to the requester.
##
```PHP 
Manager::instance()->getHeaders()
```
@return - `Array` - Returns a list of the headers associated with the ***Request*** to the server.
##
```PHP 
Manager::instance()->getParameters()
```
@return - `Array` - Returns a list, by value, of the ***Request*** parameters. These would include all `$_GET`, `$_POST`, and `$_FILE` entries, as well as any data received > through `php://input` pipeline.
##
```PHP 
Manager::instance()->getInterface($interface = "", $module = "", $index = 0, ...$args)
```
@param **$interface** - `string` - The Interface category to search for a given loaded Module within.

@param **$module** - `string` - The `namespace\class` Module to access.

@param **$index** - `mixed` - Default `0`, the module definition to return - all modules must have at least 1 definition. Can either provide the index of the definition within the Module, or the `"Name"` attribute if it is set.

@param **$args** - `mixed` - A packed variable to allow multiple parameters to be passed to the constructor of the Module.

@return - `Object` - Returns an instance to the desired module or `false` on failure. Invalid parameters will result in a standard `\Exception`. Only providing the $interface will return an `Array` of all modules available in the given $interface category. If an empty $interface category is provided then the system will return an `Array` of all Interfaces and their Modules in the framework registry.

This function is used to get an instance to a specific Interface's Module. If the Module is not loaded, this function will first attempt to load it and allocate an instance of the Module within the Interface category. There is only one (1) instance of a Module for the duration of a script's execution, but new instances can still be createdby providing multiple definitions within the Module. 

In most applications, Modules only need a single instance for the duration of the script's execution. But if multiple instances are required, then instead of using this function to create a single instance of a Module, it should be used to point to a factory for the Module, which fits a single instance design pattern. The factory will then be accessible to all scripts to create as many Module instances as needed.

An example of using an Interface would be for user authorization, and a Module in it would be LDAP. The example below assumes the application has loaded a Module for LDAP processing.
```php
$ldap_auth = \B2U\Core\Manager::instance()->getInterface("Authorization", "My_LDAP", 0, $ldap_config_params, "login_credentials");
if ($ldap_auth->isUserAuthorized()) {
  ...
}
```
***@note -*** _There are multiple ways to access Modules in b2uFramework._
##
```PHP 
Manager::instance()->getPlugin($plugin = "", $action = "index.php")
```
@param **$plugin** - `string` - The Plugin key value from the `config['Plugins']` list.

@param **$action** - `string` - Default `index`, The file within the plugin that contains the action definition.

@return - `Object` - Returns an instance to the desired Plugin's action or exception on failure. Invalid parameters will result in a standard `\Exception`. Providing no $plugin will return an `Array` of all Plugins available.
##
```PHP 
Manager::instance()->setup($config)
```
@param **$config** - `Array` - Allow customization of the application by setting up the central routing and site configuration parameters.

The $config is an array used to provide data to set up the framework and the application, and it consists of the following sections:

1) **Includes** - An `Array of strings` to add global include files that should be loaded on each request and any definitions that need to be made available to all Plugins and Interfaces. Each entry can be a single file or a directory with sub-directories and files to be loaded (recursive).

2) **Errors** - An `Array` to indicate how the system should react to system-level errors and exceptions. All exceptions will trigger an error event, and all error events will result in a `HTTP/1.1 500 There was internal system error!` response. If the application wants to override the standard system error response they can use this configuration parameter to capture all errors.

```php
"Errors" => [
   "Report" =>   // Default 0 - set to 0 or false, or remove the entry to disable error reporting, else E_ALL, etc.
   "Callback" => function($error, $errno, $errstr, $errfile, $errline) {
      // $error will contain an array with last error information.
      //
      // example below provides the stack and error details in raw
      // format. The application should decide how to handle error
      // results.
      if (!empty($error)) {
         var_dump($error);
      }
      $stack = debug_backtrace();
      if (count($stack) > 1) {
         var_dump($stack);
      }      
   }
]
```
***@note -*** _By default the framework will set `log_error` at runtime to `On` for php.ini_

3) **Plugins** - The actual site content will be in this section. It will primarily contain the root `"/"` Module (home page), and all other pages/modules. Each Plugin definition will have a required `"Path"` parameter set to a directory that contains the Plugin Action(s), and an optional `"Include"` parameter that can be set to an `Array of strings` for files to include that is used only within this Plugin. 

***@note -*** _Use the 1. **Includes** section for files that need to be used in more than one Plugin._

```php
"plugin_name" => [
   "Path" =>    // string
   "Include" => // Array of strings
]
```
***@note -*** _If the Plugin's Actions are in a `namespace`, then the files containing the Action's definition should include `return __NAMESPACE__;` as the last line of code within the file so that the framework would be able to determine the correct class objects that need to be instantiated on any given Action call._

4) **Interfaces** - Third-party modules and reuseable APIs should be added to this section. @see [Terminology:Interfaces](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology). Modules are added under each Interface's main category, following the format below. Each Module must have at least (1) definition, which will have a required `"Path"` parameter that can either be the top-level directory to the Module, which will contain all .php files for its function that will be autoloaded, or the path to a specific file that contains the `module_name class` or an `_autoload` function.

    Interface's Modules can be accessed by the application using the `getInterface()` method defined previously, and they can also be accessed using a custom variable name that can be accessed using `\B2U\Core\Manager::instance()->user_defined_variable_name` syntax. To use the variable syntax the `"Name"` parameter should be set during setup. This mechanism will load the Module on first access to the custom variable, which is similar to calling `getInterface()` and storing the result in a global variable.

    ***@note -*** _`"Name"` must be unqiue across all application Modules._

    To pass arguments to Modules using the custom variable `"Name"` method it is required to use the `"Args"` parameter. When creating Modules using the `getInterface()` method, it is possible to pass arguments using the standard `...$args` parameter for the function, and also using the setup `"Args"` parameter.
    
    In some cases the application may want to make some changes to the arguments passed in (e.g. decrypt the argument). In these instances an argument can be represented with a `function(&$arg, $uses)` anonymous function. The function's signature receives the `$arg` argument by referrence, and any `$uses` interfaces defined using the `"Uses"` parameter of the Module. These `"Uses"` parameters can be accessed within the anonymous function with `$uses->variable_name` syntax. Any changes to the `$arg` parameters will be the final change that will be passed to the Module's `__construct(...$args)`.

    ***@note -*** _`...$args` parameter has higher priority over the `"Args"` parameters when used with `getInterface()` method_

    In some instances, Modules can have dependencies across other modules, and these dependencies can be defined within the `\B2U\Core\Module` - @see [\B2U\Core\Module](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MODULE.md#b2ucoremodule) for more details.  But it is also possible to declare dependencies between interfaces during the setup operation. This is accomplished with the `"Uses"` parameter. `"Uses"` supports a list of dependent Modules. For each Module, a unique custom variable name is selected, within the scope of the parent Module, which defines the Module. This method will automatically load the dependencies when the dependent Module is loaded and provides a local variable accessible to the Module using the `$this->variable_name` parameter.

```php
"interface_category" => [
   "namespace\model_name class" => [
      [
          "Name" =>   // string
          "Path" =>   // string
          "Args" =>   // Array or Function
          "Uses" => [
              "variable_name" => [
                  "interface_category",
                  "module_name",
                  "index or Name",
                  ..."arguments"
              ]
          ]
      ],
      [...]
   ]
]
```

5) **Profile** - setting this parameter to true would provide a high-level output of the framework's timing in processing a request. The result will be saved to a file in the root directory named `__b2u_timingX`.

6) **Logging** - An `Array` to indicate activate system logging that allows a custom callback to be called with information related to the execution of the framework. Application can write custom log entries using the `Manager::log(...)` static method.

```php
"Logging" => [
   "Enable" =>   // Default 0 - set to 1 or true to allow callback to receive log data.
   "Callback" => function($args) {
      // $args will contain a JSON with information regarding the log entries
      // this data will vary depending on where and how it is being logged-in
      //
      // @note - use json_decode on the $args to extract the log information.
      // the array will have a "__msg" and "__data" key values, where the msg
      // contain a string, and the data is an array with additional log info.
   },
   "Detailed" => // Default 0 - set to 1 or receive logs marked as detailed information.
]
```

7) **Session** - (Optional) The session can be configured at startup to control its life span and how/when to delete obsolete sessions. Values for all timing parameters are in seconds.

```php
[
   "Life" =>    // int - Default 1800
   "Kill" =>    // int - Default 300
]
```
##
```PHP 
Manager::instance()->augment($config, $mode)
```
@param **$config** - `Array` - Array of configuration parameters with respect the $mode.

@param **$mode** - `string` - Either `"Plugins"` or `"Interfaces"`.

In some instances, an application will want to augment the existing Module definitions or Plugin definitions to include additional features. For example, an application would like to add a new parameter `"Role"` to the Plugin's definition, beyond the standard `"Path"` and `"Include"`, so it can be used during access permission checking operations. The `augment()` function can be called before or after `setup()` to accomplish this effect.
##
```PHP 
Manager::instance()->run()
```
Aliase for `parse()`, `route()`, and `response()` calls. `parse()` performs URL pasrsing and data extraction of the user's request into a `\B2U\Core\Request` object. `route()` does the heavy-lifting and routing of a request to the `Plugin / Action / Method` while passing all necessary parameters. `response()` is an aliase for the `B2U\Core\Response::send` function.

***@note -*** _This is the preferred method for calling the framework as it will internally catch exceptions and process them as errors. If the application decides to use the individual `parse()`, `route()`, and `response()` calls then they should also enclose the execution inside a `try/catch` block and `trigger_error()` on any exceptions._
##
```PHP 
Manager::instance()->callEndpoint($endpoint, $request, $data, $cookies = true)
```
@param **$endpoint** - `string` - The target `Plugin/[Action/[Method]]` to be called

@param **$request** - `string` - One of the values of `GET`, `POST`, `PUT` or `DELETE`

@param **$data** - `Array` - An Array of key/value pairs to be transmitted to the $endpoint using the defined $request

@param **$cookies** - `bool` - Default `true`, Indicates if all cookie data should be sent to the target $endpoint.

@return - \[`Mixed`, `int`] - Returns the cURL call results, and HTTP response code from making the request - throws` \Exception` on any errors.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MANAGER.md#b2ucoremanager)
