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

include "inc.php";
if (isset($fname)) $fname = stripslashes($fname);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - Modification Results</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?
$mod = '';
if (isset($del) and $del == 1 and !isset($confirm)) {
	echo '<script language="JavaScript">' . "\r\n";
	echo '<!--' . "\r\n";
	echo 'input_box=confirm("Do you really want to delete this file? \r\nClick OK or Cancel to Continue");' . "\r\n";
	echo 'if (input_box==true) {' . "\r\n";
	echo 'window.location = location.href+"&confirm=1";' . "\r\n";
	echo '}' . "\r\n";	
	echo 'if (input_box==false) {' . "\r\n";
	echo 'window.location = location.href+"&confirm=0";' . "\r\n";
	echo '}' . "\r\n";		
	echo '-->' . "\r\n";
	echo '</script>' . "\r\n";
	$dismsg = '';
}
elseif (isset($del) and $del == 1 and isset($confirm) and $confirm == 1) {
		$query = 'select id from Files where sessionid=' . $sessid;
		$res = mysql_query($query,$dbh) or die('<p><b>File was invalid, could not delete.</b>.\n<br />Query: ' . $query . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
		$row = mysql_fetch_row($res);
		$fileid = $row[0];
		
		insert_history_entry('delete', '', $fileid, $sessid); // Log deletion before file/session are deleted;
		
		$query = 'delete from Files where sessionid=' . $sessid;
		$res = mysql_query($query,$dbh) or die('<p><b>File was invalid, could not delete.</b>.\n<br />Query: ' . $query . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
		$query = 'delete from Sessions where id=' . $sessid;
		$res = mysql_query($query,$dbh) or die('<p><b>Session was invalid, could not delete.</b>.\n<br />Query: ' . $query . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
		remove_files($vercode);
		$dismsg = 'Session was deleted successfully.';	
		error_log($vercode . ': Removed via delete URL');	
		
}
elseif (isset($del) and $del == 1 and isset($confirm) and $confirm == 0) $dismsg = 'File deletion was cancelled.';
else {
	$DestinationEmail = clean_email_string($DestinationEmail);

	// update sql database;
	$query='update Files set description="' . $File1Description . '" where id=' . $fileid;
	$res = mysql_query($query,$dbh) or die('<p><b>Could not update file information.</b>.\n<br />Query: ' . $query . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	
	$query='update Sessions set outdate="' . ${date . $AvailabilityPeriod} . '", avail="' . $AvailabilityPeriod . '", destemail="' . $DestinationEmail . '" where id=' . $sessid;
	$res = mysql_query($query,$dbh) or die('<p><b>Could not update session information.</b>.\n<br />Query: ' . $query . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	
	$queryavail='select Availability.long from Availability where Availability.short="' . $AvailabilityPeriod . '"';
	$resavail = mysql_query($queryavail,$dbh) or die('<p><b>Could not retrieve availability.</b>.\n<br />Query: ' . $queryavail . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	$rowavail = mysql_fetch_row($resavail);
	$availlong = $rowavail[0];

	// get filesize in readable format (MB);
	$querysize = 'select size from Files where id=' . $fileid;
	$ressize = mysql_query($querysize,$dbh) or die('<p><b>Could not retrieve file size.</b>.\n<br />Query: ' . $querysize . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	$rowsize = mysql_fetch_row($ressize);
	$filesize = round($rowsize[0] / 1024 / 1024, 2);
	
	$mailheader = $utf8mailhdr . 'From: ' . $srcemail . "\r\n" . 'Reply-To: ' . $srcemail;
	
	$mailmsg = 'The following file has been modified.<br><br>';
	$mailmsg .= 'Filename: ' . $fname . '<br>Description: ' . $File1Description . '<br>';
	$mailmsg .= 'Size: ' . $filesize . ' MB<br>';
	$mailmsg .= 'Availability Period: ' . $availlong . '<br><br>';
	$mailmsg .= 'Download URL: <a href="http://' . $servername . '/sendfile.php?fid=' . $fileid . '&vercode=' . $dnldpass . '">http://' . $servername . '/sendfile.php?fid=' . $fileid . '&vercode=' . $dnldpass . '</a><br><br>';
	$mailmsg .= 'Verification Code: ' . $dnldpass;
	
	mb_send_mail("$DestinationEmail", 'File download at TNI was modified', $mailmsg, $mailheader) or die('Failed to send email.');
	$dismsg = 'Session was modified successfully.';
	
	insert_history_entry('modify', $browser, $fileid, $sessid);
}
?>
<?=$titleandmenu; ?>
<p align="center"><span class="content-text"><strong><?=$dismsg; ?></strong></span></p>
<?
if (isset($ba) and $ba == 1) {
	echo '<p align="center"><span class="content-text"><strong><a href=tnadmin/index.php>Back to admin page</a></strong></span></p>';
}

print $footer;
?>
</body>
</html>
