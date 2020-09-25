# \B2U\Core\Module

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

Reusability is a key design factor in the b2uFramework, and _Interfaces_ plays a pivotal role in realizing this objective. As defined previously, an _Interface_ is a unit code encapsulating a third-party library or a custom reusable library. b2uFramework provides a way to group and organize _Interfaces_ through the use of pre-defined categories - @see [Terminology:Interfaces](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology). 

For example, the most common _Interface_ category would be the **Database** category. _Modules_ that would be defined under this could be custom libraries, or third-party libraries, to support various database technologies, such as _MySQL_, _Oracle_, _DynamoDB_, _MongoDB_, _Cassandra_, etc.

In practice, each _Module_ would be contained within a directory. Using the `\B2U\Core\Manager\`'s `setup(...)` functionality, an application would load these libraries into the b2uFramework for use by all Actions and other Interfaces/Modules. @see [\B2u\Core\Manager](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MANAGER.md#methods) for details on how to use `getInterface()`.

Once an Interface's Module is loaded into the executing script, then it is treated as a singleton for the duration of the script's execution and always accessible across all Actions and Modules.

## Defining a Module
The syntax for defining a Module class begins with deriving a class from `\B2U\Core\Module` and implementing `\B2U\Core\IInterface`. The default constructor must only be overloaded if the _Module_ has dependencies to other _Modules_ within the same or other _Interfaces_.

```PHP
<?php
class module_name extends \B2U\Core\Module implements \B2U\Core\IInterface {

    // The default constructor with the specific signature is required when a
    // Module want to declare dependencies to other Interfaces and/or Modules
    public function __construct(...$args) {
    }
}
```
### Assigning Interface Modules via \B2u\Core\Manager
Modules must be registered with the `B2u\Core\Manager` via calls to `setup(...)`. @see [Manager::setup()](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MANAGER.md#methods).

### Accessing Dependent Modules via \B2U\Core\Manager
Dependencies can be defined using the `uses()` method in the constuctor of a Module, or the `"Uses"` section of a Module during the `Manager`'s `setup` call. When the dependencies between interfaces is defined using the `setup(...)` function it is possible to access them within the Module using local variables.
```PHP
...
\B2U\Core\Manager::instance()->setup([
        "Interfaces" => [
            "Utility" => [
                "A" => [
                    [
                        "Uses" => [
                            "varB" => ["Database", "B", "def0"]     // notice varB usage in class A
                        ],
                        "Path" => "path_to_module_a",
                    ]
                ]
            ],
            "Database" => [
                "B" => [
                    "def0" => [
                        "Path" => "path_to_module_b",
                    ]
                ]
            ]
        ]
    ]);
...
// we can now access the Database\B object in Module A
class A extends \B2U\Core\Module implements \B2U\Core\IInterface {
    public function some_function() {        
        $this->varB->query(...);
    }
}
```
The same interface can also be accessed using the same method as-if `uses()` was called to assign the dependency.
```PHP
class A extends \B2U\Core\Module implements \B2U\Core\IInterface {
    public function some_function() {
        // using {interface category}_{module name}
        $this->getInterface("Database_B")->query(...);
    }
}
```

# Methods
```PHP
\B2U\Core\Module
    uses($interface, $module)
```
@param **$interface** - `string` - Name of supported Interface category.

@param **$module** - `string` - Name of a defined Module within the Interface category.

This function ***MUST*** be called from within the `__construct(...$args)` of another Module. This function aims to enusre that the proper `Uses` defintions have been set in the `\B2U\Core\Manager::setup(...)` function.Using this method to declare dependencies will ensure all required Interfaces are available to a given b2uFramework-based application.

Once the `uses()` has resolved, a Module can access the dependent Module by using the `$this->getInterface(...)` method, and providing the `"{interface_name}_{module_name}"` as the key index into the array, or a variable name - if defined .
##
```PHP
\B2U\Core\Module
    getInterface($name)
```
@return - `object` - Function will return the instance, or `NULL`, of the module loaded using `uses(...)` or `setup(...)` configuration following `"{interface_name}_{module_name}"` format for key $name.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MODULE.md#b2ucoremodule)
