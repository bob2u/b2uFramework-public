# \B2U\Core\Module

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

Reusability is a key design factor in the b2uFramework, and _Interfaces_ plays a pivotal role in realizing this objective. As defined previously, an _Interface_ is a unit code encapsulating a third-party library or a custom reusable library. b2uFramework provides a way to group and organize _Interfaces_ through the use of pre-defined categories - @see [Terminology:Interfaces](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#terminology). 

For example, the most common _Interface_ category would be the **Database** category. _Modules_ that would be defined under this could be custom libraries, or third-party libraries, to support various database technologies, such as _MySQL_, _Oracle_, _DynamoDB_, _MongoDB_, _Cassandra_, etc.

In practice, each _Module_ would be contained within a directory. Using the `\B2U\Core\Manager\`'s `setup(...)` functionality, an application would load these libraries into the b2uFramework for use by all Actions and other Interfaces/Modules. @see [\B2u\Core\Manager](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_MANAGER.md#methods) for details on how to use `getInterface()`.

## Defining a Module
The syntax for defining a Module class begins with deriving from 

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_ACTION.md#b2ucoreaction)
