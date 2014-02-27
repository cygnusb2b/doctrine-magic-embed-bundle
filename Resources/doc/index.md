DoctrineMagicEmbedBundle
===================

Introduction
------------
DoctrineMagicEmbedBundle allows you to embed 'first-class' managed documents into other managed documents
by defining a subset of fields to use, and how you want your documents to behave.

Installation
------------
You can install this bundle using composer

.. code-block :: bash

    composer require cygnus/doctrine-magic-embed-bundle

or add the package to your ``composer.json`` file directly.

After you have installed the package, you just need to add the bundle to your ``AppKernel.php`` file::

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Cygnus\DoctrineMagicEmbed\CygnusDoctrineMagicEmbedBundle(),
        // ...
    );

Configuration
-------------
DoctrineMagicEmbedBundle requires no initial configuration.

For all available configuration options, please see the :doc:`configuration documentation <configuration>`.

Usage
-----
To utilize the MagicEmbed service, you need to make two changes to your documents:

1. Enable MagicEmbed on the document you want to embed (or one of its ancestors).
2. Define the fields that should be embedded on parent documents.

```php
<?php
    
namespace Acme\Document;

use Cygnus\DoctrineMagicEmbedBundle\Mapping\Annotations as MagicEmbed;

class Taxonomy {

    /**
     * @MagicEmbed\Expose
     */
    protected $name;

    protected $id;

    // ...

    }

```
    
Now, when you embed this Taxonomy document into another managed document, the 'name'
field will be persisted as an embedded document.

For more details, check out the :doc:`configuration <configuration>` 
and :doc:`examples <examples>` documentation.
