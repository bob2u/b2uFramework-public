# \B2U\Core\Action

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

@see [Terminology:Action](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology)

* **Action (File/Class) -** An Action is a specific .php file where the file name corresponds to the API endpoint under the Plugin directory. The Action's .php file will contain a class with the same name as the Action file. An Action performs a set of specific tasks (i.e., Methods). 

* **Method (Function) -** A Method is a unique function within an Action class that will execute a task when requested. The _Default_ Method for all Actions is their `__construct(...)`

A typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method` Parameters can be passed vai `$_GET` by either calling: 

`www.sitename.com/plugin/action/method/var1/var2/var3...`

or 

`www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...`

Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class.

Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
