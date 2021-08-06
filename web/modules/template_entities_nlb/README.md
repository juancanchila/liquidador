CONTENTS OF THIS FILE
---------------------

 * Overview
 * Requirements
 * Installation
 * Usage
 * Maintainers


OVERVIEW
--------

This is an add-on module to [Template Entities](https://www.drupal.org/project/template_entities) to support use of the Node Layout Builder when creating new content from templates. Node Layout Builder layouts attached to template nodes will be copied as new layouts when creating new nodes from templates.


REQUIREMENTS
------------

This module requires [Template Entities](https://www.drupal.org/project/template_entities) and [Node Layout Builder](https://www.drupal.org/project/node_layout_builder).


INSTALLATION
------------

Install the Template Entities Node Layout Builder module as you would normally install a contributed
Drupal module. Visit https://www.drupal.org/node/1897420 for further
information.

USAGE
-----

Using an example:

1. Create a content type called "Landing pages" configured to use Node Layout Builder.
2. Create a template type selecting "Content with Node Layout Builder" for the "Entity type/plugin" option and checking "Landing pages" for the bundle option.
3. Create a landing page using the node layout builder to build the page.
4. Create a template, using the landing page created above as the source entity.
5. Create a new landing page from the template created in step 4.

MAINTAINERS
-----------

 * Andy Chapman - https://www.drupal.org/u/chaps2

Supporting organization:

 * Locologic Limited - https://www.locologic.co.uk
