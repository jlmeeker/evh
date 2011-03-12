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

if (isset($vercode) and $vercode != '') $VerificationNumber = $vercode;
if (isset($modemail) and $modemail != '') $YourEmail = $modemail;

// Protect against XSS vulnerabilities;
$YourEmail = htmlspecialchars($YourEmail);
$VerificationNumber = htmlspecialchars($VerificationNumber);

$query='select Sessions.id, Sessions.dnldcode, Sessions.modcode, Sessions.avail, Sessions.srcemail, Sessions.destemail, Files.id, Files.description, Files.name from Sessions,Files where Sessions.srcemail="' . $YourEmail . '" and Sessions.modcode="' . $VerificationNumber . '" and Files.sessionid=Sessions.id';
$res = mysql_query($query,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - Edit File Information</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>
<form action="modapply.php" method="post" enctype="multipart/form-data" name="form1">
<div align="center" class="content-text">  </div>
<?
if (mysql_num_rows($res) == 0) die('<p align="center" class="content-text">No matching file found.</p>');

while($row = mysql_fetch_row($res)){ ?>
	<input name="fileid" type="hidden" value="<?=$row[6]; ?>">
	<input name="sessid" type="hidden" value="<?=$row[0]; ?>">
	<input name="dnldpass" type="hidden" value="<?=$row[1]; ?>">
	<input name="fname" type="hidden" value="<?=$row[8]; ?>">
	<input name="srcemail" type="hidden" value="<?=$row[4]; ?>">
	<input name="ba" type="hidden" value="<?=$ba; ?>">
	<input name="browser" type="hidden" id="browser" value="">
	<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
	<tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row">Source Email </th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=stripslashes($row[4]); ?></td>
  	</tr>	
 	<tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row">Destination Email(s) </th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="DestinationEmail" type="text" id="DestinationEmail" size="30" value="<?=stripslashes($row[5]); ?>"></td>
  	</tr>
  	<tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row">Availability Period</th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><select name="AvailabilityPeriod" id="AvailabilityPeriod">
	<?
	$queryavail = 'select * from Availability where 1';
	$resavail = mysql_query($queryavail,$dbh) or die('<p><b>A fatal database error occured</b>.\n<br />Query: ' . $queryavail . '<br />\nError: (' . mysql_errno() . ') ' . mysql_error());
	while ($rowavail = mysql_fetch_row($resavail)) {
	if ($rowavail[1] == $row[3]) $selectedavail = ' selected';
		else $selectedavail = '';
		echo '<option value="' . $rowavail[1] . '"' . $selectedavail . '>' . $rowavail[2] . '</option>';
		}
	?>
    </select></td>
  	</tr>
  	<tr>
    <th align="left" valign="top" nowrap class="header" scope="row">Description</th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="File1Description" type="text" id="File1Description" size="50" value="<?=stripslashes($row[7]); ?>"></td>
  	</tr>
	</table>
	<center><a href="modapply.php?del=1&sessid=<?=$row[0]; ?>&vercode=<?=$row[1]; ?>">delete</a></center>
	<p>
	<?
}	
?>
<p align="center"><br>
  <input name="Submit" type="submit" id="Submit" onClick="MM_validateForm('YourEmail','','RisEmail','DestinationEmaill','','RisEmail','File1','','R');return document.MM_returnValue" value="Save">
</p>
</form>
<?
print $footer;
?>
</body>
</html>
