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
<title><?=$appname; ?> - Upload</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>
<table width="50%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<th class="content-text" scope="row" align="left"><strong><?=$notesheading; ?></strong></th>
</tr>
<tr>
<th class="content-text" scope="row" align="left"> <ol>
  <li><strong><?=$note1; ?></strong></li>
  <li><strong><?=$note2; ?></strong></li>
  <li><strong><?=$note3; ?></strong></li>
  <li><strong><?=$note4; ?></strong></li>
  </ol>
</th>
</tr>
</table>
<form action="uploadfiles.php" method="post" enctype="multipart/form-data" name="form1">
<input name="MAX_FILE_SIZE" type="hidden" id="MAX_FILE_SIZE" value="2097152000">
<input name="browser" type="hidden" id="browser" value="">
<p></p>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$emailfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="YourEmail" type="text" id="YourEmail" size="30"></td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$destemailfieldtitle; ?><br>      </th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="DestinationEmail" type="text" id="DestinationEmail" size="30">    </td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$availfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row">
	<select name="AvailabilityPeriod" id="AvailabilityPeriod">
	<?
	  $query = "select * from Availability where 1;";
	  $res = mysql_query($query,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
      while ($row = mysql_fetch_row($res)) {
	  	if ($row[1] == "1d") $selected = " selected";
		else $selected = '';
	  	echo '<option value="' . $row[1] . '"' . $selected . '>' . $row[2] . '</option>';
	  }
	?>
    </select></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$filefieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="File1" type="file" id="File1" size="30"></td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$descfieldtitle; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="File1Description" type="text" id="File1Description" size="50"></td>
  </tr>
</table>
<p align="center"> <span class="content-text"><?=$largefilesdisclaimer; ?></span><br>
  <input name="Submit" type="submit" onClick="MM_validateForm('YourEmail','','RisEmail','DestinationEmail','','R','File1','','R');return document.MM_returnValue" value="Submit">
</p>
</form>
<?
print $footer;
?>
</body>
</html>
