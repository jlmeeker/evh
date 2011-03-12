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

if (isset($mod) and $mod == 1) {
	$formurl="modfile.php";
	$heading="Modify";
	$codetype = "$modification";
}
else {
	$formurl="downloadfiles.php";
	$heading="Download";
	$codetype = "$verification";	
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - <?=$heading; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>
<form action="<?=$formurl; ?>" method="post" enctype="multipart/form-data" name="form1">
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$emailfield2title; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="YourEmail" type="text" id="YourEmail" size="30"></td>
  </tr>
  <tr>
    <th width="150" align="left" valign="top" nowrap class="header" scope="row"><?=$codetype; ?> Code </th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><input name="VerificationNumber" type="text" id="VerificationNumber" size="30"></td>
  </tr>
</table>
<p align="center">
  <br>
  <input name="Submit" type="submit" onClick="MM_validateForm('YourEmail','','RisEmail','VerificationNumber','','R');return document.MM_returnValue" value="Submit">
</p>
</form>
<?
print $footer;
?>

</body>
</html>
