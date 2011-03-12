-- This file is part of Event Horizon (EVH).
--
-- EVH is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 3 of the License, or
-- (at your option) any later version.
--
-- EVH is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.
--


-- Host: localhost
-- Generation Time: Aug 07, 2007 at 10:25 AM
-- Server version: 3.23.58
-- PHP Version: 5.0.4
-- 
-- Database: `eventhorizon`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `History`
-- 

USE eventhorizon;

CREATE TABLE `History` (
  `id` int(11) NOT NULL auto_increment,
  `moddate` date NOT NULL default '0000-00-00',
  `srcip` varchar(15) NOT NULL default '',
  `type` varchar(30) NOT NULL default '',
  `browser` varchar(255) NOT NULL default '',
  `sessionid` int(11) NOT NULL default '0',
  `fileid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


