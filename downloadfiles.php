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
	$query="select Sessions.id, Sessions.dnldcode, Sessions.modcode, Files.id, Files.sessionid, Files.name, Files.description from Sessions,Files where (Sessions.dnldcode=\"$VerificationNumber\" or Sessions.modcode=\"$VerificationNumber\") and (Sessions.destemail like \"%$YourEmail%\" or Sessions.srcemail like \"%$YourEmail%\") and Files.sessionid=Sessions.id;";
	$res = mysql_query($query,$dbh) or die("<p><b>A fatal database error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$appname; ?> - File Listing</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="default.css" rel="stylesheet" type="text/css">
</head>
<body>
<?=$titleandmenu; ?>
<?
	//echo $query . "<p>";
	while($row = mysql_fetch_row($res)){
	
		//if ($row[7] != "") $realname = $row[7];
		//else $realname = $row[5];
		$realname = $row[5];
		
		$fsize = filesize("$fpath/$row[1]/$realname");
		
		echo '<table width="500"  border="0" align="center" cellpadding="3" cellspacing="1" class="border">';
		echo '<tr>';
		echo '<th width="150" align="left" valign="top" nowrap class="header" scope="row">Filename</th>';
		echo '<td align="left" valign="middle" nowrap class="content" scope="row"><a href="sendfile.php?fid=' . $row[3] . '&vercode=' . $VerificationNumber . '">' . stripslashes($row[5]) . '</a></td>';
		echo '</tr>';
		echo '<tr>';
    	echo '<th width="150" align="left" valign="top" nowrap class="header" scope="row">Description</th>';
    	echo '<td align="left" valign="middle" nowrap class="content" scope="row">' . stripslashes($row[6]) . '</td>';
  		echo '</tr>';
		echo '<tr>';
    	echo '<th width="150" align="left" valign="top" nowrap class="header" scope="row">Size</th>';
    	echo '<td align="left" valign="middle" nowrap class="content" scope="row">' . round($fsize/1024/1024,2) . ' MB</td>';
  		echo '</tr>';	
		echo '</table>';
		echo '<p>';	
  	}
?>
<?
print $footer;
?>

</body>
</html>
