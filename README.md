# Thin PHP application framework

This is a very thin framework for PSR-15 PHP application using MVC.

Currently, it offers the following functionality only:
* Application shell
* View
* basic exception handling

It requires the following additional modules to work:
* PSR-7 request / response implementation
* PSR-17 factory implementation

Moreover, you are suggested to add various libraries to improve the development experience.
* Dependency injector
* Session handling
* Cookie handling

## Basic usage

In order to create a PHP application using the framework, you need to do the following:

1. 
    Subclass the provided `Application` class to handle your application logic for each entry point. The dependencies
    should be injected to the constructor of your concrete Application, and it receives a `ServerRequestInterface` and returns a `ResponseInterface`
    when run.
2. 
    Create views by writing templates and subclassing the provided abstract `View` (for non-template views),
    `Template` (for templates in any language) , `PhpTemplate` (for PHP templates) or `StaticTemplate` (for static templates) class.
    The view data for PHP templates should be declared as protected members in your concrete view, which is accessible in the
    template by `$this->member`. 
    
    Helper functions are provided for easy output escaping:
    * `html`
    * `xml`
    * `js`
    * `json`
    * `css`
    * `url`
    
    If you are providing JSON API only, you (obviously) don't need to write any views. 
    
3. 
    Create the entry point to start the application, which is accessible under the document root. The entry point should:
    1. `require` the composer autoloader.
    2. Set up error and exception handlers (optional).
    3. Create the `Application` and `ServerRequestInterface` objects.
    4. Run the application.
    5. Output the response.
    
Please refer to `miklcct/thin_php_app_demo` repository for how this framework works.

## Controller

In this framework, _application_ and _controller_ refer to the same thing - something that accepts a request and
returns a response.

Just implement your controller code in the provided `Application` class and you are good to go.

## Routing

No routing functionality is built-in ecause I don't want to make everything go through a single entry point.
This would make the entry controller bloated because all dependencies used in every route have to be injected into the
main controller. I don't want to make a container mandatory and injecting container is also a bad idea.

Instead, create a PHP file on each entry point of the application, subclass the provided `Application` class and do the
work specific to that route.

If you need to use SEO friendly URL, please use path info and web server rewrite. For example, if you want a specific
blog page accessible under `http://example.com/article/2018/01/24/hello-world`, please create `article.php` under your
document root, set up your web server to rewrite /article to /article.php

Alternatively, you can install a router as a middleware in the application.

## Middleware

It is very easy to install PSR-15 middlewares in the framework.

### Controller middleware

If you are using the provided `Application` class, just register it in `getMiddlewares()` method.
Remember to call `parent::getMiddlewares()` inside the overridden method to inherit the previous middlewares.

### Global middleware

It is also easy to install global middlewares. Just extend the provided `Application` class, register your global
middlewares, and implement your controllers on top of it.

### Installing middlewares on existing application

It is very easy to install middlewares on top of an existing PSR-15 application from another framework 
even if you don't use the provided `Application` class. `MiddlewareApplication` class is provided for such purpose.

## View

Views are defined as content with a content type. You need to implement `__toString()` (for string), `render()`
(for `StreamInterface`) and `getContentType()`. If you implement `__toString` you can use the provided `StringToStream`
trait to fill in `render()`, conversely, if you implement `render()` you can use the provided `StreamToString` to fill in
`__toString()`.

### Static and PHP templates

You can use the built-in `StaticTemplate` (for static page) or `PhpTemplate` (for PHP templates). Just
implement `getPathToTemplate()` method.

### Other template languages

You need to install the template engine (e.g. Smarty, Twig, etc.), extend the provided `Template` class
and implement `render()` and `__toString()` methods to call the template engine.

### View data

PHP templates are run in the context of your View object. You are recommend to access view data using `protected`
fields and members (`private` will not work because it is rendered in a base class method). and add a docblock
`/* @var YourConcreteView $this */` near the beginning of your PHP templates such that IDE analysis will work.

Other template engines may have their own method to pass data into templates. You are recommended to declare exactly
what data is expected in the view constructor, or use a factory object to produce views with correct data.

## Error and Exception

There are two helper classes provided: `ExceptionErrorHandler` which will convert PHP error into `ErrorException`
depending on your `error_reporting` setting, and `ResponseFactoryExceptionHandler` which will output responses from a
factory when an exception is uncaught. Objects of these classes can be passed directly to `set_error_handler()`
and `set_exception_handler()` respectively.

You can also register a middleware to handle exceptions from your application.

## Code style and structure

All library codes are organised into the appropriate subfolder under `src` folder, and properly namespaced using PSR-4, even including constants and functions.

You **MUST** adhere to the following rules when making pull requests:
* Follow the existing code style for existing files, but feel free to use any style for new files.
* Place all code into a subfolder under `src` folder and namespace them. No global code, including global constants and functions are allowed.
* All PHP code **MUST** have strict type checking (`declare(strict_types = 1);`) enabled.
* No `eval` is allowed. This prohibition includes functions with `eval`-behaviour e.g. `preg_replace()` with `e` modifier, `create_function()` and the backtick operator.
* No `goto` is allowed.
* No undeclared properties or methods are allowed. This prohibition includes the use of magic, i.e. the following magic methods are not allowed:
    * `__call()`
    * `__callStatic()`
    * `__get()`
    * `__set()`
    * `__isset()`
    * `__unset()`

    The use of undeclared fields in `stdClass` object to represent a generic data object is allowed as an exception.
* Use of a string for indirect variable, property and method access is not allowed. For example, the use of following syntaxes are not allowed, where `$foo` is a string:
    * `$$foo` (indirect variable)
    * `$object->$foo` (indirect property)
    * `$object->$foo()` (indirect method)
    
    However, the use of a string for indirect *function* call is allowed, provided that the string comes from an expression declared, annotated or deduced as a `callable`, for example:
    
    ````
    function test(string $foo, callable $bar) {
        $foo(); // not allowed
        $bar(); // allowed
    }
    ````
    
    Only proven callables are allowed to be used in `callable` expression, which include:
    * anonymous functions
    * string literal (representing a free standing function or static class method)
    * array containing an object and a string literal (representing a method inside an object)
    * objects with `__invoke()` method
        
* Alternative control syntax is only allowed in `.phtml` templates and not allowed in regular `.php` files containing application logic.

If existing code are found to violate the above rules, please open a bug report.
