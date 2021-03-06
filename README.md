[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Distilleries/LayoutManager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Distilleries/LayoutManager/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Distilleries/LayoutManager/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Distilleries/LayoutManager/?branch=master)
[![Build Status](https://travis-ci.org/Distilleries/LayoutManager.svg)](https://travis-ci.org/Distilleries/LayoutManager)
[![Total Downloads](https://poser.pugx.org/distilleries/layout-manager/downloads)](https://packagist.org/packages/distilleries/layout-manager)
[![Latest Stable Version](https://poser.pugx.org/distilleries/layout-manager/version)](https://packagist.org/packages/distilleries/layout-manager)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)


# Laravel 5 Layout Manager

Requires expendable with form-builder.

## Table of contents
1. [Installation](#installation)
2. [Basic usage](#basic-usage)
    1. [Configuration](#1-configuration)
    2. [Create templates](#2-create-templates)
3. [Template Styling](#template-styling)
4. [Options](#options)
    1. [Categories](#1-categories)
    2. [Filter templates](#2-filter-templates)
    3. [Custom tags](#3-custom-tags)
    4. [Disable add and ordering](#4-disable-add-and-ordering)
    5. [Special classes](#5-special-classes)
5. [Troubleshooting](#troubleshooting)

##Installation

Add on your composer.json

``` json
    "require": {
        "distilleries/layout-manager": "1.*",
    }
```

Add on your bower.json

``` json
    "dependencies": {
        "sortablejs": "1.4.2",
    }
```

Add on your build.config.js

``` json
    "admin": {
        "app_files": {
            "js": {
                "bower_components/sortablejs/Sortable.min.js"
            }
        }
    }
```

Import the sass into your application.admin.scss

``` sass
    // ...
    @import "../../../../vendor/distilleries/layout-manager/src/resources/assets/sass/layout-manager";
```

run `composer update`.

Add Service provider to `config/app.php`:

``` php
    'providers' => [
        // ...
       Distilleries\LayoutManager\LayoutManagerServiceProvider::class,
       Distilleries\LayoutManager\LayoutManagerRouteServiceProvider::class
    ]
```

Add the controller to your admin menu `config/expendable.php`:

``` php
{
    // ...
    'menu' => \Distilleries\Expendable\Config\MenuConfig::menu([
        'left'  => [
                [
                    'icon'    => 'blackboard',
                    'action'  => '\Distilleries\LayoutManager\Http\Controllers\Admin\TemplateController@getIndex',
                    'libelle' => 'menu.templates',
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => 'menu.list',
                            'action'  => '\Distilleries\LayoutManager\Http\Controllers\Admin\TemplateController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => 'menu.add',
                            'action'  => '\Distilleries\LayoutManager\Http\Controllers\Admin\TemplateController@getEdit',
                        ],
                    ]
                ],
        ]
}
```

Add Template field type in `config/form-builder.php`:

``` php
    [
        // ...
        'template'           => 'layout-manager::form.template',
        'custom_fields' => [
            // ...
            'template'         => 'Distilleries\LayoutManager\FormBuilder\Fields\Template',
        ],
    ]
```

Export the configuration:

```ssh
php artisan vendor:publish --provider="Distilleries\LayoutManager\LayoutManagerServiceProvider"
```

Export the views:

```ssh
php artisan vendor:publish --provider="Distilleries\FormBuilder\FormBuilderServiceProvider"  --tag="views"
```


##Basic usage

###1. Configuration

To enable the layout manager in one of you models, you need to update the model first.
It should implements TemplatableContract and use TemplatableTrait


``` php
class Project extends Distilleries\Expendable\Models\BaseModel implements TemplatableContract
{
    use TemplatableTrait;

    // ...
}
```

You can now uses templatable in you Form:

``` php
class ProjectForm extends Distilleries\FormBuilder\FormValidator
{
    // ...
    public function buildForm()
    {
    // ...
        $this->add('templatable', 'form', [
             'label' => trans('layout-manager::form.templatable'),
             'icon'  => 'link',
             'class' => FormBuilder::create('Distilleries\LayoutManager\Forms\TemplatableForm', [
                 'model' => $this->model,
             ]),
        ]);
    }
    // ...
}
```

The user will now be able to create/order/edit/remove content based on your own templates.



###2. Create templates

You can create your own templates on the related form in the back-office.
Here is a description of each fields that compose a unique template:


Field | Description
----- | -----
Title  | The title that will be shown in the back-office "Add template" dropdown list
Css class | A Unique Css class applied to the template, can be usefull if you want to create your custom css style
Html   |  The template itself. You can put here HTML tags but also custom tags. See [Custom tags](#custom-tags)
Plugins   | TinyMCE Inline plugins you want to add when editing this template.
Toolbar | TinyMCE Inline toolbar you want to display when editing this template.




##Template Styling

Good practice is to re-use your frontend styling when using LayoutManager.
It will allow your contributors to edit content as if they were on the front-end.
To do so, create a **folder** in the `sass` folder of your **frontend**.
Create one unique `.sass` file for each template, and import this file on each frontend and backend `application.scss`. This template needs to be independant and work in "standalone" (i.e. not related to a container).

This way your style will be displayed on the backoffice as well as on your front.


##Options

###1. Categories

When adding content to your model based on your own templates, you may need to categorize them.
For example, you may need to show your content within tabs. Each tabs can be defined as a category in LayoutManager.

To do so, you can pass an array of categories in your model's form class like so :


``` php
class ProjectForm extends Distilleries\FormBuilder\FormValidator
{
    // ...
    public function buildForm()
    {
    // ...
        $this->add('templatable', 'form', [
             'label' => trans('layout-manager::form.templatable'),
             'icon'  => 'link',
             'class' => FormBuilder::create('Distilleries\LayoutManager\Forms\TemplatableForm', [
                 'model' => $this->model,
                 'categories' => [
                     'summary' => 'Summary of the project',
                     'authors' => 'Authors and credits',
                 ]
             ]),
        ]);
    }
    // ...
}
```

The `categories`'s key is the unique string saved in the database to match the category and the `categories`'s value is the text displayed to the contributor in the backoffice.

###2. Filter templates

The dropdown-list of all the templates the contributor is allowed to add displays ALL the templates by default.
You can pre-filter this list to allow only a preset of the templates.
Just pass an array of Templates of you own choice in your model's form class:


``` php
class ProjectForm extends Distilleries\FormBuilder\FormValidator
{
    // ...
    public function buildForm()
    {
    // ...
        $this->add('templatable', 'form', [
             'label' => trans('layout-manager::form.templatable'),
             'icon'  => 'link',
             'class' => FormBuilder::create('Distilleries\LayoutManager\Forms\TemplatableForm', [
                 'model' => $this->model,
                 'templates' => Template::whereIn('css_class', ['bo-banner-image', 'bo-underlined-header'])->get()
             ]),
        ]);
    }
    // ...
}
```
The above example will allow the contributor to add only Templates with css class `bo-banner-image` and `bo-underlined-header`.


###3. Custom tags

Your frontend may use custom HTML tags (using VueJS or AngularJS).
LayoutManager can parse these custom-tags and ask to the contributor to fill some datas.
For example, you can have you own `video-player` HTML tag that may need a Youtube ID, like so:

``` html
<video-player youtube-id="XXXXXX"></video-player>
```

You can configure LayoutManager to parse these tags and ask the contributor to fill the youtube-id attribute himself.
You just need to list all the custom tags in the model's form and their related attributes that need an input from the contributor:


``` php
class ProjectForm extends Distilleries\FormBuilder\FormValidator
{
    // ...
    public function buildForm()
    {
    // ...
        $this->add('templatable', 'form', [
             'label' => trans('layout-manager::form.templatable'),
             'icon'  => 'link',
             'class' => FormBuilder::create('Distilleries\LayoutManager\Forms\TemplatableForm', [
                 'model' => $this->model,
                 'custom-tags' => [
                     'video-player' => [
                         'youtube_id',
                     ],
                 ]
             ]),
        ]);
    }
    // ...
}
```

This way, every video-player attributes will be clickable in the back-office, a modal will appear that will ask the user to fill `youtube_id`.
The attribute's label is translated using `trans(forms.template.youtube_id)`.

###4. Disable add and ordering

If you want your contributors to edit a pre-defined number of templates, and you don't want them to be able to add, duplicate or reorder the templates, you can use the `disableAdd` option.
It can be set either to `true`, or to an array of categories (keys) to only disable it for a list of categories.
``` php
class ProjectForm extends Distilleries\FormBuilder\FormValidator
{
    // ...
    public function buildForm()
    {
    // ...
        $this->add('templatable', 'form', [
             'label' => trans('layout-manager::form.templatable'),
             'icon'  => 'link',
             'class' => FormBuilder::create('Distilleries\LayoutManager\Forms\TemplatableForm', [
                 'model' => $this->model,
                 'disableAdd' => ['summary'],
                 'categories' => [
                     'summary' => 'Summary of the project',
                     'authors' => 'Authors and credits',
                 ]
             ]),
        ]);
    }
    // ...
}
```
This configuration will disable the add/duplicate/order feature only for the templates under 'summary' category.

###5. Special classes

#### Image
If you define a `<div>` (or any tag you want) with the CSS class `template-image`, Layout Manager will recognize it and render it as a clickable container.
MoxiManager will open on-click and allow the contributor to choose an image that will be displayed in the `background-url` style of the tag.


##Troubleshooting

@TODO : Handle errors and prevent model form submiting when a template error occurs.