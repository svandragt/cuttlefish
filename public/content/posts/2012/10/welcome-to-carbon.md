Published: 2012-10-03 13:32:37


Welcome to Carbon
=================
Thanks for trying out Carbon. 
Carbon is a hackable performant (semi) static blogging system. 

_It should be considered early alpha._

### Screencasts

1. [Installing Carbon in developer mode on a shared host](http://screencast.com/t/QgDYtKUFpG)
2. [Enable caching for production use](http://screencast.com/t/bRs6taeYUEQl)
3. [Generate a static site](http://screencast.com/t/KqP1GRhNTf)


### Aims

* Easy to learn
* Easy to hack & extend (with basic PHP knowledge)
* Performant


### Installation

Carbon requires PHP 5.3+ and is tested on IIS 6.1 / Windows & Apache / Ubuntu.

1. Check out this repository and point your webserver to the public folder.
2. Open `public/Configuration.php` and override any constants from `public/system/Defaults.php`.
3. Open the site in your browser. A _cache_ and _logs_ folder outside _public_ will be created, and example content loaded from _public/content_.


### Concepts

__Posts__ are listed in the index page. Pages contain a section of YAML followed by Markdown, by default.<br>
__Pages__ just contain markdown content, by default. In the _basic_ theme, pages are linked from the footer. <br>
__Configuration__ settings override the defaults.<br>
Manage your __data models and theming logic__ using the MVC classes in the _public/application_ folder.<br>


### Basic configuration options

open `public/Configuration.php` to:

* Enable administration functions: set `const ADMIN_PASSWORD = "your passphrase";` then visit [/admin](http://localhost/index.php/admin) to login.
* Change your site title and motto.
* Set the default number of posts shown on the frontpage.
* Change common folder locations (Please submit issues if you find hardcoded locations).

### Getting started

* Create your first page: `/content/pages/index.md`. 
* Create your first post: Navigate to __Admin > Create post template__ to download a _post_ template and save it in `/content/posts/2012/09/first-post.md`. 
* Create a 404: `/content/errors/404.md`. Now non-existing links will point here. Error pages follow the _page_ data model.

### Turn off Pretty Urls

By default Carbon uses Apache's mod_rewrite and IIS'es URL rewrite to keep urls nice. You can disable this behaviour by opening `public/Configuration.php`: set `const INDEX_PAGE = '/index.php';`. This adds `/index.php` to all urls (eg: [/index.php/admin/new](http://localhost/index.php/admin/new) instead of [/admin/new](http://localhost/admin/new));


### Caching

To enable caching: open `public/Configuration.php` and set `const CACHE_ENABLED = true;`. Pages remain cached until its cache-file is deleted, manually or through __Admin > Clear Cache__. Caching is required if you want to generate a static site.


### Full static site generation

Navigate to __Admin > Generate static site__. The `cache` folder now contains a full static site. 

To deploy the static site, open a Powershell and run `.\carbon.ps1 deploy`. The script will ask for a keyword (for example: live), after which you can redeploy quickly by recalling the settings: in this case using `.\carbon.ps1 deploy live`. Currently the script only supports sftp connections. It requires [WinSCP](http://winscp.net/eng/download.php) and the *WinSCP .NET  Assembly / COM library*.


### Externals

Carbon will support third-party plugins (externals). Simply drop a [spl_autoload_register](http://www.php.net/manual/en/function.spl-autoload-register.php) compatible class into the `system/Ext` folder and call the class in the code. See the php manual page for more info on autoloading classes. Feel free to organise classes using custom folders.

Carbon will register any externals and autoload them. It comes with markdown and yaml support courtesy of [PHP Markdown Extra](http://michelf.ca/projects/php-markdown/) and [Spyc](https://github.com/mustangostang/spyc/).


### Images

Put the image in the _/content/images_ folder, and then call the `/images` controller:

![carbon logo](/images/carbon/logo.png)

Image is shown above.
