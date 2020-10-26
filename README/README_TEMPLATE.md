# \B2U\Core\HTMLTemplate

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

Building dynamic HTML pages that are data-driven by the underlying PHP code is standard in MVC design patterns. In b2uFramework, the `\B2U\Core\HTMLTemplate` provides the necessary separation between the **View** and **Controller** through a simple templating mechanism. To use the `\B2U\Core\HTMLTemplate` class, a developer needs to build an HTML file that will contain the template content. Once the file is prepared, following specific rules and standards, it is then loaded by the `\B2U\Core\HTMLTemplate` class object and populated with dynamic data before finally being compiled into a post-processed output `string`.

## Writing an HTML Template
`\B2U\Core\HTMLTemplate` defines (2) two main components that can be combined to create complex templates. These are:

1. **Variables** - Variables are dynamic parameters on the HTML page to be populated with data. They provide needed functionality to set and get their values. A Variable is defined using a syntax of `{var:variable_name}`.

2. **Panels** - Panels are segments within the HTML page that provide the functionality to toggle their visibility. A Panel can contain Variables. They can also contain other nested Panels. A Panel section is defined using a syntax of `<!--panel:panel_name-->` and a corresponding closing tag with the same syntax and name.

***@note -*** _When defining Variables and Panels nested within another Panel, they cannot share the same name as their parent Panel._

***@note -*** _Panels can also be defined in JavaScript section by enclosing them inside of inline comments (`/*<!--panel:panel_name-->*/`)._

An example of an HTML template that demonstrates all component variations is as follows.

```HTML
<div>
    <p>{var:Var1}</p>         -- A variable is defined at the root of the page
    <!--panel:PanelA-->       -- A panel is defined called PanelA
    <div>
        <p>{var:Var2}</p>     -- A variable is defined within PanelA
        <!--panel:PanelB-->   -- A panel is defined within PanelA called PanelB
        <p>{var:Var3}</p>     -- A variable is defined within PanelB within PanelA
        <!--panel:PanelB-->   -- PanelB section closing 
    </div>
    <!--panel:PanelA-->       -- PanelA section closing 
</div>
```

3. **Includes** - Includes allow a template to broken into other template pages, and _included_ into a single document using the `{include:path_to_file}` syntax.
## Populating an HTML Template
Once an HTML template has been built, it can be loaded using a `\B2U\Core\HTMLTemplate` class instance. Loading an HTML template using this class will parse and construct a PHP derived OOP interface to the HTML file's Panels and Variables. An example of this process using the previous sections HTML template is demonstrated below.

```PHP
$page = new \B2U\Core\HTMLTemplate("slash_terminated_template_file_directory", "template_name.html");

// examples of setting Variables, and Panel nested Variables
$page->Var1->setValue("Welcome");
$page->PanelA->Var2->setValue("to");
$page->PanelA->PanelB->Var3->setValue("b2uFramework!");

// example of hiding a Panel section
$page->PanelA->PanelB->setVisible(false);
```

# Methods
```PHP
\B2U\Core\HTMLTemplate
    __construct($dir, $file, $data = [])
```
@param **$dir** - `string` - Path to the HTML template file to load.

@param **$file** - `string` - File name to load.

@param **$data** - `Array` - (optional) Used to initialize the variables and panels at construction.

@return - `\B2U\Core\HTMLTemplate` - On a successful load of the template file, an instance to a `\B2U\Core\HTMLTemplate` object is returned.

```PHP
\\ eample using the inline initialization using our template html from above
$page = new \B2U\Core\HTMLTemplate("slash_terminated_template_file_directory", "template_name.html", [
    "Var1" => "Welcome",
    "PanelA" => [
        "Var2" => "to",
        "PanelB" => [
            "visible" => false,
            "Var3" => "b2uFramework!"
        ]
    ],
]);

``
##
```PHP
\B2U\Core\HTMLTemplate::addKey($key, $value)
```
@param **$key** - `string` - A key name, represented by `{key:key_name}`, to be replaced with the value provided within a template file.

@param **$value** - `string` - The value to replace a key with.

This is a static utility function that allows the application to register global $key/$value pairs that will be automatically processed within an HTML template loaded using the `\B2U\Core\HTMLTemplate` object framework. Keys should be identified within the HTML file with the syntax `{key:key_name}`, where the `key_name` would be the $key value provided using this function.
##
```PHP
\B2U\Core\HTMLTemplate
    exists($key)
```
@param **$key** - `string` - Panel or Variable name to lookup.

@return - `bool` - If the Panel or Variable is found as a child of the HTML root `true` is returned, else `false` will be returned.
##
```PHP
\B2U\Core\HTMLTemplate
    getContent()
```
@return - `string` - Compile the result of all Panels and Variables into a single `string`.

This function is generally called once after all Panel's visibilities have been adjusted, and all Variables have been assigned values, to compile the HTML template into a single `string` object that can be set as the content parameter to a response.
##
```PHP
\B2U\Core\HTMLPanel
    setVisible($val)
```
@param **$val** - `bool` - Toggle the visibility of a given Panel. All Panels are visible (`true`) by default, unless explicitly set to `false`.

Once a Panel is set to `false`, and `getCOntent()` is called on an `\B2U\Core\HTMLTemplate` or `\B2U\Core\HTMLPanel` object, then the resulting compiled `string` returned will exclude the Panel and its contents from the final output.
##
```PHP
\B2U\Core\HTMLPanel
    isVisible()
```
@return - `bool` - Return the current visibility status of a given Panel. 
##
```PHP
\B2U\Core\HTMLPanel
    exists($key)
```
@param **$key** - `string` - Panel or Variable name to lookup..

@return - `bool` - If the Panel or Variable is found as a child of the HTML root `true` is returned, else `false` will be returned.

This function performs the same operation as its counterpart in `\B2U\Core\HTMLTemplate`, only at the current Panel level.
##
```PHP
\B2U\Core\HTMLPanel
    getContent()
```
@return - `string` - Compile the result of all Panels and Variables within this Panel into a single `string` - for the Panel only.
##
```PHP
\B2U\Core\HTMLAttribute
    setValue($val)
```
@param **$val** - `string` - Set the value of the Variable to $val.
##
```PHP
\B2U\Core\HTMLAttribute
    getValue()
```
@return - `string` - Retrieves the current value of the Variable.

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README/README_TEMPLATE.md#b2ucorehtmltemplate)
