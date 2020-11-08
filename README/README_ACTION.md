# \B2U\Core\Action

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

The cornerstone to using the b2uFramework is the creation of _Actions_ within _Plugins_. As defined earlier, @see [Terminology](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology), _Plugins_, _Actions_, and _Methods_ define the components of request URLs sent to the b2uFramework for processing. While not all parts are required in a valid request, a typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method`. Keep this in mind while reading the sections in this document.

## Understanding Plugins
Understanding _Plugins_ is a prerequisite to understanding _Actions_. Although the representation of _Plugins_ is simple (i.e., It is a Directory), the conceptual use may be alien to some developers. To help identify what would constitute to a _Plugin_ the following guidelines are recommended:

* A Plugin represents a single theme
* Plugins are unit modules of a website/application
* Plugins are re-usable modules of a website/application
* Plugins are not Interfaces, but rather portions of an actual website/application
* Plugins can have one or more common themed Actions defined within them

One example of a Plugin for a website could be a **User Profile** Plugin. This Plugin, if designed generically and adequately, can be used in other website projects. A User Profile Plugin may have multiple Actions organized based on roles (e.g., Admin, User) or only one Action to manage all functionalities for a user's profile. These functionalities, or Methods, can include _profile image upload_, _account validation_, _profile detail update_, etc.

In the above example, we can see that the Plugin represents a single theme (_User Profile_), and it is a unite module within a website that can be re-used in other web projects as needed.

***@note -*** _Plugins are required and will always be the first portion of any b2uFramework request URL. They may even be the only portion (e.g., `www.sitename.com/plugin`), which will be explained later._

***@note -*** _Plugin directory names should not include spaces and should only contain URL compatible characters._

### Assigning Plugins via \B2u\Core\Manager
Plugins must be registered with the `B2u\Core\Manager` via calls to `setup(...)`. @see [Manager::setup()](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MANAGER.md#methods).

## Constructing an Action
An Action is a PHP file within a Plugin directory. To create an Action:
1) Create a PHP file named after the Action it will represent. The file name is the `/action/` portion in a request URL. Guidelines for naming Actions include:
   * Case sensitive
   * Should follow PHP naming conventions for naming, and 
   * Should only contain URL compatible characters.
   * Use of all lowercase letters and "_" are recommended.
2) Declare a PHP `class` using the same name as the Action file.
3) Derive the class from the required `\B2U\Core\Action` class and `\B2U\Core\IAction` interface.
4) Define the required `__construct($method, & $params, & $response)` method.
5) Initialize the parent.

***@note -*** _If the Action is in a `namespace`, then the file containing the Action's definition should include `return __NAMESPACE__;` as the last line of code within the file so that the framework would be able to determine the correct class objects that need to be instantiated on any given Action call._

Once all steps have been completed, the following should be the final output present:
```PHP
<?php
// The following code would be declared in action_name.php file located in plugin_name/ directory
class action_name extends \B2U\Core\Action implements \B2U\Core\IAction {

    // The default Method for all Actions is the constructor
    // the $method parameter is actually the POST, GET, PUT,
    // etc. request method and not to be confused with those
    // methods defined in the class that can be called from
    // the URL /method/ section.
    function __construct($method, & $params, & $response) {
    
        // This is a required call in the constructor of all Actions
        parent::__construct($method, $params, $response);
    }
    
    // Define other Methods here ...
}
```

The default Method for all Actions is their `__construct(...)`, and recall that the Method would come **after** the `/action/` portion of a request URL (i.e., `www.sitename.com/plugin/action/method`); therefore, calling `www.sitename.com/plugin_name/action_name` will execute the `__construct(...)` of the `action_name` class since no Method is called in the URL, and the default Method is the class constructor.

***@note -*** _Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class._

It is important to note that it is possible to call a Plugin in a request URL with no Action and Method. The b2uFramework treats this particular case as a unique Action call to an Action file named ***index.php*** with a `class index` declaration. Following the default Method rule, the `class index`'s `__construct(...)` will be called. An excellent example of this use case can be seen in the b2uFramework's entry point - @see [Understanding index.php](https://github.com/bob2u/b2uFramework-public#understanding-indexphp).

***@note -*** _Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception._

***@note -*** _A `\B2U\Core\Response` must be sent back to the requester for all requests sent to the b2uFranework. The `\B2U\Core\Response` object is accessible to all Action's Methods, including the `__consturct(...)`, via the `$this->Response()` parameter. An `\Exception` is thrown if a response with a valid content is not sent back to the requester. @see [\B2U\Core\Response](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_RESPONSE.md#b2ucoreresponse) for more details._

## Processing Request Parameters

Parameters can be passed vai `$_GET` by either calling: 

```
www.sitename.com/plugin/action/method/var1/var2/var3...
```

or 

```
www.sitename.com/plugin/?var1_name=var1=&var2_name=var2&var3_name=var3...
www.sitename.com/plugin/action/?var1_name=var1=&var2_name=var2&var3_name=var3...
www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...
```

To access these parameters, all Action Method's can reference the `$this->Parameters()` member, which is an associative `Array` of all `$_GET` parameters accessible via their 0 based numeric index - if passed via the URL path, or their names - if given as an argument in a query string, as a key index into the array.

***@note -*** _Parameters passed via `$_POST` are also accessible using the same `$this->Parameters()` array. The only detail is that `$_POST` parameters have higher priority over `$_GET` when reserving a key in the `$this->Parameters()` array._

***@note -*** _Parameters passed via `$_FILE` are also accessible using the same `$this->Parameters()` array. The only detail is that all file(s)'s details will be accessible under a special `"_FILES"` key, and with this key having the highest priority over all key-values in the `Parameters` array._

## Declaring New Methods
Not all Action will use their default `__construct(...)` Method, or rely solely on it. To this effect, developers can define their Methods that will be automatically exposed through the request URL format.

A simple Method is one that does not require any arguments to be passed in.
```PHP
public function isvalid() {
    $this->Response()->setHeader("Content-Type", "text/html")->setContent("Yes");
}
```
In the above example, calling `www.sitename.com/plugin_name/action_name/isvalid` will print `Yes` to the page.

A complex Method is one that does accept arguments to be passed in via either `$_GET` or `$_POST`.
```PHP
public function isvalid($status) {
    $this->Response()->setHeader("Content-Type", "text/html")->setContent($status == "Y" ? "Yes" : "No");
}
```
Now calling the above example using the same request URL will result in an `\Exception` stating `Missing required endpoint parameter (status)!`.

Notice that the endpoint `isvalid` requires (1) parameter with the name **status** - as defined in the Method's argument list. To provide that argument to the Method a request URL such as
```
www.sitename.com/plugin_name/action_name/isvalid/Y/
```
or
```
www.sitename.com/plugin_name/action_name/isvalid?status=Y
```
must be called. The same rule applies to `$_POST` requests. Furthermore, notice that the value is passed via the URL path in the first URL, as opposed to the second URL, where the parameter **status** is visible in the query string. This works in the first cases since the b2uFramework will know to assign the first path section after the Method's name in the URL to the Method's first argument in the function's signature.

***@note -*** _Passing the first argument in both the URL path and query string, or `$_POST` parameters, will give higher priority to the value provided via the query string or `$_POST` parameter, over the path URL._

***@note -*** _In some instances, a Method may want to provide optional parameters as part of its function signature. This can be achieved by assigning a default value to the argument in the function signature (e.g., In the above example `public function isvalid($status = "Y")` will allow calls to the Method with or without the **status** parameter)._

## Isolating Action Methods to Request Methods
In many circumstances an application would want to limit how an Action's Method(s) can be accessed based on the request method (`GET`, `POST`, `PUT`, `PATCH`, and `DELETE`). This can be accomplished using the `callOn()` method in the `__construct(...)` of the Action. Below an example is provdied that will only allow `foo()` to be called when `POST` and `PUT` methods are received.
```PHP
<?php
class action_name extends \B2U\Core\Action implements \B2U\Core\IAction {

    function __construct($method, & $params, & $response) {
        parent::__construct($method, $params, $response);
        
        // this call indicates that the Method foo will only support POST and PUT
        $this->callOn(["POST", "PUT"], [$this, 'foo']);
        
        // added incase application makes a call to the /acion_name/ via GET
        $this->Response()->setHeader("Content-Type", "text/html")
                          ->setContent("GET called on action_name");
    }
    
    function foo() {
        // called only on POST and PUT
    }
}
```
***@note -*** _It is also possible to include the initial `GET` to the Action as a `callOn()` method defintion. In this case the `callOn()` will be defined within the `__construct(...)` of the Action with an **Anonymous** function definition. There can only be one anonymous function assigned to an Action per request method._
```PHP
class action_name extends \B2U\Core\Action implements \B2U\Core\IAction {

    function __construct($method, & $params, & $response) {
        parent::__construct($method, $params, $response);
        
        // this call indicates that the Method foo will only support POST and PUT
        $this->callOn(["GET"], function() {
              
              // executed on call to the /acion_name/ via GET
              $this->Response()->setHeader("Content-Type", "text/html")
                                ->setContent("GET called on action_name");
        });        
    }
}
```

# Methods
```PHP
\B2U\Core\Action
    modifyRequest()
```
@return - `Array` - Returns the instance of the `$this->Parameters` array.

The b2uframework calls this function before calling an Action's Method to provide plugin developers the ability to modify the data in the `$this->Parameters` array. This is useful in cases where a plugin will generate data in arbitrary fields, and the developer would want these to be accessible through the `Parameters` array as a first-level key-value entry. An example is available in the B2uPanelAction as part of the b2upanel jQuery plugin.
##
```PHP
\B2U\Core\Action
    callOn($methods, $callback)
```
@param **$methods** - `Array` - An array of one or more supported request methods (`GET`, `POST`, `PUT`, `PATCH`, and `DELETE`)

@param **$callback** - `Array or Function` - Can be an anonymous function or an `Array` with the following signature `[$this, 'method_name']` where `'method_name'` is a `string` representing the Method within the Action.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
