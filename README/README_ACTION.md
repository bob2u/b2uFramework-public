# \B2U\Core\Action

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

The cornerstone to using the b2uFramework is the creation of _Actions_ within _Plugins_. As defined earlier, @see [Terminology](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology), _Plugins_, _Actions_, and _Methods_ define the components of request URLs sent to the b2uFramework for processing. While not all parts are required in a valid request, a typical request to the b2uFramework will look like: `www.sitename.com/plugin/action/method`.

## Understanding Plugins
Understanding _Plugins_ is a prerequisite to understanding _Actions_. Although the representation of _Plugins_ is simple (i.e., It is a Directory), the conceptual use may be alien to some developers. To help identify what would constitute to a _Plugin_ the following guidelines are recommended:

* A Plugin represents a single theme
* Plugins are unit modules of a website/application
* Plugins are re-usable modules of a website/application
* Plugins are not Interfaces, but rather portions of an actual website/application
* Plugins can have one or more common themed Actions defined within them

One example of a Plugin for a website could be a **User Profile** Plugin. This Plugin, if designed generically and adequately, can be used in other website projects. A User Profile Plugin may have multiple Actions organized based on roles (e.g., Admin, User) or only one Action to manage all functionalities for a user's profile. These functionalities, or Methods, can include _profile image upload_, _account validation_, _password reset_, _profile detail update_, etc.

In the above example, we can see that the Plugin represents a single theme (_User Profile_), and it is a unite module within a website that can be re-used in other web projects as needed.

***@note -*** _Plugins are required and will always be the first portion of any b2uFramework request URL. They may even be the only portion (e.g., `www.sitename.com/plugin`), which will be explained later._

## Constructing an Action


* **Method (Function) -**  The _Default_ Method for all Actions is their `__construct(...)`

 Parameters can be passed vai `$_GET` by either calling: 

`www.sitename.com/plugin/action/method/var1/var2/var3...`

or 

`www.sitename.com/plugin/action/method?var1_name=var1=&var2_name=var2&var3_name=var3...`

Calling `www.sitename.com/plugin/action` with no Method will execute the `__construct(...)` of the Action class.

Calling `www.sitename.com/plugin` with no Action will execute the ***index.php***'s `class index`'s `__construct(...)`, and if either does not exists the site will throw an exception.

In the section [Understanding index.php](https://github.com/bob2u/b2uFramework-public#understanding-indexphp) the default Action located in our directory root can be seen - `class index`.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
