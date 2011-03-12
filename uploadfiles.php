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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - Upload Results</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?
	// Verify email addresses contain required domains;
	$YourEmail = addslashes(clean_email_string($YourEmail));
	$DestinationEmail = addslashes(clean_email_string($DestinationEmail));
	$email_array = explode(",", $YourEmail . "," . $DestinationEmail);
	if (! preg_array($domains,$email_array)) {
		$dismsg = '<font color=red>ERROR 1006: An error has occurred.  Please contact the Help Desk for assistance.</font>';
		error_log('File upload filed, email addresses were incorrect.');
	}
	else {
		if (isset($dirname)) {
			$dnldpass = addslashes($dirname);
			$filesrc = $fullfile;
			$filename = utf8_encode(addslashes($File1));
			$method = 'ftp';
		}
		else {
			// Generate a download code
			$dnldpass = addslashes(substr(md5(uniqid(rand(),1)),0,8));
			$filesrc = $_FILES['File1']['tmp_name'];
			$filename = utf8_encode(addslashes(basename($_FILES['File1']['name'])));
			$filesize = $_FILES['File1']['size'];
			$method = 'http';
		}
		
		// Test for failed HTTP upload;
		if (!isset($dirname) && $_FILES['File1']['error'] != 0) error_log(stripslashes($dnldpass) . ": Upload error (" . $UPLOADERRORS[$_FILES['File1']['error']] . ")");

		// If transferred via HTTP or if the file is less than 2GB (2000000000 bytes), move the file;		
		$ok=0;
		if ($method == 'http' || $filesize < 1900000000) {
			$uploadfile = $fpath . '/' . stripslashes($dnldpass) . '/' . $filename;
			$tmp = mkdir("$fpath/$dnldpass");
			
			error_log($dnldpass . ": Moving $filesrc to $uploadfile");
			
			if ($method == 'http' && move_uploaded_file($filesrc, $uploadfile)) $ok=1;
			elseif ($method == 'ftp' && rename($filesrc,$uploadfile)) {  // Move file and remove ftp directory;
				$ok=1;
				rmdir($ftppath . stripslashes($dnldpass));
			}
			else {
				$dismsg = '<font color=red>An error occurred with your file upload.  Please try again.</font>';
				if ($method == 'http') $dismsg .= '<p>Upload error: (' . $UPLOADERRORS[$_FILES['File1']['error']] . ')';
				$ok = 0;
			}
			$method = 'http';  // Force this to HTTP before database insert so the download URL is correct;
		}
		elseif ($method == 'ftp') {   // What to do if method was ftp and file larger than 2gb;
			// Leave file where it is;
			$ok = 1;
		}
		
		// Generate the modification code;
		$modpass = addslashes(substr(md5(uniqid(rand(),1)),0,8));
		
		if ($ok == 1) {
			error_log(stripslashes($dnldpass) . ": Successfully uploaded file:" . $filename);
			
			// insert data into sql database;
			$query = 'insert into Sessions (indate, outdate, avail, srcemail, destemail, dnldcode, modcode) values ("' . $mydate . '", "' . ${'date' . $AvailabilityPeriod} . '", "' . $AvailabilityPeriod . '", "' . $YourEmail . '", "' . $DestinationEmail . '", "' . $dnldpass . '", "' . $modpass . '")';
			$res = mysql_query($query,$dbh) or die('<p><b>A fatal database error occured</b>.\n<br />Query: ' . $query . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	
			// get the session id the sql database just created;
			$sessid = mysql_insert_id();
			$query2 = 'insert into Files (name, description, method, sessionid, size) values ("' . $filename. '", "' . utf8_encode(addslashes($File1Description)) . '","' . $method . '", ' . $sessid . ', ' . $filesize . ');';
			$res2 = mysql_query($query2,$dbh) or die('<p><b>A fatal database error occured</b>.\n<br />Query: ' . $query2 . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	
			// get the availability period (nice looking one);
			$query3="select * from Availability where short=\"$AvailabilityPeriod\"";
			$res3 = mysql_query($query3,$dbh) or die('<p><b>A fatal database error occured</b>.\n<br />Query: ' . $query3 . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
			$row3 = mysql_fetch_row($res3);
			$availability = $row3[2];
	
			// get the file id the sql database just created;
			$fileid = mysql_insert_id();
			
			if ($savehistory) {
				// record file upload into History table;
				insert_history_entry('upload', $fileid, $sessid);
			}

			$dstheader = $utf8mailhdr . 'From: ' . stripslashes($YourEmail) . "\r\n";
			$dstheader .= 'Reply-To: ' . stripslashes($YourEmail);
			$dstmsg  = 'A file has been made available for you to download.<br><br>';
			$dstmsg .= 'Filename: ' . utf8_encode($filename) . '<br>';
			$dstmsg .= 'Size: ' . round($filesize / 1024 / 1024, 2) . ' MB<br>';
			$dstmsg .= 'Availability: ' . $availability . '<br>';
			$dstmsg .= 'Description: ' . utf8_encode($File1Description) . '<br>';
			$dstmsg .= 'Download Code: ' . stripslashes($dnldpass) . '<br><br>';
			
			$dstmsg .= '<a href="' . $proto . '://' . $servername . '/sendfile.php?fid=' . $fileid . '&vercode=' . stripslashes($dnldpass) . '">Click here to download the file</a><p>';
			$dstmsg .= 'If the download link above doesn\'t work for you, use the download code above on the <a href="' . $proto . '://' . $servername . '/download.php">' . $appname . ' download page</a>.';
			
			mail(stripslashes($DestinationEmail), utf8_encode($filename) . ' ready for download at ' . $companyname, $dstmsg, $dstheader) or die("Could not send receiver email.");
			
			$srcheader = $utf8mailhdr . 'From: ' . $ehmailaddr . "\r\n";
			$srcheader .= 'Reply-To: ' . $ehmailaddr;
			$srcmsg  = 'The file you uploaded is ready for download.<br><br>';
			$srcmsg .= 'Filename: ' . utf8_encode($filename) . '<br>';
			$srcmsg .= 'Size: ' . round($filesize / 1024 / 1024, 2) . ' MB<br>';
			$srcmsg .= 'Availability: ' . $availability . '<br>';
			$srcmsg .= 'Description: ' . utf8_encode($File1Description) . '<br>';
			$srcmsg .= 'Download Code: ' . stripslashes($dnldpass) . '<br>';
			$srcmsg .= 'Modification Code: ' . stripslashes($modpass) . '<br><br>';
			$srcmsg .= 'Download: <a href="' . $proto . '://' . $servername . '/sendfile.php?fid=' . $fileid . '&vercode=' . stripslashes($dnldpass) . '">Click here to download the file</a><br>';
			$srcmsg .= 'Delete: <a href="' . $proto . '://' . $servername . '/modapply.php?del=1&sessid=' . $sessid . '&vercode=' . stripslashes($dnldpass) . '">Click here to DELETE the file</a><br>';

			$srcmsg .= 'To modify the file description, availability period or delete the file, use the modification code above and go to: <a href="' . $proto . '://' . $servername . '/download.php?mod=1">' . $proto . '://' . $servername . '/download.php?mod=1</a>';
			mail(stripslashes($YourEmail), utf8_encode($filename) . ' uploaded at ' . $companyname, $srcmsg, $srcheader) or die("Could not send sender email.");
			$dismsg = 'Your file was uploaded successfully.';
		} 
		else {
			error_log(stripslashes($dnldpass) . ": File upload failed for:" . $filename);
		}
	}
?>
<?=$titleandmenu; ?>
<p align="center"><span class="content-text"><strong><?=$dismsg; ?></strong></span></p>
<?
print $footer;
?>
</body>
</html>
