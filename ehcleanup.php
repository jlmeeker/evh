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

error_reporting(0);
include "inc.php";

$query='select id, dnldcode, outdate from Sessions where outdate < "' . $mydate . '"';
$res = mysql_query($query,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());

while ($row = mysql_fetch_row($res)) {
		echo "\r\n";
		$query4 = 'select name,id from Files where sessionid="' . $row[0] . '"';
		$res4 = mysql_query($query4,$dbh) or die('Query: ' . $query4 . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
		$row4 = mysql_fetch_row($res4);
		
		if ($savehistory) {
			// record file deletion into History table;
			insert_history_entry('expired', $row4[1], $row[0]);
		}		
		
		echo 'Removing data from Files table for dnldcode: ' . $row[1] . "\r\n";
		$query2 = 'delete from Files where sessionid=' . $row[0];
		$res2 = mysql_query($query2,$dbh) or die('<p><b>File was invalid, could not delete.</b>.\n<br />Query: ' . $query2 . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());

		echo 'Removing data from Sessions table for dnldcode: ' . $row[1] . "\r\n";
		$query3 = 'delete from Sessions where id=' . $row[0];
		$res3 = mysql_query($query3,$dbh) or die('<p><b>Session was invalid, could not delete.</b>.\n<br />Query: ' . $query3 . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());

		echo 'Removing file ' . $row4[0] . ' for dnldcode: ' . $row[1] . "\r\n";
		remove_files($row[1]);
		error_log($row[1] . ": Removed via scheduled cron job");
}

error_log("Cleaning up FTP area: " . $ftppath);
$dirlisting = scandir($ftppath);

foreach ($dirlisting as $key => $value) {
    if (is_dir($ftppath . $value) && $value != '.' && $value != '..') {
		
		$oldtime = time() - (60 * 60 * 24); // now minus 24 hours (in seconds);
		$dirinfo = stat($ftppath . $value); // Get info. on directory
		
		$numfiles = count(scandir($ftppath . $value));
		
		if ($numfiles == 2) { // Delete if directory is empty;
			error_log($value . ': Removing empty directory');
			rmdir($ftppath . $value);
		}
		elseif ($dirinfo[9] < $oldtime) { // If older than 24 hours and no valid session entry exists, delete it;
			$newquery = "select dnldcode from Sessions where dnldcode='$value'";
			$newres = mysql_query($newquery,$dbh);
			$newcount = mysql_num_rows($newres);
			
			if ($newcount == 0) {
				error_log($value . ': Removing based on exipration');
				remove_files($value);
			}
		}
	}
	else {
		// error_log("Non-dir found: " . $value);
	}
}

?>
