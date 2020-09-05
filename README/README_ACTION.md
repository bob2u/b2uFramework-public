# \B2U\Core\Action

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

The cornerstone of using b2uFramework is the creation of Actions. As defined earlier, @see [Terminology:Action](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology), an Action is a specific .php file where the file name corresponds to the API endpoint under the Plugin directory. The Action's .php file will contain a class with the same name as the Action file. An Action performs a set of specific tasks (i.e., Methods). Also, to recap, A Method is a unique function within an Action class that will execute a task when requested. ***Plugins, Actions, and Methods define components of request URLs sent to the b2uFramework.*** 

A typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method`

In the section [Understanding index.php](https://github.com/bob2u/b2uFramework-public#understanding-indexphp) the default Action located in our directory root can be found - `class index`.

* **Method (Function) -**  The _Default_ Method for all Actions is their `__construct(...)`

 Parameters can be passed vai `$_GET` by either calling: 

`www.sitename.com/plugin/action/method/var1/var2/var3...`

or 

`www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...`

Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class.

Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
