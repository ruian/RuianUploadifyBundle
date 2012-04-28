=============================
UploadifyBundle Documentation
=============================

1. Uploadify_.
    a. `downdload uploadify`_.
    b. `install uploadify`_.
2. `UploadifyBundle`_.
    a. `install with composer`_.
    b. `register`_.
3. `Use`_.
    a. `Form`_.
    b. `Controller`_.
    c. `View`_.
4. `Customise`_.
    a. `Javascript`_.
    b. `Uploader Firewall`_.
5. `Todo`_.

.. _Uploadify:

============
1. Uploadify
============

.. _downdload uploadify:

----------------------
a. downdload uploadify
----------------------

    Download latest version of uploadify from http://www.uploadify.com/download/

.. _install uploadify:

--------------------
b. install uploadify
--------------------

    extract it into your folder like `web`

    or put

    `uploadify.css` into `web/css` folder
    
    `jquery.uploadify-3.1.min.js` into `web/js` folder
    
    `uploadify.swf` into `web/swf` folder
    
    `uploadify-cancel.png` into `web/img` folder

.. _UploadifyBundle:

==================
2. UploadifyBundle
==================

.. _install with composer:

------------------------
a. install with composer
------------------------

    inside your composer.json

::

    {
        "name": "symfony/framework-standard-edition",
        "description": "The \"Symfony Standard Edition\" distribution",
        "autoload": {
            "psr-0": { "": "src/" }
        },
        "require": {
            "php": ">=5.3.2",
            "symfony/symfony": "2.1.*",
            "doctrine/orm": "2.2.0",
            "doctrine/doctrine-bundle": "dev-master",
            "twig/extensions": "dev-master",
            "symfony/assetic-bundle": "dev-master",
            "symfony/swiftmailer-bundle": "dev-master",
            "symfony/monolog-bundle": "dev-master",
            "sensio/distribution-bundle": "dev-master",
            "sensio/framework-extra-bundle": "dev-master",
            "sensio/generator-bundle": "dev-master",
            "jms/security-extra-bundle": "1.1.0",
            "jms/di-extra-bundle": "1.0.1",
            "ruian/uploadifybundle": "dev-master"
        },
        "scripts": {
            "post-install-cmd": [
                "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
                "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
                "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets"
            ],
            "post-update-cmd": [
                "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
                "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
                "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets"
            ]
        },
        "config": {
            "bin-dir": "bin"
        },
        "extra": {
            "symfony-app-dir": "app",
            "symfony-web-dir": "web"
        }
    }

Next step is to install your new require, to do that run this command:

if you have already composer.phar inside your folder

`php composer.phar install`

else, 

`curl -s http://getcomposer.org/installer | php ; php composer.phar install`

.. _register:

-----------
b. register
-----------

inside your `app/AppKernel.php` add this line

::

    <?php

    use Symfony\Component\HttpKernel\Kernel;
    use Symfony\Component\Config\Loader\LoaderInterface;

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // previous namespaces register
                new Ruian\UploadifyBundle\RuianUploadifyBundle(),
            );

            // some code
            
            return $bundles;
        }

        // some code
    }

inside your `app/config/routing.yml` add these lines

::

    ruian_uploadify:
        resource: "@RuianUploadifyBundle/Resources/config/routing.yml"

.. _Use:

======
3. Use
======

.. _Form:

-------
a. Form
-------

because uploadifybundle is build on top of FormTypeExtensionInterface you just have to enable uploadify from your `text` or `hidden` type;

Example :

::

    $builder
    ->add('picture', 'text', array('uploadify_enabled' => true))
    ;

or

::

    $builder
    ->add('picture', 'hidden', array('uploadify_enabled' => true))
    ;

After uploadify is enable for your type, you can choose any options from uploadify doc.

::

    $builder
    ->add('picture', 'hidden', array(
        'uploadify_enabled' => true
        'uploadify'         => array(
            'auto'       => true,
            'buttonText' => 'Launch upload',
            // more options here http://www.uploadify.com/documentation/
        )
    ))
    ;

.. _Controller:

-------------
b. Controller
-------------

To upload your file you can use the default Controller/Action who will return the filename if 
your file was successfull uploaded. Default route is `uploadify_upload`.


or you can make your own.

.. _View:

-------
c. View
-------

::

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <title>UploadifyBundle</title>
            <link rel="icon" sizes="16x16" href="{{ asset('favicon.ico') }}" />
            <link rel="stylesheet" href="{{ asset('uploadify/uploadify.css') }}" />
            <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
            <script type="text/javascript" src="{{ asset('uploadify/jquery.uploadify-3.1.js') }}"></script>
        </head>
        <body>
            <form action="" method="post" enctype="multi-data">
                {# use the uploadify template or make your own #}
                {% form_theme form 'RuianUploadifyBundle:Form:fields.html.twig' %}

                {{ form_widget(form) }}
                <input type="submit" value="save" />
            </form>
        </body>
    </html>

.. _Customise:

============
4. Customise
============

.. _Javascript:

-------------
a. Javascript
-------------

you can add every uploadify settings from your javascript, you have to get the uploadify instance:

::

    $("#uploadify-XXX").uploadify('settings', 'event', 'closure');

XXX is for your input file/hidden id.

more documentation here http://www.uploadify.com/documentation/uploadify/settings/

.. _Uploader Firewall:

--------------------
b. Uploader/Firewall
--------------------

UploadifyBundle give you the possibility to upload file from Controller/Action who are behind the firewall.

Your session_id is encrypt and send with the new Request.

.. _Todo:

=======
5. Todo
=======

Make multi upload easier
