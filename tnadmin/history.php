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
<form action="history.php" method="post" enctype="multipart/form-data" name="form1">
<input name="ba" type="hidden" id="ba" value="1">
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
    <th align="left" valign="top" nowrap class="header" scope="row" colspan="5"><center>Filtering</center></th>  
  </tr>
  <tr>
    <th align="left" valign="top" nowrap class="content" scope="row">Date (YYYY-MM-DD)<br>
		<input name="searchdate" type="text" value="<? if (isset($searchdate) && $_SERVER['REQUEST_METHOD'] != 'GET') echo $searchdate; else echo $mydate; ?>" size="12" maxlength="12" id="searchdate"><br>to<br>
		<input name="searchdate2" type="text" value="<? if (isset($searchdate2) && $_SERVER['REQUEST_METHOD'] != 'GET') echo $searchdate2; else echo $mydate; ?>" size="12" maxlength="12" id="searchdate2"></th>
	<th align="left" valign="top" nowrap class="content" scope="row">Type<br>
		<select name="type" id="type">
			<option value="" selected></option>		
			<option value="upload" <? if (isset($type) && $type == 'upload') echo 'selected'; ?>>upload</option>
			<option value="download" <? if (isset($type) && $type == 'download') echo 'selected'; ?>>download</option>	
			<option value="modify" <? if (isset($type) && $type == 'modify') echo 'selected'; ?>>modify</option>	
			<option value="delete" <? if (isset($type) && $type == 'delete') echo 'selected'; ?>>delete</option>				
			<option value="expired" <? if (isset($type) && $type == 'expired') echo 'selected'; ?>>expired</option>						
		</select></th>
    <th align="left" valign="top" nowrap class="content" scope="row">Filename<br>
		<input name="filename" type="text" value="<? if (isset($filename)) echo $filename; ?>" size="20" maxlength="20" id="filename"></th>
    <th align="left" valign="top" nowrap class="content" scope="row">Source IP<br>
		<input name="srcip" type="text" value="<? if (isset($srcip)) echo $srcip; ?>" size="20" maxlength="20" id="srcip"></th>
    <th align="left" valign="top" nowrap class="content" scope="row">Email<br>
		<input name="email" type="text" value="<? if (isset($email)) echo $email; ?>" size="20" maxlength="20" id="email"></th>
  </tr>  
  <tr>
  	<td align="left" valign="top" nowrap class="content" scope="row" colspan="3"><strong>Show:</strong><br>
		<input name="showdate" type="checkbox" value="1" <? if (! isset($showdate) && $_SERVER['REQUEST_METHOD'] != 'GET') echo ''; else echo 'checked'; ?>> Date<br>
		<input name="showtype" type="checkbox" value="1" <? if (! isset($showtype) && $_SERVER['REQUEST_METHOD'] != 'GET') echo ''; else echo 'checked'; ?>> Type<br>
		<input name="showfile" type="checkbox" value="1" <? if (! isset($showfile) && $_SERVER['REQUEST_METHOD'] != 'GET') echo ''; else echo 'checked'; ?>> Filename<br>
		<input name="showip" type="checkbox" value="1" <? if (! isset($showip) && $_SERVER['REQUEST_METHOD'] != 'GET') echo ''; else echo 'checked'; ?>> Source IP<br></td>
  	<td align="left" valign="top" nowrap class="content" scope="row" colspan="2"><strong>&nbsp;</strong><br>
		<input name="showsrcemail" type="checkbox" value="1" <? if (! isset($showsrcemail) && $_SERVER['REQUEST_METHOD'] != 'GET') echo ''; else echo 'checked'; ?>> Source Email<br>
		<input name="showdstemail" type="checkbox" value="1" <? if (! isset($showdstemail) && $_SERVER['REQUEST_METHOD'] != 'GET') echo ''; else echo 'checked'; ?>> Destination Email<br>
		<input name="showbrowser" type="checkbox" value="1" <? if (! isset($showbrowser)) echo ''; else echo 'checked'; ?>> Browser<br></td> 
  </tr>
  <tr>
  	<td align="left" valign="top" nowrap class="content" scope="row" colspan="5">
		<div align="right"><input name="Submit" type="submit" value="Submit"></div></td>  
  </tr>
</table>

</form>
<br>
<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">
  <tr>
<? if (isset($showdate) && $showdate == 1) { ?>
	<th align="left" valign="top" nowrap class="header" scope="row">Date</th>
<? }
if (isset($showtype) && $showtype == 1) { ?>
	<th align="left" valign="top" nowrap class="header" scope="row">Type</th>
<? }
if (isset($showfile) && $showfile == 1) { ?>
    <th align="left" valign="top" nowrap class="header" scope="row">File</th>
<? }
if (isset($showip) && $showip == 1) { ?>	
    <th align="left" valign="top" nowrap class="header" scope="row">Source IP</th>
<? }
if (isset($showsrcemail) && $showsrcemail == 1) { ?>	
    <th align="left" valign="top" nowrap class="header" scope="row">From</th>
<? }
if (isset($showdstemail) && $showdstemail == 1) { ?>	
    <th align="left" valign="top" nowrap class="header" scope="row">To</th>
<? }
if (isset($showbrowser) && $showbrowser == 1) { ?>		
    <th align="left" valign="top" nowrap class="header" scope="row">Browser</th>
<? } ?>
  </tr>
<? 
$querystart = 'select * from History where';
$querymid = '';

if (isset($searchdate) && $searchdate != '' && (! isset($searchdate2) || $searchdate2 == '')) $querymid .= ' and moddate >= "' . $searchdate . '"';
elseif (isset($searchdate) && $searchdate != '' && isset($searchdate2) && $searchdate2 != '') $querymid .= ' and moddate between "' . $searchdate . '" and "' . $searchdate2 . '"';
elseif (isset($searchdate2) && $searchdate2 != '' && (! isset($searchdate) || $searchdate == '')) $querymid .= ' and moddate <= "' . $searchdate2 . '"';
//if (isset($searchdate2) && $searchdate2 != '') $querymid .= ' and moddate between "' . $searchdate . '" and "' . $searchdate2 . '"';
//elseif (isset($searchdate) && $searchdate != '') $querymid .= ' and moddate = "' . $searchdate . '"';
if (isset($type) && $type != '') $querymid .= ' and type = "' . $type . '"';
if (isset($filename) && $filename != '') $querymid .= ' and filename like "%' . $filename . '%"';
if (isset ($srcip) && $srcip != '') $querymid .= ' and srcip like "%' . $srcip . '%"';
if (isset($email) && $email != '') $querymid .= ' and (srcemail like "%' . $email . '%" or dstemail like "%' . $email . '%")';

if ($querymid == '') $querymid = ' and moddate = "' . $mydate . '"';  // needs "and" part or the below substr command will fail;

$queryend = ' order by id';
$querymid = ' ' . substr($querymid,strpos($querymid,'and ')+4);
$query = $querystart . $querymid . $queryend;

$res = mysql_query($query,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());

while ($row = mysql_fetch_row($res)) { 
?>
  <tr>
<? if (isset($showdate) && $showdate == 1) { ?>  
    <td align="left" valign="top" nowrap class="content" scope="row" width="100"><?=$row[1]; ?></td>
<? }
if (isset($showtype) && $showtype == 1) { ?>
	<td align="left" valign="top" nowrap class="content" scope="row" width="100"><?=$row[3]; ?></td>
<? }
if (isset($showfile) && $showfile == 1) { ?>	
    <td align="left" valign="top" nowrap class="content" scope="row"><?=$row[5]; ?></td>
<? }
if (isset($showip) && $showip == 1) { ?>		
    <td align="right" valign="top" nowrap class="content" scope="row"><?=$row[2]; ?></td>
<? }
if (isset($showsrcemail) && $showsrcemail == 1) { ?>		
    <td align="left" valign="top" nowrap class="content" scope="row"><?=$row[6]; ?></td>
<? }
if (isset($showdstemail) && $showdstemail == 1) { ?>		
    <td align="left" valign="top" nowrap class="content" scope="row"><?=$row[7]; ?></td>	
<? }
if (isset($showbrowser) && $showbrowser == 1) { ?>			
    <td align="right" valign="top" nowrap class="content" scope="row"><?=$row[4]; ?></td>
<? } ?>	
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
