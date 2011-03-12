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

include "../inc.php";

$queryfiles = "select id, sessionid, name from Files where 1;";
$resfiles = mysql_query($queryfiles,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $queryfiles . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>

<?
if (!isset($confirm) and $confirm != 1) { ?>
	<script language="JavaScript">
	<!--
	input_box=confirm("Do you really want to delpurge ALL files? \r\nClick OK or Cancel to Continue");
	if (input_box==false) {
		alert ("File deletion cancelled.")
	}
	if (input_box==true) {
		window.location = location.href+"?confirm=1";
	}
	if (input_box==false) {
		window.location = location.href+"?confirm=0";
	}
	-->
	</script>
<?
}
elseif (isset($confirm) and $confirm == 1) {
	error_log("File purge initiated.");
	$query = "select id,dnldcode from Sessions where 1";
	$res = mysql_query($query,$dbh) or die("<p><b>Could not retrieve session list.</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
	
	while ($row = mysql_fetch_row($res)) {
		error_log($row[1] . ': Purging files');
		$query2 = "select id from Files where sessionid=$row[0]";
		$res2 = mysql_query($query2,$dbh) or die("<p><b>File was invalid, could not delete.... Purge cancelled.</b>.\n<br />Query: " . $query2 . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
		$filerow = mysql_fetch_row($res2);

		if ($savehistory) {
			// record file modification/deletion into History table;
			insert_history_entry('purge', $filerow[0], $row[0]);
		}		

		$query2 = "delete from Files where sessionid=$row[0]";
		$res2 = mysql_query($query2,$dbh) or die("<p><b>File was invalid, could not delete.... Purge cancelled.</b>.\n<br />Query: " . $query2 . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
		$query2 = "delete from Sessions where id=$row[0];";
		$res2 = mysql_query($query2,$dbh) or die("<p><b>Session was invalid, could not delete.... Purge cancelled.</b>.\n<br />Query: " . $query2 . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
		remove_files("$row[1]");
	}
	echo '<div align=center class="content-text">Purge Completed</div>';
}
else {
	echo '<div align=center class="content-text">Purge Cancelled</div>';
}
?>
<p align="center"><span class="content-text"><strong><a href=index.php>Back to admin page</a></strong></span></p>
<?
print $footer;
?>
</body>
</html>

