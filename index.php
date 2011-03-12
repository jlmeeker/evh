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
//setlocale(LC_ALL, 'no_NO.utf8');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 

//echo "<p>&nbsp; <p>&nbsp; <p><center>$appname is currently down for maintenance.<p>Sorry for the inconvenience.</center>";
//exit;

?>
<?=$titleandmenu; ?>
<table width="50%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<th class="content-text" scope="row" align="left"><strong><?=$apppurpose; ?></strong>
</th>
</tr>
</table>
<p></p>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row" rowspan="4">&nbsp;&nbsp;<strong>.:.</strong>&nbsp;&nbsp;&nbsp;Menu</th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="upload.php">Upload new file via HTTP</a></td>
  </tr>
<?
if ($enableFTP == 1) {
?>  <tr>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="ftp-up.php">Upload new file via FTP</a></td>
  </tr>
<?
}
?>
  <tr>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="download.php">Download existing file</a></td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="download.php?mod=1">Modify existing file</a> </td>
  </tr>
</table>
<?
print $footer;
?>
</body>
</html>
