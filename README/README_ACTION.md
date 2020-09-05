# \B2U\Core\Action

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

The cornerstone to using the b2uFramework is the creation of _Actions_ within _Plugins_. As defined earlier, @see [Terminology](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology), _Plugins_, _Actions_, and _Methods_ define the components of request URLs sent to the b2uFramework for processing. While not all parts are required in a valid request, a typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method`.

## Understanding Plugins
Understanding _Plugins_ is a prerequisite to understanding _Actions_ 

## Constructing an Action
As an example we will create a _Plugin_ to manage all our application accounts, called _Account_. We will create a folder called _Account_ within our application root directory.

* **Method (Function) -**  The _Default_ Method for all Actions is their `__construct(...)`

 Parameters can be passed vai `$_GET` by either calling: 

`www.sitename.com/plugin/action/method/var1/var2/var3...`

or 

`www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...`

Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class.

Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception.

In the section [Understanding index.php](https://github.com/bob2u/b2uFramework-public#understanding-indexphp) the default Action located in our directory root can be seen - `class index`.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
