# Thin PHP application framework

This is a very thin framework for PSR-15 PHP application using MVC.

Currently, it offers the following functionality only:
* Application shell
* View
* basic exception handling

It requires the following additional modules to work:
* PSR-7 request / response implementation
* PSR-17 factory implementation

Moreover, you are suggested to add various libraries to improve the development experience
* Dependency injector
* Session handling
* Cookie handling

In order to create a PHP application using the framework, you need to do the following:
1. Subclass the provided `Application` class to handle your application logic for each entry point. The dependencies
should be injected to the constructor of your concrete Application, and it receives a `ServerRequestInterface` and returns a `ResponseInterface`
when run.
2. Create views by writing templates and subclassing the provided abstract `View` (for non-template views),
`Template` (for templates in any language) or `PhpTemplate` (for PHP templates) class.
The view data for PHP templates should be declared as protected members in your concrete view, which is accessible in the
template by `$this->parameter`. Helper functions are provided for easy output escaping.
3. Create the entry point to start the application, which is accessible under the document root. The entry point should:
    1. `require` the composer autoloader.
    2. Set up error and exception handlers (optional).
    3. Create the `Application` and `ServerRequestInterface` objects.
    4. Run the application.
    5. Output the response.

No routing functionality is provided because I don't want to make everything go through a single entry point.
This would make the main controller bloated because all dependencies used in every route have to be injected into the
main controller.

Instead, create a PHP file on each entry point of the application, subclass the provided `Application` class and do the
work specific to that route.

If you need to use SEO friendly URL, please use path info and web server rewrite. For example, if you want a specific
blog page accessible under `http://example.com/article/2018/01/24/hello-world`, please create `article.php` under your
document root, set up your web server to rewrite /article to /article.php

Alternatively, you can install a router as a middleware in the application.

Please refer to `miklcct/thin_php_app_demo` repository for how this framework works.