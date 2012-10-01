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
2. Open Configuration.php and override any constants from Defaults.php.
3. Open the site in your browser. A `cache` and `logs` folder outside `public` will be created, as well as a `public/content` folder with subfolders.


## Concepts

Posts are listed in the index page. Pages contain a section of YAML followed by Markdown, by default.
Pages just contain markdown content, by default. In the _basic_ theme, pages are linked from the footer. 
Configuration settings override the defaults.
Manage your content types and theming logic using the classes in the `/application` folder.

## Getting started

* Create your first page: `/content/pages/index.md`. 
* Create your first post: Navigate to `http://localhost/admin/new` to download a template and save it in `/content/posts/2012/09/first-post.md`. 
* Create a 404: `/content/errors/404.md`. Now non-existing links will point here. Error pages follow the `page` data model.
* Enable caching: open `/Configuration.php`.  set `const CACHE_ENABLED = true;`. Pages remain cached until its cache-file is deleted.


## Externals

Carbon will support third-party plugins (externals). Simply drop a [PHP autoloader](http://php.net/manual/en/language.oop5.autoload.php) compatible class into the `system/Ext` folder and call the class in the code. See the php manual page for more info on autoloading classes. Feel free to organise classes using folders, with no naming requirements.

Carbon will register any externals and autoload them. It comes with markdown and yaml support courtesy of [PHP Markdown Extra](http://michelf.ca/projects/php-markdown/) and [Spyc](https://github.com/mustangostang/spyc/).