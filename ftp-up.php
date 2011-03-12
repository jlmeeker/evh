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
$dirname = create_upload_dir();
$ftpurl = "ftp://$ftpuser:$ftppass@$servername/$dirname";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - FTP Transfer</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>
<table width="50%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<th class="content-text" scope="row" align="left"><strong><?=$ftpheading; ?></strong></th>
</tr>
<tr>
<th class="content-text" scope="row" align="left"> <ol>
  <li><strong><?=$ftpnote1; ?></strong></li>
  <li><strong><?=$ftpnote2; ?></strong></li>
  <li><strong><?=$ftpnote3; ?></strong></li>
  <li><strong><?=$ftpnote4; ?></strong></li>
  </ol>
</th>
</tr>
</table>
<form action="upload2.php" method="post" enctype="multipart/form-data" name="form1">
<input name="dirname" type="hidden" id="dirname" value="<?=$dirname; ?>">
<div align="center" class="content-text">  </div>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
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
    <td align="left" valign="middle" nowrap class="content" scope="row"><?="/$dirname/"; ?></td>
  </tr>  
<!--  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$ftpurlfieldtitle ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><a href="<?=$ftpurl; ?>"><?=$ftpurl; ?></a></td>
  </tr>    --> 
</table>
<p align="center">
  <input name="Next" type="submit" onClick="MM_validateForm('YourEmail','','RisEmail','DestinationEmail','','R','File1','','R');return document.MM_returnValue" value="Next">
</p>
</form>
<?
print $footer;
?>

</body>
</html>
