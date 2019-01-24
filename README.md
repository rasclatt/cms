# nUberSoft-Framework
nUberSoft is a small in-the-works CMS framework for PHP. It is a mix of old and new due to it's long development timeframe. Documentation is not as robust as it should be. The majority of this framework will work for non-Linux-based systems, but it is not tested and some security (.htaccess) are not read by Win servers.

The functions, classes, and namespaces are all fairly self-explanitory and usually are easy to follow along. The workings of the application can be automated using an xml file. This is the default for this application.

It requires the `rasclatt/nubersoft` repository to function. You can download this rep directly and place the contents of the `src` folder into:

`{directory_root}/vendor/Nubersoft/{classes_here}`

You can also install from composer:

`create-project rasclatt/cms {directory_root}`

## Install Manually CMS & Nubersoft Class Library

All you need do is extract this repository into your root folder and follow the instructions on the (nubersoft)[https://github.com/rasclatt/nubersoft] repository install that library into a `vendor` folder. The `vendor`folder is required for the Nubersoft library to properly resolve namespacing in the autoloader.
