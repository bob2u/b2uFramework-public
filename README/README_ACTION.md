
[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

* **Method (Function) -** A Method is a unique function within an Action class that will execute a task when requested. The _Default_ Method for all Actions is their `__construct(...)`

A typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method` Parameters can be passed vai `$_GET` by either calling: 

`www.sitename.com/plugin/action/method/var1/var2/var3...`

or 

`www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...`

Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class.

Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
