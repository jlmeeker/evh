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

$queryfiles = "select id, sessionid, name, method from Files where 1 order by id;";
$resfiles = mysql_query($queryfiles,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $queryfiles . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
$numfiles = mysql_num_rows($resfiles);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../default.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>
<body>
<?=$titleandmenu; ?>
<p align="center">
  <input name="Purge ALL Files" type="submit" id="Purge ALL Files" onClick="MM_goToURL('parent','purge.php');return document.MM_returnValue" value="Purge ALL Files">
</p>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th align="left" valign="top" nowrap class="header" scope="row" width="100">Dnld Code</th>
	<th align="left" valign="top" nowrap class="header" scope="row" width="100">Mod Code</th>
    <td align="left" valign="middle" nowrap class="header" scope="row">Filename</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Size</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Uploaded</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Expires</td>	
    <td align="left" valign="middle" nowrap class="header" scope="row">Avail</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Uploader</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Modify</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Delete</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Download</td>
  </tr>
<? 
$totalsize=0;
while ($rowfiles = mysql_fetch_row($resfiles)) { 
	$querysession = "select Sessions.id, dnldcode, modcode, indate, avail, srcemail, size, Files.id, Sessions.srcemail, Sessions.outdate from Sessions,Files where Sessions.id = $rowfiles[1] and Files.sessionid=Sessions.id;";
	$ressession = mysql_query($querysession,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $querysession . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
	$rowsession = mysql_fetch_row($ressession);
	$filesize = round($rowsession[6] / 1024 / 1024, 2);
	$totalsize += $filesize;
?>
  <tr>
    <th align="left" valign="top" nowrap class="content" scope="row" width="100"><?=$rowsession[1]; ?></th>
	<th align="left" valign="top" nowrap class="content" scope="row" width="100"><?=$rowsession[2]; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$rowfiles[2] . ' (' . $rowfiles[3] . ')'; ?></td>
    <td align="right" valign="middle" nowrap class="content" scope="row"><?=$filesize; ?> MB</td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$rowsession[3]; ?></td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$rowsession[9]; ?></td>	
    <td align="right" valign="middle" nowrap class="content" scope="row"><?=$rowsession[4]; ?></td>
    <td align="right" valign="middle" nowrap class="content" scope="row"><?=$rowsession[8]; ?></td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="http://<?=$servername . "/modfile.php?ba=1&sessid=" . $rowsession[0] . "&vercode=" . $rowsession[2] . "&modemail=" . $rowsession[5]; ?>">Modify</a></td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="http://<?=$servername . "/modapply.php?ba=1&del=1&sessid=" . $rowsession[0] . "&vercode=" . $rowsession[1]; ?>">Delete</a></td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="http://<?=$servername . "/sendfile.php?fid=$rowsession[7]&vercode=$rowsession[1]"; ?>">Download</a></td>
  </tr>
<?
} 
?>
</table>
<div class="content-text" align="center"><strong><?=$numfiles; ?> files (<?=$totalsize; ?>MB) currently in the system!</strong></div>
<?
print $footer;
?>

</body>
</html>
