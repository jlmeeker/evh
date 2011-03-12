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

// Version (please do not edit this);
$appversion = '1.1.5';

include 'lang/en.inc';
// set php timeout to 7 days (604800 seconds) in the php.ini file;
// set php max post size and max file size to 10GB (10000MB) in the php.ini file;

// Get a mysql-formatted date string for today;
$mydate = date('Y-m-d');
$date1d = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
$date3d = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+3, date("Y")));
$date1w = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+7, date("Y")));
$date2w = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+14, date("Y")));
$date3w = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+21, date("Y")));

// Make Database connection;		
$dbh = mysql_pconnect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);
	
// set default mail headers to get  UTF-8 to work;
// this MUST end in "\r\n" or it will cause problems later;
$utf8mailhdr = "MIME-Version: 1.0\r\n";
$utf8mailhdr = "Content-type: text/html; charset=UTF-8\r\n";

// default mail from address;
//$ehmailaddr = "$appname <eh@localhost>";
if (isset($YourEmail)) $ehmailaddr = "$YourEmail";

// File Upload Errors (HTTP);
$UPLOADERRORS = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder");
	
// Default title and menu header for all pages;
$titleandmenu = '<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">';
$titleandmenu .= '<tr>';
$titleandmenu .= '<th class="p_title" scope="row">' . $appname . '</th>';
$titleandmenu .= '</tr>';
$titleandmenu .= '<tr>';
$titleandmenu .= '<th class="content-text" scope="row">' . $appdesc . '</th>';
$titleandmenu .= '</tr>';
$titleandmenu .= '<tr>';
$titleandmenu .= '<th scope="row"><hr align="center" width="65%" size="1" noshade></th>';
$titleandmenu .= '</tr> ';
$titleandmenu .= '<tr>';
$titleandmenu .= '<th scope="row"><span class="menu">.:. <a href="http://' . $servername . '/index.php">' . $homelinktext . '</a>' . $sep;
if ($enableFTP == 1) $titleandmenu .= $uploadlinktext . ' [<a href="http://' . $servername . '/upload.php">HTTP</a> | <a href="http://' . $servername . '/ftp-up.php">FTP</a>]' . $sep;
$titleandmenu .=  '<a href="http://' . $servername . '/upload.php">' . $uploadlinktext . '</a>' . $sep;
$titleandmenu .= '<a href="http://' . $servername . '/download.php">' . $downloadlinktext . '</a>' . $sep;
$titleandmenu .= '<a href="http://' . $servername . '/download.php?mod=1">' . $moddellinktext . '</a>' . $sep;
$titleandmenu .= '</tr>';
$titleandmenu .= '</table>';
$titleandmenu .= '<p>&nbsp;</p>';
$titleandmenu .= '<p><br></p>';

// footer;
if (!$showdisclaimer) $footertext = '';

$footer = '<p>&nbsp;</p><p><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">';
$footer .= '<!-- <tr>';
$footer .= '<th scope="row" class="content-text">Languages: English Japanese<br><hr align="center" width="65%" size="1" noshade></th>';
$footer .= '</tr> -->';
$footer .= '<tr>';
$footer .= '<th scope="row" class="content-text">Version ' . $appversion . '<br>' . $footertext;
if ($banner != '') $footer .= '<br><img src="' . $banner . '">';
$footer .= '</tr>';
$footer .= '</table></p>';

// function for verifying email addresses;
// This is from: http://iamcal.com/publish/articles/php/parsing_email
// return of 0 is an invalid address, and a return value of 1 means a good address
function is_valid_email_address($email){
       $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
       $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
       $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c' . '\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
       $quoted_pair = '\\x5c\\x00-\\x7f';
       $domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
       $quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
       $domain_ref = $atom;
       $sub_domain = "($domain_ref|$domain_literal)";
       $word = "($atom|$quoted_string)";
       $domain = "$sub_domain(\\x2e$sub_domain)*";
       $local_part = "$word(\\x2e$word)*";
       $addr_spec = "$local_part\\x40$domain";
       return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
}

// Clean potentially nasty stuff from a string
function clean_email_string($string) {
	$string = ereg_replace('( |  +|, +|;|; +)', ',', $string);
	return $string;
}

// regex searching within an array;
function preg_array($pattern, $array) {
  $match = 0;
   foreach ($array as $key => $value){
         if (preg_match($pattern, $value)){
               $match = 1;
               break;
		}
   }
 return ($match == 1) ? true : false;
}

// remove a directory and all files in it;
function remove_files($code) {
   error_log($code . ': Beginning file deletion');
   $jnk = system('rm -rf ' . $GLOBALS['fpath'] . '/' . $code . '/');
   $jnk = system('rm -rf ' . $GLOBALS['ftppath'] . '/' . $code . '/');  
   $jnk = system('rm -f ' .  $GLOBALS['serverpath'] . '/' . $code);
}

// create ftp upload directory
function create_upload_dir() {
	$dirname = substr(md5(uniqid(rand(),1)),0,8);
	$path = $GLOBALS['ftppath'] . $dirname;
	mkdir($path) or die("Could not create temp ftp dir: $path.");
	chmod($path,0777);
	error_log($dirname . ": Created new FTP upload dir.");
	return $dirname;
}

// find the name and size of the file uploaded via FTP;
function find_ftp_file($dirloc) {
	// Find file in the ftp upload location;
	if ($handle = opendir($dirloc)) {
		while (false !== ($file = readdir($handle))) {
			$fullfile = $dirloc . "/" . $file;
			if ($file != "." && $file != "..") {
				$command = "ls -l \"$fullfile\" | awk '{print $5}'";
                $fsize = exec($command); 
				$finfo = array($file,$fsize,$fullfile);
			}
			else error_log("$file is not a valid file");
		}
		closedir($handle);
	}
	return $finfo;
}
?>
<!-- necessary java scripts -->
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
