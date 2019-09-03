Published: 2012-10-03 13:32:37
Updated: 2019-9-03 07:37:43


Welcome to Carbon
=================
Thanks for trying out Carbon: a fast, hackable (semi) static blogging system. 

_It should be considered early alpha._

## Aims

Carbon aims to be...

* Fast.
* Easy to adopt.
* Hackable.

### Installation

Carbon is a regular PHP application and requires PHP 7+. It is tested on Ubuntu.

1. Check out this repository and point your webserver to the public folder.
2. Clone `public/Configuration-sample.php` as `public/Configuration.php` and override any constants from `public/system/Defaults.php`.
3. Open the site in your browser. A _cache_ and _logs_ folder outside _public_ will be created, and the example content will load from _public/content_.


### Example Application Concepts

Carbon comes with this example application, complete with archive pages, feeds and homepage index:

* __Posts__ are looped in the index page. Posts contain a section of YAML followed by Markdown, by default.
* __Pages__ just contain markdown content, by default. In the _basic_ theme, pages are linked from the footer.
* Manage your __data models and theming logic__ using the MVC classes in the _public/application_ folder.


### Basic configuration options

open `public/Configuration.php` to change this like:

* Enable administration functions: create an environment variable called CARBON_ADMIN_PASSWORD and a password as the value, then visit [/admin](http://localhost/index.php/admin) to login.
* Change your site title and motto.
* Set the default number of posts shown on the frontpage.
* Change common folder locations (Please submit issues if you find hardcoded locations).

Full details of all configuration options can be found in the wiki, in the future. ;-)

### Getting started

* Create your first page: `/content/pages/index.md`. 
* Create your first post: Navigate to __Admin > Create post template__ to download a _post_ template and save it in `/content/posts/2012/09/first-post.md`. 
* Create a 404: `/content/errors/404.md`. Now non-existing links will point here. Error pages follow the _page_ data model.

### Pretty Urls

By default Carbon uses Apache's mod_rewrite and the provided Nginx configuration to keep urls nice. You can disable this behaviour by opening `public/Configuration.php`: set `const INDEX_PAGE = '/index.php';`. This adds `/index.php` to all urls (eg: [/index.php/admin/new](http://localhost/index.php/admin/new) instead of [/admin/new](http://localhost/admin/new));


### Caching

To enable caching: open `public/Configuration.php` and set `const CACHE_ENABLED = true;`. Pages remain cached until its cache-file is deleted, manually or through __Admin > Clear Cache__. Caching must be enabled to use static site generation.


### Full static site generation

Navigate to __Admin > Generate static site__. The `cache` folder now contains a full static site. 



### Externals

Carbon will support third-party plugins (externals). Simply drop a [spl_autoload_register](http://www.php.net/manual/en/function.spl-autoload-register.php) compatible class into the `system/Ext` folder and call the class in the code. See the php manual page for more info on autoloading classes. Feel free to organise classes using custom folders.

Carbon will register any externals and autoload them. It comes with markdown and yaml support courtesy of [PHP Markdown Extra](http://michelf.ca/projects/php-markdown/) and [Spyc](https://github.com/mustangostang/spyc/).


### Use of images within templates

Put the image in the _/content/images_ folder, and then call the `/images` controller:

![carbon logo](/images/carbon/logo.png)

An image is shown above this paragraph.
