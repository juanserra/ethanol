Ethanol
=======

Will be a super duper awesome auth package for FuelPHP

License
=======

This package is released under the Don't Be A Dick (DbaD) license.

More information and translations:
http://philsturgeon.co.uk/code/dbad-license DbaD

Examples
========

Please take a look at https://github.com/stevewest/ethanol-spirit for a basic
implementation of Ethanol's features.

Installation
============

Ethanol requires Fuel core and orm 1.5/develop or better.

Simply copy the package to your packages folder and add the following to your
app config file to ensure Ethanol is loaded.

```php
    'always_load' => array(
            'packages' => array(
                    'ethanol',
            ),
    ),
```

You then want to run the the migrations to create the needed database tables.

If you wish to use email activation on accounts then you must also ensure the
email package is set up correctly.

Usage
=====

All of Ethanol's features can be accessed through the core `\Ethanol\Ethanol`
class. For now please check out the sample repo above for more information.
