# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).



## THEMING Description
[![Laravel](https://img.shields.io/badge/Laravel-5.x-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)
[![Build Status](https://img.shields.io/travis/igaster/laravel-theme.svg)](https://travis-ci.org/igaster/laravel-theme)
[![Downloads](https://img.shields.io/packagist/dt/igaster/laravel-theme.svg?style=flat-square)](https://packagist.org/packages/igaster/laravel-theme)

This is a package for the Laravel 5 Framework that adds basic support for managing themes. It allows you to seperate your views & your assets files in seperate folders, and supports for theme extending! Awesome :)

Features:

* Views & Asset separation in theme folders
* Theme inheritance: Extend any theme and create Theme hierarchies (WordPress style!)
* Integrates [Orchestra/Asset](http://orchestraplatform.com/docs/3.0/components/asset) to provide Asset dependencies managment
* Your App & Views remain theme-agnostic. Include new themes with (almost) no modifications

#### For Laravel 5.0 & 5.1, please use the [v1.0.x branch](https://github.com/igaster/laravel-theme/tree/v1.0)

## How it works

Very simple, you create a folder for each Theme in 'resources/views' and keep all your views separated. 
The same goes for assets: create a folder for each theme in your 'public' directory. Set your active theme and you are done. 
The rest of your application remains theme-agnostic�, which means that when you `View::make('index')` you will access the `index.blade.php` from your selected theme's folder. Same goes for your assets.

## Installation

install with

    composer require "igaster/laravel-theme"

Add the service provider in `app/config/app.php`, `Providers` array:

    igaster\laravelTheme\themeServiceProvider::class,

also edit the `Facades` array and add:

    'Theme' => igaster\laravelTheme\Facades\Theme::class,

Almost Done. You can optionally publish a configuration file to your application with

    php artisan vendor:publish --provider="igaster\laravelTheme\themeServiceProvider"

That's it. You are now ready to start theming your applications!

## Defining themes

Heads up: Defining a theme is completely optional. You may not touch the config file as long as the defaults fits you! 
If you want more control then you can define your themes in the `themes` array in [config/themes.php](https://github.com/igaster/laravel-theme/blob/master/src/config.php). 
The format for every theme is very simple:

```php
// Select a name for your theme
'theme-name' => [

    /*
    |--------------------------------------------------------------------------
    | Theme to extend. Defaults to null (=none)
    |--------------------------------------------------------------------------
    */
    'extends'	 	=> 'theme-to-extend',

    /*
    |--------------------------------------------------------------------------
    | The path where the view are stored. Defaults to 'theme-name' 
    | It is relative to 'themes_path' ('/resources/views' by default)
    |--------------------------------------------------------------------------
    */
    'views-path' 	=> 'path-to-views',
    
    /*
    |--------------------------------------------------------------------------
    | The path where the assets are stored. Defaults to 'theme-name' 
    | It is relative to laravels public folder (/public)
    |--------------------------------------------------------------------------
    */
    'asset-path'    => 'path-to-assets',

    /*
    |--------------------------------------------------------------------------
    | Custom configuration. You can add your own custom keys.
    | Retrieve these values with Theme::config('key'). e.g.:
    |--------------------------------------------------------------------------
    */
    'key'           => 'value', 
],
```
all settings are optional and can be omitted. Check the example in the configuration file... 
If you are OK with the defaults then you don't even have to touch the configuration file. If a theme has not been registered then the default values will be used!

## Extending themes

You can set a theme to extend an other. When you are requesting a view/asset that doesn't exist in your active theme, then it will be resolved from it's parent theme. 
You can easily create variations of your theme by simply overriding your views/themes that are different. 

All themes fall back to the default laravel folders if a resource is not found on the theme folders. 
So for example you can leave your common libraries (jquery/bootstrap ...) in your `public` folder and use them from all themes. 
No need to duplicate common assets for each theme!

## Working with Themes

The default theme can be configured in the `theme.php` configuration file. Working with themes is very straightforward. Use:

```php
Theme::set('theme-name');        // switch to 'theme-name'
Theme::get();                    // retrieve current theme's name
Theme::current();                // retrieve current theme's object
Theme::config('key');            // read current theme's configuration value for 'key'
Theme::configSet('key','value'); // assign a key-value pair to current theme's configuration
```

You are free to create your own implementation to set a Theme via a ServiceProvider, or a Middleware, or even define the Theme in your Controllers. 

## Building your views

Whenever you need the url of a local file (image/css/js etc) you can retrieve its path with:

```php
Theme::url('path-to-file')
```

The path is relative to Theme Folder (NOT to public!). For example, if you have placed an image in `public/theme-name/img/logo.png` your Blade code would be:

    <img src="{{Theme::url('img/logo.png')}}">

When you are referring to a local file it will be looked-up in the current theme hierarchy, and the correct path will be returned. 
If the file is not found on the current theme or its parents then you can define in the configuration file the action that will be carried out: 
`THROW_EXCEPTION` | `LOG_ERROR` as warning (Default) | `ASSUME_EXISTS` assumes the file does exist and returns the path | `IGNORE` completely.

Some useful helpers you can use:

```php
Theme::js('file-name')
Theme::css('file-name')
Theme::img('src', 'alt', 'class-name', ['attribute' => 'value'])
```    

## 'setTheme' middleware (Laravel 5.2+)

A [helper middleware](https://github.com/igaster/laravel-theme/blob/master/src/Middleware/setTheme.php) is included out of the box if you want to define a Theme per route. To use it:

First register it in `app\Http\Kernel.php`:

```php
protected $routeMiddleware = [
    // ...
    'setTheme' => \igaster\laravelTheme\Middleware\setTheme::class,
];
```

Now you can apply the middleware to a route or route-group. Eg:

```php
Route::group(['prefix' => 'admin', 'middleware'=>'setTheme:ADMIN_THEME'], function() {
    // ... Add your routes here 
    // The ADMIN_THEME will be applied.
});
```
For a more advanced example check demo application: [Set Theme in Session](https://github.com/igaster/laravel-theme-demo) 

## Parametric filenames

You can include any configuration key of the current theme inside any path string using *{curly brackets}*. For example:

```php
Theme::url('jquery-{version}.js')
```

if there is a `"version"` key defined in the theme's configuration it will be evaluated and then the filename will be looked-up in the theme hierarchy. 
(e.g: many commercial themes ship with multiple versions of the main.css for different color-schemes, or you can use [language-dependent assets](https://github.com/igaster/laravel-theme/issues/17))

## Handling Vendor paths (eg for Package Development)

When you are namespacing your views then Laravel will look up for view files into the `vendor` folder of the active theme:

```php
view('VENDOR_NAME::viewName'); //  \theme_Path\vendor\VENDOR_NAME\viewName.blade.php
```

You can optionally redefine each Namespace's path for each theme. Within a theme's configuration you can define the `namespace-overrides` associative array:

```php
'theme-name' => [

    'namespace-overrides' => [
        'ns-a' => ''           // view('ns-a::viewName') = /themePath/viewName.blade.php
        'ns-b' => 'modules'    // view('ns-b::viewName') = /themePath/modules/viewName.blade.php
        //ns-c not in array so // view('ns-c::viewName') = /themePath/vendor/ns-c/viewName.blade.php
    ]

    // .... theme configuration
]
```

## Assets Management (Optional)

This package provides integration with [Orchestra/Asset](http://orchestraplatform.com/docs/3.0/components/asset) component. 
All the features are explained in the official documentation. If you don't need the extra functionality you can skip this section. 
Orchestra/Asset is NOT installed along with this package - you have to install it manually.

To install Orchestra\Asset you must add it in your composer.json (see the [Official Documentation](https://github.com/orchestral/asset)):

    "orchestra/asset": "~3.0",
    "orchestra/support": "~3.0",

and run `composer update`. Then add the Service Providers in your Providers array (in `app/config/app.php`):

    Orchestra\Asset\AssetServiceProvider::class,
    Collective\Html\HtmlServiceProvider::class,

Add the Asset facade in your `aliases` array:

    'Asset' => Orchestra\Support\Facades\Asset::class,

Now you can leverage all the power of Orchestra\Asset package. However the syntax can become quite cumbersome when you are using Themes + Orchestra/Asset, 
so some Blade-specific sugar has been added to ease your work. Here how to build your views:

In any blade file you can require a script or a css:

    @css('filename')
    @js('filename')
    @jsIn('container-name', 'filename')

Please note that you are just defining your css/js files but not actually dumping them in html. Usually you only need write your css/js declaration 
in one place on the Head/Footer of you page. So open your master layout and place:

    {!! Asset::styles() !!}
    {!! Asset::scripts() !!}
    {!! Asset::container('container-name')->scripts() !!}

exactly where you want write your declarations.

## Assets dependencies

This is an [Orchestra/Asset](http://orchestraplatform.com/docs/3.0/components/asset) feature explained well in the official documentation. Long story short:

    @css ('filename', 'alias', 'depends-on')
    @js  ('filename', 'alias', 'depends-on')

and your assets dependencies will be auto resolved. Your assets will be exported in the correct order. The biggest benefit of this approach is that you don't have to move all your declerations in your master layout file. Each sub-view can define it's requirements and they will auto-resolved in the correct order with no doublications. Awesome! A short example:

    @js  ('jquery.js',    'jquery')
    @js  ('bootstrap.js', 'bootsrap', jquery)

## FAQ:

##### Is this package compatible with AWS?
Yes with one exception: If you are building Theme hierarcies, asset's will not be looked up on the parent theme. Performing file searching on a remote repository is not the best practice. Should be addressed in a future version... However Blade templates auto-discovery works fine since they are local files.

##### What about external assets (eg CDN)?
Link directly to your external assets. Every url that starts with http(s) will not be proccesed by default.

##### Can I place my themes in a different path than Laravel's views folder?
Yes. Set the `themes_path` option in `themes.php` configuration file to any path. However the default Laravel views path will be used as a fallback when a view is requested and can not be located in any other folder.

##### How do I change the public path?
Rebind Laravel's 'path.public'. [(More info)](https://laracasts.com/discuss/channels/general-discussion/where-do-you-set-public-directory-laravel-5)

##### I'm editing a view but I don't see the changes
Laravel is compiling your views every-time you make an edit. A compiled view will not recompile unless you make any edit to your view. You can manually clear compiled views with `artisan view:clear`.Keep this in mind while you are developing themes...
