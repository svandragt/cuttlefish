# Carbon
Carbon is a hackable performant static blogging system. 

_It should be considered early alpha._

A [screenshot of the default theme](http://i.imm.io/FV6p.png):
![Screenshot of the defaul theme](http://i.imm.io/FV6p.png)


## Aims

* Easy to learn
* Easy to hack & extend
* Performant


## Installation

Carbon requires PHP 5.3+ and has only been tested so far on IIS 6.1 / Windows. It probably works fine under Apache / Linux.

1. Check out this repository and point your webserver to the public folder.
2. Open Configuration.php and override any constants from Defaults.php.
3. Open the site in your browser. A `cache` and `logs` folder outside `public` will be created, as well as a `public/content` folder sub subfolders.


## How to use

* Create your first page: `/content/pages/index.md`. In the _basic_ theme, pages are linked from the footer.
* Create your first post: `/content/posts/2012/09/first-post.md`. Posts are listed in the index page.
* Create a 404: `/content/error/404.md`. Now non-existing links will point here.

## Externals

Carbon will support third-party plugins (externals). Simply drop a [PHP autoloader](http://php.net/manual/en/language.oop5.autoload.php) compatible class into the `system/Ext` folder and call the class in the code. See the php manual page for more info on autoloading classes. Feel free to organise classes using folders, with no naming requirements.

Carbon will register any externals and autoload them.


### Markdown

Carbon is tested with [PHP Markdown Extra](http://michelf.ca/projects/php-markdown/) as an external. To install:

1. Unzip the archive in `system/Ext`.
2. Rename the php file so that you have a `system/Ext/Markdownextra/MarkdownExtra_Parser.php`. (PHP autoloading requires class-name equals file-name). 
