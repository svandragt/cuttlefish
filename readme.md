# Cuttlefish
Cuttlefish simplifies creating and deploying PHP websites.

_It should be considered work in progress._

## Philosophy

* Short learning curve, basic PHP and markdown knowledge is required.
* Accommodating defaults.
* Adaptable to your needs.

## Goals

- [ ] Web authors: Deploy a Cuttlefish site simply by uploading files.

## Installation

### Web authors

- Setup: extract a release zip file
- Use: Add content to site/content
- Deploy: upload the contents of the site/ folder

### Developers

Prerequisites:
- Node 14 LTS - I recommend installing node using [Volta](https://volta.sh/) <br> NPM is used to install husky pre-commit hooks.
- PHP 7.4 - I recommend installing PHP using [HomeBrew](https://formulae.brew.sh/formula/php@7.4) <br> So you can run the project locally.
- Composer 2 - [Website](https://getcomposer.org/)
- DirEnv (optionally) - Recommended if you have other projects with different requirements - [HomeBrew](https://formulae.brew.sh/formula/direnv#default) <br> so the right PHP and Composer version are used.

Setup:
```
git clone
composer setup
composer serve
```

## Next step

[Installation, configuration, and content management](https://github.com/svandragt/cuttlefish/wiki)
instructions are found on the wiki.

[Contributions are welcomed](https://github.com/svandragt/cuttlefish/issues). 

## Deployment story
