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

ALTER TABLE `History`
  DROP COLUMN `sessionid`,
  DROP COLUMN `fileid`,
  ADD COLUMN `filename` varchar(255) NOT NULL default '',
  ADD COLUMN `srcemail` varchar(255) NOT NULL default '',
  ADD COLUMN `dstemail` varchar(255) NOT NULL default '';

