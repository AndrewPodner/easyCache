easyCache
=========
10-3-2012

v0.1

This is going to be a crack at a wrapper for adding caching to an application,
painlessly.  The idea behind this project is to be able to place a single
function call at the top and another single call at the bottom and create a
cached copy of the page.

It is fairly simple and nothing fancy.  I want to test it for a while and make
sure it is performing as intended before giving it a version 1.0 release.n  I
hope you find it useful.  Please report any problems on the project's GitHub
site: github.com/AndrewPodner/easyCache


NOTES:

There are 2 constants in the class to set configuration.  One is the life of
the cache file in seconds.  The other is the directory where cache files
will be located.

The script will work for any number of parameters in the query string.  It works
by hashing the script name with the query string.



INSTALLATION & USAGE:

1) Put the EasyCache class into an appropriate location in your application.

2) make sure you set the values of the Cache directory and lifetime constants in
    the class.  Don't forget to create the cache directory and give it permissions
    that allow files to be written to it.

3) If you have no autoloader, include the class at the top of the page you want
    to cache.

4) At the top of the page, call the EasyCache::initiateCacheCheck() static method
    to check for an existing cache file and load it if it is valid

5) At the bottom of the page, call the EasyCache::writeCacheFile() static method.
    If a cache file is loaded, this method will not be called.
