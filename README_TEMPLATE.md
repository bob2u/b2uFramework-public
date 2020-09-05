# \B2U\Core\HTMLTemplate

[Back](https://github.com/bob2u/b2uFramework-public/blob/master/README.md#the-b2ucore-namespace)

Building dynamic HTML pages that are data-driven by the underlying PHP code is standard in MVC design patterns. In b2uFramework, the `\B2U\Core\HTMLTemplate` provides the necessary separation between the **View** and **Controller** through a simple templating mechanism. To use the `\B2U\Core\HTMLTemplate` class, a developer needs to build an HTML file that will contain the template content. Once the file is prepared, following specific rules and standards, it is then loaded by the `\B2U\Core\HTMLTemplate` class object and populated with dynamic data before finally being compiled into a post-processed output `string`.

## Building an HTML Template
`\B2U\Core\HTMLTemplate` defines (2) two main components that can be combined to create complex templates. These are:

1. **Variables** - Variables are dynamic parameters on the HTML page to be populated with data. They provide needed functionality to set and get their values. A Variable is defined using a syntax of `{var:variable_name}`.

2. **Panels** - Panels are segments within the HTML page that provide the functionality to toggle their visibility. A Panel can contain Variables and functionality to check to see if a variable exists within its children. They can also contain other nested Panels. A Panel section is defined using a syntax of `<!--panel:panel_name-->` and a corresponding closing tag with the same syntax and name.

***@note -*** _When defining Variables and Panels nested within another Panel, they cannot share the same name as their parent Panel._

An example of a HTML template that demonstartes all component variations is as follows:
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

[Top](https://github.com/bob2u/b2uFramework-public/blob/master/README_TEMPLATE.md#b2ucorehtmltemplate)
