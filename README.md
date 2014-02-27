Doctrine Magic Embed
====================

This bundle supports embedding a version of a first-class managed document in Doctrine documents.

[![Build Status](https://travis-ci.org/cygnusb2b/doctrine-magic-embed-bundle.png?branch=master)](https://travis-ci.org/cygnusb2b/doctrine-magic-embed-bundle)

---

### The Problem

In Doctrine, managed documents cannot be easily embedded within other documents. In a blogging scenario, it would be useful to embed the post author on each Post document, both to prevent unnecessary database lookups and to easily access methods or properties of the author, once hydrated.

In Doctrine, you would need to either reference the Author document (causing a DB query), or embed an EmbeddedDocument version of the Author document (to which changes would not be persisted.) You may also want to specify what fields of the embedded document are actually embedded, which is not currently supported.

---

### The Solution

This bundle attempts to remedy that problem by providing three things:

1. An annotation driver to define which fields should be used when embedding a document.
2. A service that hooks into Doctrine's hydration and persistance events to transform the passed document into a true embedded document based on the fields you have defined with the annotation driver.
3. Finally, a service that hooks into Doctrine's persistance functionality to cascade changes from managed documents to transformed embedded documents.

---

### Status

This bundle is currently under active development, and no stable release is yet available. If you're interested in learning more or contributing, feel free to check out the [documentation](Resources/doc/index.md) or the [wiki](https://github.com/cygnusb2b/doctrine-magic-embed-bundle/wiki).
