<?php
/**
 *  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Copyright (C) 2012  Andrew Podner

  PSR2
 *
 */
namespace UnassumingPHP;

class EasyCache
{
    /**
     * @name: CACHE_DIR <string>
     * @descr: directory for the cache files.  set this to the directory
     *         as it relates to the $_SERVER['DOCUMENT_ROOT'] value
     *
     */
    const CACHE_DIR = 'cache';

    /**
     * @name: CACHE_LIFE_SECONDS <integer>
     * @descr: Lifetime in seconds for the cache file 3600 seconds (1 hour)
     *         is preset as the default
     *
     */
    const CACHE_LIFE_SECONDS = 3600;

    /**
     * @name: initiateCacheCheck
     *  @descr:
     *      checks for a valid cache file and loads it if there is one.  If there
     *      is not a valid cache file available, an expired cache will be deleted
     *      and the output buffer will be started.
     */
    public static function initiateCacheCheck()
    {
        $scriptName = $_SERVER['REQUEST_URI'];
        $fileHash = self::hashScriptName($scriptName);
        $fileName = self::createFileName($fileHash);
        $exists = self::checkForExistingCache($fileName);
        if ($exists == true) {
            readfile($fileName);
            exit();
        } else {
            ob_start();
        }

    }

    /**
     * @name: checkForExistingCache
     * @params: fileName <string> / expects the cache file name (hashed with
     *                                full path from document root)
     * @returns: boolean
     * @descr: checks the cache directory for an unexpired cache file.  if the
     *          file exists and is not expired, the function returns true.  If
     *          file exists but is expired, function deletes the expired file and
     *          then returns false.  If no file exists, the function returns
     *          false.
     */
    private static function checkForExistingCache($fileHash)
    {
        if (file_exists($fileHash) == true) {
            $cacheMaxAge = filemtime($fileHash) + (self::CACHE_LIFE_SECONDS);
            if ($cacheMaxAge >= time()) {
                return true;
            } else {
                unlink($fileHash);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @name: createFileName
     * @params: fileName <string> / expects an md5 hash of the filename
     * @returns: <string> : full path file name
     * @descr: creates a file location string from the hashed script name
     *
     */
    private static function createFileName($fileHash)
    {
        return self::CACHE_DIR . DIRECTORY_SEPARATOR . "$fileHash.html";
    }

    /**
     * @name: hashScriptName
     * @params: scriptName <string> / expects the script name with any applicable
     *                                query string
     * @returns: md5 hash
     * @descr: Uses md5 as the default method, but you can use any hash method by
     *          just modifying this function to your liking
     */
    private static function hashScriptName($scriptName)
    {
        return md5($scriptName);
    }

    /**
     * Write the cache file, also you can put exceptions for file types that
     * should not be cached.
     * @name: writeCacheFile
     * @returns: nothing
     * @descr: creates a cached copy of the file
     */
    public static function writeCacheFile()
    {
        $scriptName = $_SERVER['REQUEST_URI'];
        $ext = end(explode('.', $scriptName));
        $exceptions = array('js', 'css', 'ico');

        if(!in_array($ext, $exceptions)) {
            $fileHash = self::hashScriptName($scriptName);
            $target = self::createFileName($fileHash);
            $fhandle = fopen($target, 'w+');
            $write = fwrite($fhandle, ob_get_contents());
            fclose($fhandle);
            ob_get_flush();
        }
    }
}
