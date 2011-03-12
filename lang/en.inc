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

// ------------------------------------------
// Application name, description and purpose
// ------------------------------------------
$appname = 'Event Horizon';
$appdesc = 'A single-use file transfer system';

$apppurpose = '<em>' . $appname . ': According to general relativity, an event horizon is a boundary in spacetime, defined with respect to an observer,
			 beyond which events cannot affect the observer. Light emitted beyond the horizon can never reach the observer, and 
			 anything that passes through the horizon from the observer\'s side is never seen again.</em>  &nbsp; &nbsp; (Source: 
			 <a href="http://en.wikipedia.org/wiki/Event_horizon" target=blank>Wikipedia:Event Horizon</a>)<br>
			 <br><!-- 
			 ' . $appname . ' was developed to allow the secure and timely transfer of information between Morinda Holdings /
			 Tahitian Noni International and its external contacts.  As such, this system is to be used by
			 authorized parties only.  Any unauthorized use will be logged and action taken against any offending 
			 users.<br>
			 <br>
			 Why is it named ' . $appname . '?  Like all creative applications, the name hints to the application\'s purpose.
			 This application is expected to behave, in some ways, similar to a black hole. -->';
			 
			 
// --------------------------------------
// Navigation links at top of pages
// --------------------------------------
$homelinktext = 'Home';
$uploadlinktext = 'Upload';
$downloadlinktext = 'Download';
$moddellinktext = 'Modify/Delete';
$helplinktext = 'Help';
$sep = ' .:. ';


// --------------------------------------
// Footer text
// --------------------------------------
$footertext = 'This site is for official ' . $companyname . ' file transfers only.';
$historyfootertext = 'All file transfers are logged.';

// -------------------------------------------
// Options below are for the specified pages

// --------------------------------------
// Home page
// --------------------------------------
$menutitle = 'Menu';
$uploadnewfile = 'Upload new file';
$downloadfile = 'Download existing file';
$modifyfile = 'Modify existing file';

// --------------------------------------
// Upload page
// --------------------------------------
$notesheading = 'NOTES:';
$note1 = 'All fields are mandatory except for the file description. If you have more than one file to upload, 
			combine all files into one (using zip or a similar program). Then, upload the resulting file.';
$note2 = 'For multiple email addresses be sure all addresses are separated with commas (,).';
$note3 = 'The availability period is how long the file will be kept on the system before it is deleted. Any 
			deleted files (manual or scheduled) cannot be recovered.';
$note4 = '<font color=red>File sizes are limited to under 2GB</font>';

// --------------------------------------
// Upload2 page
// --------------------------------------
$u2note1 = $note1;
$u2note2 = $note2;
$u2note3 = $note3;

$emailfieldtitle = 'Your email';
$destemailfieldtitle = 'Destination Email(s)';
$availfieldtitle = 'Availability Period';
$filefieldtitle = 'File';
$descfieldtitle = 'Description';
$largefilesdisclaimer = 'Large files may take a very long time to upload. During this time, the browser will appear busy.';

$nofilefounderror = '<font color=red>Error: No File Found!</font><p>One of three things just happened: 
<ol>
<li>No file was uploaded</li>
<li>The file was uploaded into the wrong FTP directory</li>
<li>An internal error occurred.</li>
</ol>
NOTE: You can go "Back" and fix the problem then re-click "Next".';

// --------------------------------------
// FTP Transfer page
// --------------------------------------
$ftpheading = 'INSTRUCTIONS:';
$ftpnote1 = 'Using the account information below, upload the file to the specified server and path.';
$ftpnote2 = 'Once the file upload is complete, please click the "Next" button to finish processing the file.';
$ftpnote3 = 'FTP uploads are still limited to a single file.  So please create zip/sit/tar archives if you want to upload multiple files.';
$ftpnote4 = '<font color=red>If this process is not completed within 24-hours, the file will be deleted.</font>';

$ftpserverfieldtitle = 'FTP Server';
$ftpusernamefieldtitle = 'Login';
$ftppasswordfieldtitle = 'Password';
$ftppathfieldtitle = 'Path';

// --------------------------------------
// Sendfile page
// --------------------------------------
$sendnote1 = 'Your download should begin in less than 10 seconds.';
$sendnote2 = 'If your download does not start, use the information below to download your file.';

$ftpsendnote1 = 'Please use the information below to retrieve your file.';

$sendpathfieldtitle = 'Direct Download Link';
$sendfilenamefeldtitle = 'Filename';

// --------------------------------------
// Download page
// --------------------------------------
$emailfield2title = $emailfieldtitle;
$verification = 'Download';
$modification = 'Modification';

?>
