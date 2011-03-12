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

$query = "select * from History where 1 order by id;";
$res = mysql_query($query,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
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
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th align="left" valign="top" nowrap class="header" scope="row" width="100">Date</th>
	<th align="left" valign="top" nowrap class="header" scope="row" width="100">Type</th>
    <td align="left" valign="middle" nowrap class="header" scope="row">File</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">Source IP</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">From</td>
    <td align="left" valign="middle" nowrap class="header" scope="row">To</td>	
    <td align="left" valign="middle" nowrap class="header" scope="row">Browser</td>
  </tr>
<? 
while ($row = mysql_fetch_row($res)) { 
?>
  <tr>
    <th align="left" valign="top" nowrap class="content" scope="row" width="100"><?=$row[1]; ?></th>
	<th align="left" valign="top" nowrap class="content" scope="row" width="100"><?=$row[3]; ?></th>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$row[5]; ?></td>
    <td align="right" valign="middle" nowrap class="content" scope="row"><?=$row[2]; ?></td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$row[6]; ?></td>
    <td align="left" valign="middle" nowrap class="content" scope="row"><?=$row[7]; ?></td>	
    <td align="right" valign="middle" nowrap class="content" scope="row"><?=$row[4]; ?></td>
  </tr>
<?
} 
?>
</table>
<?
if (isset($ba) and $ba == 1) {
	echo '<p align="center"><span class="content-text"><strong><a href=index.php>Back to admin page</a></strong></span></p>';
}

print $footer;
?>

</body>
</html>
