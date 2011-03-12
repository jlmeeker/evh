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


-- phpMyAdmin SQL Dump
-- version 2.9.0.2
-- http://www.phpmyadmin.net
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
-- Table structure for table `Availability`
-- 

USE eventhorizon;

CREATE TABLE `Availability` (
  `id` int(11) NOT NULL default '0',
  `short` varchar(10) NOT NULL default '',
  `long` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `Availability`
-- 

INSERT INTO `Availability` (`id`, `short`, `long`) VALUES 
(1, '1d', '1 Day'),
(2, '3d', '3 Days'),
(3, '1w', '1 Week'),
(4, '2w', '2 Weeks'),
(5, '3w', '3 Weeks');

-- --------------------------------------------------------

-- 
-- Table structure for table `Files`
-- 

CREATE TABLE `Files` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `method` varchar(128) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `sessionid` int(11) NOT NULL default '0',
  `size` bigint(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

-- 
-- Table structure for table `Sessions`
-- 

CREATE TABLE `Sessions` (
  `id` int(11) NOT NULL auto_increment,
  `indate` date NOT NULL default '0000-00-00',
  `outdate` date NOT NULL default '0000-00-00',
  `avail` tinytext NOT NULL,
  `srcemail` varchar(50) NOT NULL default '',
  `destemail` text NOT NULL,
  `dnldcode` varchar(25) NOT NULL default '',
  `modcode` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `dnldcode` (`dnldcode`),
  KEY `modcode` (`modcode`)
) TYPE=MyISAM AUTO_INCREMENT=0 ;

-- 
-- Table structure for table `History`
-- 

CREATE TABLE `History` (
  `id` int(11) NOT NULL auto_increment,
  `moddate` date NOT NULL default '0000-00-00',
  `srcip` varchar(10) NOT NULL default '',
  `type` varchar(30) NOT NULL default '',
  `browser` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `srcemail` varchar(255) NOT NULL default '',
  `dstemail` varchar(255) NOT NULL default '';
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;


