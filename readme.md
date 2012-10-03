# Carbon
Carbon is a hackable performant (semi) static blogging system. 

_It should be considered early alpha._

A [screenshot of the default theme](http://i.imm.io/FV6p.png):
![Screenshot of the defaul theme](http://i.imm.io/FV6p.png)


## Aims

* Easy to learn
* Easy to hack & extend (with basic PHP knowledge)
* Performant


## Installation

Carbon requires PHP 5.3+ and has only been tested so far on IIS 6.1 / Windows. I'll soon test it under Apache / Ubuntu.

1. Check out this repository and point your webserver to the public folder.
2. Open `public/Configuration.php` and override any constants from `public/system/Defaults.php`.
3. Open the site in your browser. A _cache_ and _logs_ folder outside _public_ will be created, as well as a _public/content_ folder with subfolders for your content.


## Concepts

__Posts__ are listed in the index page. Pages contain a section of YAML followed by Markdown, by default.<br>
__Pages__ just contain markdown content, by default. In the _basic_ theme, pages are linked from the footer. <br>
__Configuration__ settings override the defaults.<br>
Manage your __data models and theming logic__ using the MVC classes in the _public/application_ folder.<br>


## Basic configuration options

open `public/Configuration.php` to:

* Enable administration functions: set `const ADMIN_PASSWORD = "your passphrase";` then visit http://localhost/index.php/admin to login.
* Pretty URLs: set `const INDEX_PAGE = '';` (Apache requires mod_rewrite, IIS requires URL Rewrite). This removes `/index.php` from all urls (eg: http://localhost/index.php/admin/new becomes http://localhost/admin/new);


## Getting started

* Create your first page: `/content/pages/index.md`. 
* Create your first post: Navigate to _Admin > Create post template_ to download a _post_ template and save it in `/content/posts/2012/09/first-post.md`. 
* Create a 404: `/content/errors/404.md`. Now non-existing links will point here. Error pages follow the _page_ data model.


## Caching

To enable caching: open `public/Configuration.php` and set `const CACHE_ENABLED = true;`. Pages remain cached until its cache-file is deleted, manually or through _Admin > Clear Cache_.


## Full static site generation

Navigate to _Admin > Generate static site_. The `cache` folder now contains a full static site.

## Externals

Carbon will support third-party plugins (externals). Simply drop a [spl_autoload_register](http://www.php.net/manual/en/function.spl-autoload-register.php) compatible class into the `system/Ext` folder and call the class in the code. See the php manual page for more info on autoloading classes. Feel free to organise classes using custom folders.

Carbon will register any externals and autoload them. It comes with markdown and yaml support courtesy of [PHP Markdown Extra](http://michelf.ca/projects/php-markdown/) and [Spyc](https://github.com/mustangostang/spyc/).