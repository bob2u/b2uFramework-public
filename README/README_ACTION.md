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

## Constructing an Action
An Action is a PHP file within a Plugin directory. To create an Action:
1) Create a PHP file named after the Action it will represent. The file name is the `/action/` portion in a request URL. Guidelines for naming Actions include:
   * Case sensitive
   * Should follow PHP naming conventions for naming, and 
   * Should only contain URL compatible characters.
   * Use of all lowercase letters and "_" are recommended.
2) Declare a PHP `class` using the same name as the Action file.
3) Derive the class from the required `\B2U\Core\Action` class and `\B2U\Core\IAction` interface.
4) Define the required `__construct(& $params, & $response)` method.
5) Initialize the parent.

Once all steps have been completed, the following should be the final output present:
```PHP
<?php
// The following code would be declared in action_name.php file located in plugin_name/ directory
class action_name extends \B2U\Core\Action implements \B2U\Core\IAction {

    // The default Method for all Actions is the constructor
    function __construct(& $params, & $response) {
    
        // This is a required call in the constructor of all Actions
        parent::__construct($params, $response);
    }
    
    // Define other Methods here ...
}
```
The default Method for all Actions is their `__construct(...)`, and recall that the Method would come **after** the `/action/` portion of a request URL (i.e., `www.sitename.com/plugin/action/method`); therefore, calling `www.sitename.com/plugin_name/action_name` will execute the `__construct(...)` of the `action_name` class since no Method is called in the URL, and the default Method is the class constructor.

***@note -*** _Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class._

It is important to note that it is possible to call a Plugin in a request URL with no Action and Method. The b2uFramework treats this particular case as a unique Action call to an Action file named ***index.php*** with a `class index` declaration. Following the default Method rule, the `class index`'s `__construct(...)` will be called. An excellent example of this use case can be seen in the b2uFramework's entry point - @see [Understanding index.php](https://github.com/bob2u/b2uFramework-public#understanding-indexphp).

***@note -*** _Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception._

***@note -*** _A `\B2U\Core\Response` must be sent back to the requester for all requests sent to the b2uFranework. The `\B2U\Core\Response` object is accessible to all Action's Methods, including the `__consturct(...)`, via the `$this->Response` parameter. An `\Exception` is thrown if a response with a valid content is not sent back to the requester. @see [\B2U\Core\Response](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_RESPONSE.md#b2ucoreresponse) for more details._

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

To access these parameters, all Action Method's can reference the `$this->Parameters` member, which is an associative `Array` of all `$_GET` parameters accessible via their 0 base numeric index - _if passed via the URL path_, or their names - _if given as an argument in a query string_, as a key index into the array. 

## Declaring New Methods



[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
