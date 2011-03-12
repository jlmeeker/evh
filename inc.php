<?
/*
    This file is part of Event Horizon (EVH).

    EVH is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    EVH is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// *** DO NOT EDIT THIS FILE!!!! ***
//   Any changes in this file will be lost on future upgrades.  Any of these
//   values which are specified in inc.php.local will override those below.


// Database credentials;
$dbhost = 'localhost';
$dbname = 'eventhorizon';
$dbuser = 'changeme';
$dbpass = 'changeme';

// Default file path.  This needs to be writable by the user apache runs as;
$fpath = '/var/www/uploads';

// get the http path directory name of the script as well as the server name;
$servername = 'changeme';
$serverpath = '/var/www/eventhorizon';

// graphic location;
$banner = '';

// Whether or not to show footer disclaimer;
$showdisclaimer = FALSE;

// FTP storage path (must be setup in the ftp daemon, owned by [apache user]:nobody and perms set to 2733;
// Also, the system account they use to FTP the files in as must have the default group equal to the apache server's group;
$ftppath = '/home/ftp/evhftp/';
$ftpuser = 'evhftp';
$ftppass = 'changeme';
$enableFTP = 0;

// Acceptible email domains (this is a case-insensitive regex);
$domains = "/yourdomain.com|anotherdomain.com/i";

include 'inc.php.local';  // Get any user-specific config changes;
include 'functions.php';  // Call in rest of functions;
?>