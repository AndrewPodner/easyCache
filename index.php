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

 *
 */
include 'EasyCache.php';
//check for existing cachefile, if one exists, load it
UnassumingPHP\EasyCache::initiateCacheCheck();



/***SAMPLE PAGE CONTENT***/
foreach ($_SERVER as $key => $value) {
    echo $key . ': ' . $value . "<br />";
}
/***END SAMPLE PAGE CONTENT***/


//finally, write a new cache file
UnassumingPHP\EasyCache::writeCacheFile();
?>
