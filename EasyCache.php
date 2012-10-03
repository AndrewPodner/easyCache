<?php
/*
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
    /* @name: cacheDir <string>
     * @descr: directory for the cache files.  set this to the directory
     *         as it relates to the $_SERVER['DOCUMENT_ROOT'] value
     *
     */
    private $cacheDir = 'cache';

    /* @name: cacheLifeSeconds <integer>
     * @descr: Lifetime in seconds for the cache file 3600 seconds (1 hour)
     *         is preset as the default
     *
     */
    private $cacheLifeSeconds = 3600;

    /* @name: cacheMaxAge <integer>
     * @descr: the maximum value, expressed as a UNIX Timestamp that a file
     *         could be created at and still be a valid cache file
     */
    private $cacheMaxAge;


    public function __construct()
    {
        $this->cacheMaxAge = time() - $this->cacheLifeSeconds;
    }

    /* @name: checkForExistingCache
     * @params: fileName <string> / expects the cache file name (hashed with
     *                                full path from document root)
     * @returns: boolean
     * @descr: checks the cache directory for an unexpired cache file.  if the
     *          file exists and is not expired, the function returns true.  If
     *          file exists but is expired, function deletes the expired file and
     *          then returns false.  If no file exists, the function returns
     *          false.
     */
    private function checkForExistingCache($fileName)
    {
        if (file_exists($fileName) == true) {
            if (filemtime($fileName) >= $this->cacheMaxAge) {
                return true;
            } else {
                unlink($fileName);
                return false;
            }
        } else {
            return false;
        }
    }

    /* @name: createFileName
     * @params: fileName <string> / expects an md5 hash of the filename
     * @returns: <string> : full path file name
     * @descr: creates a file location string from the hashed script name
     *
     */
    private function createFileName($fileHash)
    {
        return $_SERVER['DOCUMENT_ROOT']."/".$this->cacheDir."/$fileHash.php";

    }

    /* @name: hashScriptName
     * @params: scriptName <string> / expects the script name with any applicable
     *                                query string
     * @returns: md5 hash
     * @descr: Uses md5 as the default method, but you can use any hash method by
     *          just modifying this function to your liking
     */
    private function hashScriptName($scriptName)
    {
        return md5($scriptName);
    }
}
