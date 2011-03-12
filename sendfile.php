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
$msg1 = '';
$msg2 = '';

// Test sessid;
$query = "select id from Sessions where (dnldcode=\"" . addslashes($vercode) . "\" or modcode=\"" . addslashes($vercode) . "\");";
$res = mysql_query($query,$dbh) or die("<p><b>Error getting session information.</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
if (mysql_num_rows($res) != 1) $msg1 = "The download code is invalid (expired upload?).";
$row = mysql_fetch_row($res);
$sessionid = $row[0];
	
// Test file presence before sending;
$query = "select name,method from Files where id=$fid;";
$res = mysql_query($query,$dbh) or die("<p><b>Error getting file name.</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
if (mysql_num_rows($res) != 1) $msg2 = "The requested file does not exist.";
else $row = mysql_fetch_row($res);

if ($msg1 == '' && $msg2 == '') {
	$realname = "$fpath/" . stripslashes($vercode) . "/$row[0]";
	$method = $row[1];
	
	// Create symlink;
	if ($method == 'http') $origin = "$fpath/" . stripslashes($vercode);
	elseif ($method == 'ftp') $origin = "$ftppath/" . stripslashes($vercode);

	if (!file_exists("$serverpath/$vercode")) symlink($origin,"$serverpath/" . stripslashes($vercode)) or error_log(stripslashes($vercode) . ": Failed to symlink $origin to $serverpath/$vercode");

	$url = $proto . '://' . $servername . '/' . stripslashes($vercode) . '/' . $row[0];
	
	if ($savehistory) {
		// record file download into History table;
		insert_history_entry('download', $fid, $sessionid);
	}

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - Send File</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?
if ($method == 'http') echo '<META http-equiv="refresh" content="8;URL=' . $url . '">';
?>
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>
<table width="50%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<th class="content-text" scope="row" align="left"><strong>
<?
if ($msg1 != '' || $msg2 != '' || !is_link("$serverpath/" . stripslashes($vercode))) die("<font color=red>File not found</font>");
echo $notesheading; 
?>
</strong></th>
</tr>
<tr>
<th class="content-text" scope="row" align="left">
 <ol>
<?
if ($method == 'http') {
  echo "<li><strong>$sendnote1</strong></li>";
  echo "<li><strong>$sendnote2</strong></li>";
}
else echo "<li><strong>$ftpsendnote1</strong></li>";
?>
  </ol>
</th>
</tr>
</table>
<p>&nbsp;</p>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">

<?
if ($method == 'http') { ?>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$sendpathfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="<?=$url; ?>"><?=$url; ?></a></td>
  </tr>
<?
}
else { ?>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$ftpserverfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$servername; ?></td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$ftpusernamefieldtitle ?><br>      </th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$ftpuser; ?></td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$ftppasswordfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$ftppass; ?></td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$ftppathfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?="/" . stripslashes($vercode) . "/"; ?></td>
  </tr>  
  <tr>  
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$sendfilenamefeldtitle; ?><br>      </th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$row[0]; ?></td>
  </tr>  
<?
}
?>
</table>
<?
print $footer;
?>
</body>
</html>
