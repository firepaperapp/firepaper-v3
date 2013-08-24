-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2013 at 11:50 AM
-- Server version: 5.5.28-cll-lve
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ubundkac_bundle`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_config`
--

CREATE TABLE IF NOT EXISTS `activity_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template` text,
  `type` enum('comment','department','project','student','whiteboard') DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `activity_config`
--

INSERT INTO `activity_config` (`id`, `template`, `type`, `task`) VALUES
(1, '%who% added a new %commentlink% for the %project% project', 'project', 'addComment'),
(2, '%who% updated %project% with a new %document% ', 'project', 'uploadDocument'),
(3, '%who% created a new project %project%', 'project', 'createProject'),
(4, '%who% just sent you a personal %commentlink%', 'comment', 'personalComment'),
(5, '%who% has updated project %project%', 'project', 'projectUpdate'),
(6, '%who% has deleted document %document% from the %project% project', 'project', 'deleteDocument'),
(8, '%who% has submitted a new document %document% in project %project%', 'project', 'uploadDocumentToAdmin'),
(9, '%who% has deleted document %document% from the %project% project', 'project', 'deleteDocumentToAdmin'),
(10, '%who% has replaced document %document% from the %project% project', 'project', 'documentReplace'),
(11, '%who% has replaced document %document% from the %project% project', 'project', 'documentReplaceToAdmin'),
(12, '%who% has completed the task %task% in the %project% project', 'project', 'tickTaskDoneFrmUser'),
(13, '%who% has given you marks in the project %project%', 'project', 'markProject'),
(14, 'A new comment has been posted on the whiteboard %whiteboard%', 'whiteboard', 'whiteboardComment'),
(15, '%who% has added a %document% in the task %task% under the project %project%', 'project', 'extraDocFromAdminInTask'),
(16, '%who% has completed the project %project%', 'project', 'completeProject');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ids` text,
  `activity_text` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_ids`, `activity_text`, `created`) VALUES
(1, ',220,', '<a href=''http://beta.cloudpollen.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://beta.cloudpollen.com/projects/viewDetails/56''>fghfgh</a>', '2011-05-17 05:32:36'),
(2, ',220,', '<a href=''http://beta.cloudpollen.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://beta.cloudpollen.com/projects/viewDetails/56''>fghfgh</a>', '2011-05-19 02:21:56'),
(3, ',56,7,7,103,146,193,219,', '<a href=''http://beta.cloudpollen.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has submitted a new document <a href=''http://beta.cloudpollen.com/files/downloadFile/152''>document</a> in project <a href=''http://beta.cloudpollen.com/projects/markProject/1/13''>Test Project</a>', '2011-05-19 03:47:10'),
(4, ',266,', '<a href=''http://www.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> created a new project <a href=''http://www.mycloudroom.com/projects/viewDetails/105''>Jimmy''s super music solo</a>', '2011-05-27 12:55:13'),
(5, ',1,1,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> has completed the task Practice page 1 of the uploaded document in the <a href=''http://www.mycloudroom.com/projects/markProject/105/266''>Jimmy''s super music solo</a> project', '2011-05-27 12:59:52'),
(6, ',266,', '<a href=''http://www.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has given you marks in the project <a href=''http://www.mycloudroom.com/projects/viewDetails/105''>Jimmy''s super music solo</a>', '2011-05-27 13:05:01'),
(7, ',13,', '<a href=''http://www.mycloudroom.com/users/viewProfile/7''>Dsss </a> created a new project <a href=''http://www.mycloudroom.com/projects/viewDetails/107''>p1</a>', '2011-05-30 06:47:05'),
(8, ',220,226,', '<a href=''http://www.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> created a new project <a href=''http://www.mycloudroom.com/projects/viewDetails/108''>Test Project</a>', '2011-05-30 08:15:20'),
(9, ',218,1,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/226''>Testuser testuser</a> has submitted a new document <a href=''http://www.mycloudroom.com/files/downloadFile/325''>document</a> in project <a href=''http://www.mycloudroom.com/projects/markProject/108/226''>Test Project</a>', '2011-05-30 08:16:24'),
(10, ',266,', '<a href=''http://www.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has given you marks in the project <a href=''http://www.mycloudroom.com/projects/viewDetails/105''>Jimmy''s super music solo</a>', '2011-05-31 10:48:53'),
(11, ',220,226,266,', '<a href=''http://amitl.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://amitl.mycloudroom.com/projects/viewDetails/108''>Test Project</a>', '2011-06-03 08:14:28'),
(12, ',266,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/109''>Graphic design</a>', '2011-06-03 08:36:14'),
(13, ',266,', '<a href=''http://www.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has updated project <a href=''http://www.mycloudroom.com/projects/viewDetails/111''>Another attempt to create a project</a>', '2011-06-05 05:05:30'),
(14, ',218,219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> has submitted a new document <a href=''http://www.mycloudroom.com/files/downloadFile/336''>document</a> in project <a href=''http://www.mycloudroom.com/projects/markProject/111/266''>Another attempt to create a project</a>', '2011-06-05 08:35:02'),
(15, ',266,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has given you marks in the project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/111''>Another attempt to create a project</a>', '2011-06-05 08:51:37'),
(16, ',220,226,266,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has updated project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/108''>Test Project</a>', '2011-06-06 15:53:07'),
(17, ',266,', '<a href=''http://amitl.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://amitl.mycloudroom.com/projects/viewDetails/111''>Another attempt to create a project</a>', '2011-06-08 02:15:30'),
(18, ',220,226,278,266,', '<a href=''http://amitl.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://amitl.mycloudroom.com/projects/viewDetails/111''>Another attempt to create a project</a>', '2011-06-08 02:22:53'),
(19, ',266,', '<a href=''http://amitl.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://amitl.mycloudroom.com/projects/viewDetails/109''>Graphic design</a>', '2011-06-08 03:50:14'),
(20, ',220,226,278,', '<a href=''http://amitl.mycloudroom.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://amitl.mycloudroom.com/projects/viewDetails/98''>test</a>', '2011-06-08 04:22:42'),
(21, ',219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> added a new <a href=''http://www.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://www.mycloudroom.com/projects/markProject/111/266''>Another attempt to create a project</a> project', '2011-06-10 14:32:42'),
(22, ',266,281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/113''>A great project</a>', '2011-06-13 09:04:50'),
(23, ',266,281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/114''>project 1</a>', '2011-06-14 15:18:07'),
(24, ',266,281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/115''>project 2</a>', '2011-06-14 15:20:00'),
(25, ',266,281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/116''>project 3</a>', '2011-06-14 15:20:48'),
(26, ',13,163,164,165,166,200,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> has updated project <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/118''>Test Project - English</a>', '2011-06-29 07:21:53'),
(27, ',13,163,164,165,166,200,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> added a new <a href=''http://manpreet11.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/118/7''>Test Project - English</a> project', '2011-06-29 07:52:46'),
(28, ',13,163,164,165,166,200,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> has updated project <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/118''>Test Project - English</a>', '2011-06-29 08:04:42'),
(29, ',13,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> added a new <a href=''http://manpreet11.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/107/7''>p1</a> project', '2011-06-29 08:09:15'),
(30, ',13,163,164,165,166,200,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> added a new <a href=''http://manpreet11.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/118/7''>Test Project - English</a> project', '2011-06-29 08:09:46'),
(31, ',56,7,7,103,146,193,219,', '<a href=''http://studentmanu2.mycloudroom.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has submitted a new document <a href=''http://studentmanu2.mycloudroom.com/files/downloadFile/263''>document</a> in project <a href=''http://studentmanu2.mycloudroom.com/projects/markProject/118/13''>Test Project - English</a>', '2011-06-29 08:19:41'),
(32, ',13,', '<a href=''http://studentmanu2.mycloudroom.com/users/viewProfile/7''>Dsss </a> has given you marks in the project <a href=''http://studentmanu2.mycloudroom.com/projects/viewDetails/118''>Test Project - English</a>', '2011-06-29 08:20:15'),
(33, ',266,281,', '<a href=''http://www.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://www.mycloudroom.com/projects/viewDetails/120''>A brand new project for my cool students</a>', '2011-07-01 11:22:40'),
(34, ',262,219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/281''>Billy Jean</a> has completed the task Jig it around and see what u get in the <a href=''http://www.mycloudroom.com/projects/markProject/120/281''>A brand new project for my cool students</a> project', '2011-07-01 11:23:54'),
(35, ',266,281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> added a new <a href=''http://mrberrow.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/120/219''>A brand new project for my cool students</a> project', '2011-07-01 11:34:20'),
(36, ',281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> created a new project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/126''>Sweeeet</a>', '2011-07-04 05:30:22'),
(37, ',13,105,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> has added a <a href=''http://manpreet11.mycloudroom.com/files/downloadFile/367''>document</a> in the task 1281700748_1299048595 under the project <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/1''>Test Project</a>', '2011-07-05 07:22:27'),
(38, ',13,105,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> has added a <a href=''http://manpreet11.mycloudroom.com/files/downloadFile/367''>document</a> in the task 1281700748_1299048595 under the project <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/1''>Test Project</a>', '2011-07-05 07:22:38'),
(39, ',13,105,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> added a new <a href=''http://manpreet11.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/1/7''>Test Project</a> project', '2011-07-05 07:24:37'),
(40, ',,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> added a new <a href=''http://manpreet11.mycloudroom.com/dashboard/viewComments/''>comment</a> for the <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/128/7''>Test Project - 6th July</a> project', '2011-07-06 07:50:52'),
(41, ',13,163,164,165,166,200,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> has updated project <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/128''>Test Project - 6th July</a>', '2011-07-06 08:06:53'),
(42, ',13,163,164,165,166,200,', '<a href=''http://manpreet11.mycloudroom.com/users/viewProfile/7''>Dsss </a> has updated project <a href=''http://manpreet11.mycloudroom.com/projects/viewDetails/128''>Test Project - 6th July</a>', '2011-07-06 08:10:05'),
(43, '0,13,163,164,165,166,200,', 'A new comment has been posted on the whiteboard <a href=''http://manpreet11.mycloudroom.com/whiteboards/viewWhiteboard/110''>06July2011 - Whiteboard</a>', '2011-07-06 08:12:30'),
(44, '0,7,163,164,165,166,200,', 'A new comment has been posted on the whiteboard <a href=''http://manpreet11.mycloudroom.com/whiteboards/viewWhiteboard/110''>06July2011 - Whiteboard</a>', '2011-07-06 08:23:41'),
(45, ',,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.mycloudroom.com/files/downloadFile/330''>document</a> in the task fdfgdfgd under the project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/129''>Fun fun</a>', '2011-07-06 12:19:29'),
(46, ',,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.mycloudroom.com/files/downloadFile/334''>document</a> in the task fdfgdfgd under the project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/129''>Fun fun</a>', '2011-07-06 12:19:37'),
(47, ',,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.mycloudroom.com/files/downloadFile/350''>document</a> in the task fdfgdfgd under the project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/129''>Fun fun</a>', '2011-07-06 12:19:41'),
(48, ',262,219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> has completed the task Jig it around and see what u get in the <a href=''http://www.mycloudroom.com/projects/markProject/120/266''>A brand new project for my cool students</a> project', '2011-07-13 07:17:41'),
(49, ',262,219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> has submitted a new document <a href=''http://www.mycloudroom.com/files/downloadFile/373''>document</a> in project <a href=''http://www.mycloudroom.com/projects/markProject/120/266''>A brand new project for my cool students</a>', '2011-07-13 07:18:18'),
(50, ',262,219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> has submitted a new document <a href=''http://www.mycloudroom.com/files/downloadFile/356''>document</a> in project <a href=''http://www.mycloudroom.com/projects/markProject/120/266''>A brand new project for my cool students</a>', '2011-07-13 07:19:07'),
(51, ',262,219,1,103,146,193,219,', '<a href=''http://www.mycloudroom.com/users/viewProfile/266''>Jimmy  Tylor</a> has submitted a new document <a href=''http://www.mycloudroom.com/files/downloadFile/373''>document</a> in project <a href=''http://www.mycloudroom.com/projects/markProject/120/266''>A brand new project for my cool students</a>', '2011-07-13 07:19:24'),
(52, ',266,', '<a href=''http://www.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has given you marks in the project <a href=''http://www.mycloudroom.com/projects/viewDetails/120''>A brand new project for my cool students</a>', '2011-07-13 07:21:40'),
(53, ',56,7,7,103,146,193,219,', '<a href=''http://studentmanu2.mycloudroom.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has completed the task T1 in the <a href=''http://studentmanu2.mycloudroom.com/projects/markProject/128/13''>Test Project - 6th July</a> project', '2011-07-19 06:53:47'),
(54, ',56,7,', '<a href=''http://studentmanu2.mycloudroom.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has completed the project <a href=''http://studentmanu2.mycloudroom.com/projects/markProject/128/13''>Test Project - 6th July</a>', '2011-07-19 06:53:58'),
(55, ',56,7,', '<a href=''http://studentmanu2.mycloudroom.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has completed the project <a href=''http://studentmanu2.mycloudroom.com/projects/markProject/128/13''>Test Project - 6th July</a>', '2011-07-19 06:54:25'),
(56, ',56,7,', '<a href=''http://studentmanu2.mycloudroom.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has completed the project <a href=''http://studentmanu2.mycloudroom.com/projects/markProject/128/13''>Test Project - 6th July</a>', '2011-07-19 06:57:26'),
(57, ',,', '<a href=''http://www.mycloudroom.com/users/viewProfile/297''>Sam Berrow</a> has added a <a href=''http://www.mycloudroom.com/files/downloadFile/378''>document</a> in the task hit small under the project <a href=''http://www.mycloudroom.com/projects/viewDetails/130''>Create an advertising campaign</a>', '2011-07-19 12:35:15'),
(58, ',266,281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has updated project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/120''>A brand new project for my cool students</a>', '2011-07-19 16:29:45'),
(59, ',281,', '<a href=''http://mrberrow.mycloudroom.com/users/viewProfile/219''>Nigel Brown</a> has updated project <a href=''http://mrberrow.mycloudroom.com/projects/viewDetails/126''>Sweeeet</a>', '2011-07-19 16:32:18'),
(60, ',266,301,', '<a href=''http://amitl.cloudroomeducation.com/users/viewProfile/1''>Amit Luthra</a> has updated project <a href=''http://amitl.cloudroomeducation.com/projects/viewDetails/125''>Lovely</a>', '2011-09-09 02:04:24'),
(61, ',266,301,', '<a href=''http://amitl.cloudroomeducation.com/users/viewProfile/1''>Amit Luthra</a> has added a <a href=''http://amitl.cloudroomeducation.com/files/downloadFile/270''>document</a> in the task 1281700748 1298981726_1301907357 under the project <a href=''http://amitl.cloudroomeducation.com/projects/viewDetails/125''>Lovely</a>', '2011-09-09 02:05:29'),
(62, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/380''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:11'),
(63, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/330''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:17'),
(64, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/334''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:19'),
(65, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/348''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:23'),
(66, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/332''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:25'),
(67, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/380''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:29'),
(68, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/362''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:32'),
(69, ',,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has added a <a href=''http://mrberrow.cloudroomeducation.com/files/downloadFile/350''>document</a> in the task Make a good doc under the project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:45:36'),
(70, ',266,281,298,', '<a href=''http://mrberrow.cloudroomeducation.com/users/viewProfile/219''>Nigel Brown</a> has updated project <a href=''http://mrberrow.cloudroomeducation.com/projects/viewDetails/131''>Project cloudroom is done</a>', '2011-09-09 10:46:49'),
(71, ',305,', '<a href=''http://samberrowteacher.cloudroomeducation.com/users/viewProfile/304''>Sam Berrow</a> created a new project <a href=''http://samberrowteacher.cloudroomeducation.com/projects/viewDetails/132''>Make a poster design</a>', '2011-09-10 08:34:36'),
(72, ',304,304,304,103,146,193,219,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/305''>Aaron Berrow</a> has completed the task Upload a write up the concept of your poster in word format in the <a href=''http://www.cloudroomeducation.com/projects/markProject/132/305''>Make a poster design</a> project', '2011-09-10 08:39:19'),
(73, ',304,304,304,103,146,193,219,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/305''>Aaron Berrow</a> has completed the task Create poster and upload jpg and psd in the <a href=''http://www.cloudroomeducation.com/projects/markProject/132/305''>Make a poster design</a> project', '2011-09-10 08:39:25'),
(74, ',305,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/304''>Sam Berrow</a> has given you marks in the project <a href=''http://www.cloudroomeducation.com/projects/viewDetails/132''>Make a poster design</a>', '2011-09-10 08:40:15'),
(75, ',305,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/304''>Sam Berrow</a> created a new project <a href=''http://www.cloudroomeducation.com/projects/viewDetails/133''>Create a leaflet design</a>', '2011-09-10 08:44:56'),
(76, ',304,304,304,103,146,193,219,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/305''>Aaron Berrow</a> has submitted a new document <a href=''http://www.cloudroomeducation.com/files/downloadFile/382''>document</a> in project <a href=''http://www.cloudroomeducation.com/projects/markProject/133/305''>Create a leaflet design</a>', '2011-09-10 08:46:47'),
(77, ',304,304,304,103,146,193,219,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/305''>Aaron Berrow</a> has submitted a new document <a href=''http://www.cloudroomeducation.com/files/downloadFile/383''>document</a> in project <a href=''http://www.cloudroomeducation.com/projects/markProject/133/305''>Create a leaflet design</a>', '2011-09-12 02:32:11'),
(78, ',304,304,304,103,146,193,219,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/305''>Aaron Berrow</a> has submitted a new document <a href=''http://www.cloudroomeducation.com/files/downloadFile/384''>document</a> in project <a href=''http://www.cloudroomeducation.com/projects/markProject/133/305''>Create a leaflet design</a>', '2011-09-12 02:42:34'),
(79, ',305,', '<a href=''http://www.cloudroomeducation.com/users/viewProfile/304''>Sam Berrow</a> has added a <a href=''http://www.cloudroomeducation.com/files/downloadFile/387''>document</a> in the task broken link01 under the project <a href=''http://www.cloudroomeducation.com/projects/viewDetails/133''>Create a leaflet design</a>', '2011-09-12 03:11:34'),
(80, ',7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> added a new <a href=''http://studentmanu2.cloudroomeducation.com/dashboard/viewComments/''>comment</a> for the <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/128/13''>Test Project - 6th July</a> project', '2011-09-12 05:25:11'),
(81, ',7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> added a new <a href=''http://studentmanu2.cloudroomeducation.com/dashboard/viewComments/''>comment</a> for the <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/128/13''>Test Project - 6th July</a> project', '2011-09-12 05:25:21'),
(82, ',7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> added a new <a href=''http://studentmanu2.cloudroomeducation.com/dashboard/viewComments/''>comment</a> for the <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/128/13''>Test Project - 6th July</a> project', '2011-09-12 05:25:41'),
(83, ',56,7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has submitted a new document <a href=''http://studentmanu2.cloudroomeducation.com/files/downloadFile/190''>document</a> in project <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/107/13''>p1</a>', '2011-09-12 05:28:02'),
(84, ',7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> added a new <a href=''http://studentmanu2.cloudroomeducation.com/dashboard/viewComments/''>comment</a> for the <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/128/13''>Test Project - 6th July</a> project', '2011-09-12 05:33:09'),
(85, ',56,7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has submitted a new document <a href=''http://studentmanu2.cloudroomeducation.com/files/downloadFile/152''>document</a> in project <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/107/13''>p1</a>', '2011-09-12 05:56:50'),
(86, ',56,7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> has submitted a new document <a href=''http://studentmanu2.cloudroomeducation.com/files/downloadFile/152''>document</a> in project <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/107/13''>p1</a>', '2011-09-12 05:57:21'),
(87, ',100,', '<a href=''http://manpreet11.cloudroomeducation.com/users/viewProfile/7''>Dsss </a> created a new project <a href=''http://manpreet11.cloudroomeducation.com/projects/viewDetails/134''>TEsted</a>', '2011-09-14 23:27:56'),
(88, ',100,', '<a href=''http://manpreet11.cloudroomeducation.com/users/viewProfile/7''>Dsss </a> has updated project <a href=''http://manpreet11.cloudroomeducation.com/projects/viewDetails/134''>TEsted</a>', '2011-09-14 23:29:34'),
(89, ',7,7,103,146,193,219,', '<a href=''http://studentmanu2.cloudroomeducation.com/users/viewProfile/13''>Studentmanu2 studentmanu2</a> added a new <a href=''http://studentmanu2.cloudroomeducation.com/dashboard/viewComments/''>comment</a> for the <a href=''http://studentmanu2.cloudroomeducation.com/projects/markProject/1/13''>Test Project</a> project', '2011-09-15 22:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `firstName`, `lastName`, `userName`, `password`, `email`, `dateCreated`, `dateModified`) VALUES
(1, 'Amit', 'Luthra', 'admin', 'b2b31876fa72c321940845ff2ef5529d', 'amit.l@idsil.com', '2011-01-06 02:19:30', '2011-01-06 18:49:30'),
(8, 'Amit', 'Luthra', 'suadmin', '6ed61d4b80bb0f81937b32418e98adca', 'amit.lsu@idsil.com', '2011-01-06 02:19:30', '2011-01-06 18:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_text` text,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `groupid` mediumint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `announcement_text`, `created`, `created_by`, `groupid`) VALUES
(1, 'ggg', '2011-04-05 14:01:43', 7, 0),
(2, 's', '2011-04-05 14:02:22', 7, 0),
(3, 'ccxcxcx', '2011-04-05 14:02:47', 7, 0),
(4, 'csssssss', '2011-04-05 14:09:24', 7, 0),
(5, 'hi to all', '2011-05-19 01:21:04', 1, 86),
(6, 'Jimmy, well done!', '2011-05-27 13:03:55', 1, 0),
(7, 'TESR', '2011-07-04 07:06:23', 219, 0),
(8, 'Danny boy', '2011-07-04 15:33:33', 219, 0),
(9, 'sfsd', '2011-07-04 15:35:44', 219, 0),
(10, 'wsdfs', '2011-07-13 07:21:17', 219, 0),
(11, 'sfsdf', '2011-07-19 16:26:27', 219, 0),
(12, 'Test Announcement', '2011-09-09 01:59:41', 1, 0),
(13, 'asdas', '2013-02-05 09:45:16', 219, 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_status`
--

CREATE TABLE IF NOT EXISTS `announcement_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=closed,1=active',
  PRIMARY KEY (`id`),
  KEY `announcement_status_dc` (`announcement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `announcement_status`
--

INSERT INTO `announcement_status` (`id`, `announcement_id`, `student_id`, `status`) VALUES
(1, 2, 200, '1'),
(2, 3, 13, '1'),
(3, 4, 13, '1'),
(4, 5, 220, '1'),
(5, 6, 266, '0'),
(6, 7, 266, '0'),
(7, 8, 266, '0'),
(8, 8, 220, '1'),
(9, 8, 223, '1'),
(10, 8, 228, '1'),
(11, 9, 220, '1'),
(12, 10, 223, '1'),
(13, 11, 223, '1'),
(14, 12, 220, '1'),
(15, 12, 266, '1'),
(16, 12, 226, '1'),
(17, 12, 278, '1'),
(18, 12, 281, '1'),
(19, 12, 301, '1'),
(20, 13, 266, '1'),
(21, 13, 281, '1');

-- --------------------------------------------------------

--
-- Table structure for table `classgroup_students`
--

CREATE TABLE IF NOT EXISTS `classgroup_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `classgrp_linkedgrps_dc` (`group_id`),
  KEY `classgrp_linkedgrps_user_dc` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `classgroup_students`
--

INSERT INTO `classgroup_students` (`id`, `group_id`, `user_id`, `added_by`, `lastmodified`) VALUES
(57, 74, 207, 67, '2011-04-01 00:02:54'),
(58, 79, 208, 67, '2011-04-01 00:04:32'),
(63, 83, 238, 232, '2011-04-15 20:27:13'),
(64, 85, 250, 247, '2011-04-25 16:56:25'),
(65, 86, 220, 1, '2011-05-17 10:31:43'),
(66, 88, 266, 1, '2011-05-27 17:51:19'),
(67, 90, 268, 267, '2011-05-30 10:04:22'),
(68, 86, 226, 1, '2011-05-30 13:12:51'),
(69, 86, 278, 1, '2011-06-08 07:21:18'),
(70, 92, 279, 270, '2011-06-08 21:09:44'),
(71, 88, 281, 219, '2011-06-13 13:53:00'),
(72, 93, 266, 219, '2011-06-14 19:49:13'),
(73, 94, 281, 219, '2011-07-01 16:22:25'),
(74, 97, 298, 297, '2011-07-19 18:02:49'),
(75, 93, 301, 1, '2011-09-09 06:58:20'),
(76, 98, 303, 219, '2011-09-09 16:31:14'),
(77, 100, 305, 304, '2011-09-09 16:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `classgrp_linkedgrps`
--

CREATE TABLE IF NOT EXISTS `classgrp_linkedgrps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `lastmodified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `classgrp_linkedgrps_dc1` (`group_id`),
  KEY `classgrp_linkedgrps_user_dc1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_groups`
--

CREATE TABLE IF NOT EXISTS `class_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `group_type` enum('year','class') DEFAULT 'year',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Top level group',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '//this will be used to show all the groups that is created by a educator''s admin',
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `class_groups`
--

INSERT INTO `class_groups` (`id`, `title`, `group_type`, `parent_id`, `created`, `created_by`, `admin_id`, `lastmodified`) VALUES
(1, '2011', 'year', 0, '2011-02-24 14:41:59', 1, 1, '2011-02-24 20:41:23'),
(3, '2011', 'year', 0, '2011-02-25 10:07:12', 7, 7, '2011-02-25 16:06:32'),
(4, 'c1', 'class', 3, '2011-02-25 10:07:18', 7, 7, '2011-02-25 16:06:39'),
(5, 'c2', 'class', 3, '2011-03-03 15:06:01', 7, 7, '2011-03-03 21:04:58'),
(6, 'Yeargroup', 'year', 0, '2011-03-08 16:51:18', 7, 7, '2011-03-08 22:50:15'),
(7, 'C1', 'class', 6, '2011-03-08 16:54:11', 7, 7, '2011-03-08 22:53:08'),
(8, 'ssasdadas', 'year', 0, '2011-03-09 15:38:40', 7, 7, '2011-03-09 21:38:49'),
(9, 'man(r)', 'class', 8, '2011-03-09 15:38:53', 7, 7, '2011-04-01 22:16:03'),
(10, 'wwwwwwww', 'year', 0, '2011-03-09 16:46:26', 7, 7, '2011-03-09 22:46:36'),
(11, 'ccccccccc', 'class', 10, '2011-03-09 16:46:42', 7, 7, '2011-03-09 22:46:52'),
(12, '2k11', 'year', 0, '2011-03-09 17:06:06', 17, 17, '2011-03-09 23:06:16'),
(13, 'new group', 'class', 12, '2011-03-09 17:07:17', 17, 17, '2011-03-09 23:07:27'),
(14, 'grs', 'year', 0, '2011-03-09 18:02:17', 19, 19, '2011-03-10 00:02:27'),
(15, 'new', 'class', 14, '2011-03-09 18:04:05', 19, 19, '2011-03-10 00:04:16'),
(16, 'new1', 'year', 0, '2011-03-09 18:09:44', 19, 19, '2011-03-10 00:09:54'),
(17, 'new', 'class', 16, '2011-03-09 18:12:24', 19, 19, '2011-03-10 00:12:34'),
(18, 'new', 'year', 0, '2011-03-09 18:25:26', 17, 17, '2011-03-10 00:25:36'),
(19, 'gg', 'class', 18, '2011-03-09 18:26:00', 17, 17, '2011-03-10 00:26:10'),
(20, 'new', 'class', 18, '2011-03-09 18:30:41', 17, 17, '2011-03-10 00:30:52'),
(21, 'new', 'year', 0, '2011-03-10 10:21:10', 33, 33, '2011-03-10 16:21:27'),
(22, 'first class group', 'class', 21, '2011-03-10 10:21:49', 33, 33, '2011-03-10 16:22:06'),
(23, '1 group', 'year', 0, '2011-03-10 11:06:20', 33, 33, '2011-03-10 17:06:38'),
(24, 'Till', 'year', 0, '2011-03-10 11:58:20', 33, 33, '2011-03-10 17:58:39'),
(25, 'Till=group', 'class', 24, '2011-03-10 12:00:46', 33, 33, '2011-03-10 18:01:05'),
(26, '2011', 'year', 0, '2011-03-11 10:14:44', 39, 39, '2011-03-11 16:15:12'),
(27, '2011-A', 'class', 26, '2011-03-11 10:15:31', 39, 39, '2011-03-11 16:15:59'),
(28, '2011-B', 'class', 26, '2011-03-11 10:20:53', 39, 39, '2011-03-11 16:21:21'),
(29, 'second class group', 'class', 21, '2011-03-11 13:44:29', 50, 33, '2011-03-11 19:44:58'),
(30, 'c2222', 'class', 10, '2011-03-11 15:35:42', 7, 7, '2011-03-11 21:36:12'),
(31, 'GRP1', 'year', 0, '2011-03-15 09:37:00', 55, 55, '2011-03-15 14:38:09'),
(32, 'Class A', 'class', 31, '2011-03-15 09:40:38', 55, 55, '2011-03-15 14:41:47'),
(33, 'Class B', 'class', 31, '2011-03-15 09:41:40', 55, 55, '2011-03-15 14:42:49'),
(34, 'GRP2', 'year', 0, '2011-03-15 10:39:31', 55, 55, '2011-03-15 15:40:41'),
(35, 'C Class', 'class', 34, '2011-03-15 10:42:37', 55, 55, '2011-03-15 15:43:47'),
(36, 'D Class', 'class', 34, '2011-03-15 10:43:15', 55, 55, '2011-03-15 15:44:25'),
(37, 'manu', 'year', 0, '2011-03-15 11:38:38', 7, 7, '2011-03-15 16:39:48'),
(38, 'rr', 'year', 0, '2011-03-15 11:41:04', 7, 7, '2011-03-15 16:42:15'),
(39, 'first year group', 'year', 0, '2011-03-16 18:33:26', 67, 67, '2011-03-16 23:34:50'),
(40, 'first class group', 'class', 39, '2011-03-16 18:34:04', 67, 67, '2011-03-16 23:35:28'),
(41, 'New Group17', 'year', 0, '2011-03-17 09:58:58', 55, 55, '2011-03-17 15:00:28'),
(42, 'SSB', 'class', 41, '2011-03-17 09:59:47', 55, 55, '2011-03-17 15:01:17'),
(43, 'second year group', 'year', 0, '2011-03-18 11:22:13', 67, 67, '2011-03-18 16:23:54'),
(44, 'second class group', 'class', 43, '2011-03-18 11:22:35', 67, 67, '2011-03-18 16:24:16'),
(45, 'manue', 'year', 0, '2011-03-23 11:05:58', 7, 7, '2011-03-23 16:08:31'),
(46, '..', 'year', 0, '2011-03-23 11:10:45', 7, 7, '2011-03-23 16:13:18'),
(47, 'fds', 'year', 0, '2011-03-23 12:10:35', 7, 7, '2011-03-23 17:13:08'),
(48, 'fff', 'year', 0, '2011-03-23 15:08:43', 55, 55, '2011-03-23 20:11:18'),
(49, 'c1', 'year', 0, '2011-03-23 17:25:19', 92, 92, '2011-03-23 22:27:55'),
(50, 'c1', 'class', 49, '2011-03-23 17:25:30', 92, 92, '2011-03-23 22:28:06'),
(51, 'C1 Yeargroup', 'year', 0, '2011-03-24 15:55:00', 92, 92, '2011-03-24 20:57:46'),
(52, 'C1 Class Group', 'class', 51, '2011-03-24 15:55:29', 92, 92, '2011-03-24 20:58:15'),
(53, 'Group1.new', 'year', 0, '2011-03-25 17:19:27', 136, 136, '2011-03-25 22:22:23'),
(54, 'class 1', 'class', 53, '2011-03-25 17:20:15', 136, 136, '2011-03-25 22:23:12'),
(55, 'BE', 'year', 0, '2011-03-28 10:40:23', 147, 147, '2011-03-28 15:43:48'),
(56, 'MECH', 'class', 55, '2011-03-28 10:40:43', 147, 147, '2011-03-28 15:44:08'),
(57, 'CSE', 'class', 55, '2011-03-28 17:18:28', 147, 147, '2011-03-28 22:21:56'),
(58, 'AKVIDYAMANDIR', 'year', 0, '2011-03-29 10:26:44', 173, 173, '2011-03-29 15:30:19'),
(59, 'Ak-01group(Math)', 'class', 58, '2011-03-29 10:27:24', 173, 173, '2011-03-29 15:30:59'),
(63, 'cxvxcvxcvxc', 'year', 0, '2011-03-29 11:54:40', 67, 67, '2011-03-29 16:58:16'),
(65, 'asasasas', 'year', 0, '2011-03-29 12:39:11', 177, 177, '2011-03-29 17:42:47'),
(68, 'sdasdasd', 'year', 0, '2011-03-29 14:22:49', 177, 177, '2011-03-29 19:26:26'),
(69, 'sdasdas', 'class', 68, '2011-03-29 14:25:11', 177, 177, '2011-03-29 19:28:48'),
(70, 'asdas', 'class', 43, '2011-03-29 14:40:46', 67, 67, '2011-03-29 19:44:23'),
(71, 'adasdasa', 'class', 63, '2011-03-29 14:41:58', 67, 67, '2011-03-29 19:45:35'),
(72, 'aSaaS', 'class', 63, '2011-03-29 14:43:33', 67, 67, '2011-03-29 19:47:10'),
(73, 'SADAS', 'class', 63, '2011-03-29 14:46:35', 67, 67, '2011-03-29 19:50:12'),
(74, 'XCVXC', 'class', 63, '2011-03-29 14:48:48', 67, 67, '2011-03-29 19:52:25'),
(75, 'dsgrdsfhg', 'year', 0, '2011-03-29 14:50:10', 147, 147, '2011-03-29 19:53:47'),
(76, 'hdfhaehth', 'class', 75, '2011-03-29 14:50:25', 147, 147, '2011-03-29 19:54:02'),
(77, 'dasdas', 'class', 75, '2011-03-29 14:53:52', 147, 147, '2011-03-29 19:57:29'),
(79, 'new', 'class', 63, '2011-03-29 15:26:16', 67, 67, '2011-03-29 20:29:53'),
(80, 'test', 'class', 63, '2011-03-29 15:51:38', 67, 67, '2011-03-29 20:55:16'),
(81, 'sdfsd', 'class', 63, '2011-03-29 16:09:46', 67, 67, '2011-03-29 21:13:24'),
(82, 'first year group', 'year', 0, '2011-04-15 15:20:11', 232, 232, '2011-04-15 20:26:45'),
(83, 'first class group', 'class', 82, '2011-04-15 15:20:40', 232, 232, '2011-04-15 20:27:13'),
(84, 'a1', 'year', 0, '2011-04-25 11:47:59', 247, 247, '2011-04-25 16:56:14'),
(85, 'b1', 'class', 84, '2011-04-25 11:48:09', 247, 247, '2011-04-25 16:56:25'),
(86, 'Mec', 'class', 1, '2011-05-17 05:31:43', 1, 1, '2011-05-17 10:31:43'),
(87, 'Prog', 'class', 1, '2011-05-19 01:30:20', 1, 1, '2011-05-19 06:30:20'),
(88, 'Year 2F', 'class', 1, '2011-05-27 12:51:19', 1, 1, '2011-05-27 17:51:19'),
(89, '2011', 'year', 0, '2011-05-30 05:03:59', 267, 267, '2011-05-30 10:03:59'),
(90, 'CSE', 'class', 89, '2011-05-30 05:04:22', 267, 267, '2011-05-30 10:04:22'),
(91, 'Bright kids', 'year', 0, '2011-06-05 07:43:04', 270, 270, '2011-06-05 12:43:04'),
(92, 'Block 1', 'class', 91, '2011-06-05 07:44:54', 270, 270, '2011-06-05 12:44:54'),
(93, 'Nigels group', 'class', 1, '2011-06-14 14:49:13', 219, 1, '2011-06-14 19:49:13'),
(94, 'Year 15G', 'class', 1, '2011-07-01 11:22:25', 219, 1, '2011-07-01 16:22:25'),
(95, 'Year 12F', 'year', 0, '2011-07-19 12:37:41', 297, 297, '2011-07-19 17:37:41'),
(96, 'Year 15E', 'year', 0, '2011-07-19 12:46:15', 297, 297, '2011-07-19 17:46:15'),
(97, 'Marketing group', 'class', 95, '2011-07-19 13:02:49', 297, 297, '2011-07-19 18:02:49'),
(98, 'Year 7', 'class', 1, '2011-09-09 11:30:29', 219, 1, '2011-09-09 16:30:29'),
(99, 'Year 2', 'year', 0, '2011-09-09 11:48:48', 304, 304, '2011-09-09 16:48:48'),
(100, '2F', 'class', 99, '2011-09-09 11:49:11', 304, 304, '2011-09-09 16:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `coadmin_gaurdians`
--

CREATE TABLE IF NOT EXISTS `coadmin_gaurdians` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `type` enum('1','2') DEFAULT NULL COMMENT '1=gaurdian 2 = coadmin',
  PRIMARY KEY (`id`),
  KEY `coadmin_gaurdians_dcUser` (`parent_id`),
  KEY `coadmin_gaurdians_dcuser1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `coadmin_gaurdians`
--

INSERT INTO `coadmin_gaurdians` (`id`, `user_id`, `parent_id`, `type`) VALUES
(48, 219, 1, '2'),
(50, 305, 306, '1');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) NOT NULL DEFAULT '0',
  `file_id` int(11) NOT NULL DEFAULT '0',
  `message` text,
  `created` datetime DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0',
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `from_id`, `to_id`, `file_id`, `message`, `created`, `private`, `updated_on`) VALUES
(4, 7, 0, 58, 'fdsfdsfdsfdsfsd fsd fds fsd fds', '2011-03-10 16:04:59', 0, '0000-00-00 00:00:00'),
(5, 7, 0, 58, 'cxcxcx', '2011-03-10 16:06:43', 0, '0000-00-00 00:00:00'),
(8, 7, 0, 58, 'kjjhkhkj fds fd', '2011-03-10 16:49:44', 0, '0000-00-00 00:00:00'),
(11, 7, 0, 62, 'ytuytuytuyt', '2011-03-10 17:56:54', 0, '0000-00-00 00:00:00'),
(12, 7, 0, 58, 'Commenenene enenen', '2011-03-10 18:00:08', 0, '0000-00-00 00:00:00'),
(13, 7, 0, 58, 'dsadas', '2011-03-10 18:01:24', 0, '0000-00-00 00:00:00'),
(14, 7, 0, 58, 'dsadas sd sa dsa dsa', '2011-03-10 18:01:36', 0, '0000-00-00 00:00:00'),
(15, 7, 0, 58, 'cvxv cv x', '2011-03-10 18:03:04', 0, '0000-00-00 00:00:00'),
(16, 7, 0, 58, 'vcxvx', '2011-03-10 18:04:36', 0, '0000-00-00 00:00:00'),
(17, 7, 0, 58, 'vcxvx  vcx vcx', '2011-03-10 18:04:42', 0, '0000-00-00 00:00:00'),
(18, 35, 0, 94, 'nice picture uploaded by ram', '2011-03-10 18:18:50', 0, '0000-00-00 00:00:00'),
(19, 7, 0, 99, 'jlhkjhkjhk', '2011-03-10 19:15:00', 0, '0000-00-00 00:00:00'),
(20, 7, 0, 99, 'jlhkjhkjhk jgh jhg jhg jhg', '2011-03-10 19:15:08', 0, '0000-00-00 00:00:00'),
(21, 7, 0, 99, 'jlhkjhkjhk jgh jhg jhg jhg hg jhg jhgjhg', '2011-03-10 19:15:15', 0, '0000-00-00 00:00:00'),
(22, 42, 0, 108, 'TEST Commentf f f f f f f f', '2011-03-11 09:58:19', 0, '0000-00-00 00:00:00'),
(23, 42, 0, 108, '  TEST Comment FROM Manpreet CHECK fffffff', '2011-03-11 09:58:37', 0, '0000-00-00 00:00:00'),
(24, 42, 0, 108, 'dfd df dfd', '2011-03-11 10:01:35', 0, '0000-00-00 00:00:00'),
(25, 42, 0, 108, 'fdfdfd', '2011-03-11 10:01:46', 0, '0000-00-00 00:00:00'),
(26, 42, 0, 108, 'fd', '2011-03-11 10:02:09', 0, '0000-00-00 00:00:00'),
(27, 42, 0, 108, 'fd', '2011-03-11 10:02:41', 0, '0000-00-00 00:00:00'),
(28, 42, 0, 108, 'fd', '2011-03-11 10:03:52', 0, '0000-00-00 00:00:00'),
(29, 42, 0, 108, 'vc', '2011-03-11 10:04:47', 0, '0000-00-00 00:00:00'),
(30, 42, 0, 110, 'h1', '2011-03-11 10:07:38', 0, '0000-00-00 00:00:00'),
(31, 42, 0, 110, 'h2', '2011-03-11 10:07:43', 0, '0000-00-00 00:00:00'),
(32, 42, 0, 110, 'h3', '2011-03-11 10:07:48', 0, '0000-00-00 00:00:00'),
(33, 42, 0, 110, 'h5', '2011-03-11 10:07:53', 0, '0000-00-00 00:00:00'),
(34, 8, 0, 6, 'h', '2011-03-11 10:44:31', 0, '0000-00-00 00:00:00'),
(35, 7, 0, 103, 'hkjkj', '2011-03-11 12:57:14', 0, '0000-00-00 00:00:00'),
(36, 55, 0, 120, 'Check it out the uploaded files.', '2011-03-14 10:33:03', 0, '0000-00-00 00:00:00'),
(37, 55, 0, 120, ' Second commjjjent', '2011-03-14 10:33:34', 0, '0000-00-00 00:00:00'),
(38, 55, 0, 120, 'Its working', '2011-03-14 15:59:56', 0, '0000-00-00 00:00:00'),
(39, 64, 0, 158, 'file uploaded by amit.', '2011-03-16 12:34:12', 0, '0000-00-00 00:00:00'),
(40, 98, 0, 167, 'forth file4444', '2011-03-17 10:23:43', 0, '0000-00-00 00:00:00'),
(41, 7, 0, 62, 'dsds', '2011-03-18 12:34:53', 0, '0000-00-00 00:00:00'),
(42, 7, 0, 62, 'ds', '2011-03-18 12:34:57', 0, '0000-00-00 00:00:00'),
(43, 7, 0, 62, 'aaa', '2011-03-18 12:35:01', 0, '0000-00-00 00:00:00'),
(45, 7, 0, 156, 'as', '2011-03-18 12:35:46', 0, '0000-00-00 00:00:00'),
(46, 13, 0, 152, 'm', '2011-03-18 12:40:27', 0, '0000-00-00 00:00:00'),
(49, 7, 0, 156, 'bvc', '2011-03-18 16:05:58', 0, '0000-00-00 00:00:00'),
(51, 67, 0, 183, '   dsfsdfsddfsdghghhghgh nerw textdfgdfgd', '2011-03-22 11:15:46', 0, '0000-00-00 00:00:00'),
(53, 67, 0, 183, 'sadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasdssadsadasdasdasds', '2011-03-22 11:57:55', 0, '0000-00-00 00:00:00'),
(54, 67, 0, 183, 'parvesh sangwan', '2011-03-22 12:51:25', 0, '0000-00-00 00:00:00'),
(55, 67, 0, 183, 'asdasdasdsadasdasd', '2011-03-22 12:52:33', 0, '0000-00-00 00:00:00'),
(56, 111, 0, 182, 'dsfdsfsdfsdfs', '2011-03-22 17:59:36', 0, '0000-00-00 00:00:00'),
(57, 13, 0, 152, 'c1', '2011-03-24 10:51:16', 0, '0000-00-00 00:00:00'),
(59, 147, 0, 207, 'h', '2011-03-28 11:25:27', 0, '0000-00-00 00:00:00'),
(60, 7, 0, 189, 'mmm', '2011-03-29 17:23:50', 0, '0000-00-00 00:00:00'),
(61, 1, 0, 130, 'gdfgdfg', '2011-04-03 19:13:01', 0, '0000-00-00 00:00:00'),
(62, 1, 0, 247, 'jfhfgkhg', '2011-04-03 19:16:06', 0, '0000-00-00 00:00:00'),
(63, 13, 0, 266, 'jhh', '2011-04-04 15:54:02', 0, '0000-00-00 00:00:00'),
(64, 1, 0, 268, 'hiiiiiiiiiii', '2011-04-04 16:32:31', 0, '0000-00-00 00:00:00'),
(65, 1, 0, 268, 'dfgdfg', '2011-04-04 17:02:56', 0, '0000-00-00 00:00:00'),
(66, 13, 0, 298, '0ppp', '2011-04-06 14:40:02', 0, '0000-00-00 00:00:00'),
(67, 270, 0, 340, 'just junk', '2011-06-08 16:26:54', 0, '0000-00-00 00:00:00'),
(68, 270, 0, 344, 'khghjg', '2011-06-08 16:35:11', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbrev` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=275 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `abbrev`, `name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AI', 'Anguilla'),
(8, 'AG', 'Antigua and Barbuda'),
(9, 'AR', 'Argentina'),
(10, 'AM', 'Armenia'),
(11, 'AW', 'Aruba'),
(12, 'AU', 'Australia'),
(13, 'AT', 'Austria'),
(14, 'AZ', 'Azerbaijan'),
(15, 'AP', 'Azores'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BC', 'Barbuda'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BY', 'Belarus'),
(24, 'BJ', 'Benin'),
(25, 'BM', 'Bermuda'),
(26, 'BO', 'Bolivia'),
(27, 'BL', 'Bonaire'),
(28, 'BA', 'Bosnia and Herzegowina'),
(29, 'BW', 'Botswana'),
(30, 'BR', 'Brazil'),
(31, 'VG', 'Virgin Islands (British)'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CE', 'Canary Islands'),
(39, 'CV', 'Cape Verde'),
(40, 'CF', 'Central African Republic'),
(41, 'TD', 'Chad'),
(42, 'NN', 'Channel Islands'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'KY', 'Cayman Islands'),
(48, 'CO', 'Colombia'),
(49, 'CG', 'Congo, People''s Republic Of'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CB', 'Curacao'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'EC', 'Ecuador'),
(61, 'EG', 'Egypt'),
(62, 'SV', 'El Salvador'),
(63, 'EN', 'England'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FO', 'Faroe Islands'),
(69, 'FJ', 'Fiji'),
(70, 'FI', 'Finland'),
(71, 'FR', 'France'),
(72, 'GF', 'French Guiana'),
(73, 'PF', 'French Polynesia'),
(74, 'GA', 'Gabon'),
(75, 'GM', 'Gambia'),
(76, 'GE', 'Georgia'),
(77, 'DE', 'Germany'),
(78, 'GH', 'Ghana'),
(79, 'GI', 'Gibraltar'),
(80, 'GR', 'Greece'),
(81, 'GL', 'Greenland'),
(82, 'GD', 'Grenada'),
(83, 'GP', 'Guadeloupe'),
(84, 'GU', 'Guam'),
(85, 'GT', 'Guatemala'),
(86, 'GN', 'Guinea'),
(87, 'GW', 'Guinea-Bissau'),
(88, 'GY', 'Guyana'),
(89, 'HT', 'Haiti'),
(91, 'HN', 'Honduras'),
(92, 'HK', 'Hong Kong'),
(93, 'HU', 'Hungary'),
(94, 'IS', 'Iceland'),
(95, 'IN', 'India'),
(96, 'ID', 'Indonesia'),
(97, 'IR', 'Iran (Islamic Republic Of)'),
(98, 'IE', 'Ireland'),
(99, 'IL', 'Israel'),
(100, 'IT', 'Italy'),
(101, 'CI', 'Cote D''Ivoire'),
(102, 'JM', 'Jamaica'),
(103, 'JP', 'Japan'),
(104, 'JO', 'Jordan'),
(105, 'KZ', 'Kazakhstan'),
(106, 'KE', 'Kenya'),
(107, 'KI', 'Kiribati'),
(108, 'KR', 'Korea, Republic Of'),
(109, 'KO', 'Kosrae'),
(110, 'KW', 'Kuwait'),
(111, 'KG', 'Kyrgyzstan'),
(112, 'LA', 'Lao People''s Democratic Republic'),
(113, 'LV', 'Latvia'),
(114, 'LB', 'Lebanon'),
(115, 'LS', 'Lesotho'),
(116, 'LR', 'Liberia'),
(117, 'LI', 'Liechtenstein'),
(118, 'LT', 'Lithuania'),
(119, 'LU', 'Luxembourg'),
(120, 'MO', 'Macau'),
(121, 'MK', 'Macedonia, The Former Yugoslav Republic Of'),
(122, 'MG', 'Madagascar'),
(123, 'ME', 'Madeira'),
(124, 'MW', 'Malawi'),
(125, 'MY', 'Malaysia'),
(126, 'MV', 'Maldives'),
(127, 'ML', 'Mali'),
(128, 'MT', 'Malta'),
(129, 'MH', 'Marshall Islands'),
(130, 'MQ', 'Martinique'),
(131, 'MR', 'Mauritania'),
(132, 'MU', 'Mauritius'),
(133, 'MX', 'Mexico'),
(134, 'FM', 'Micronesia, Federated States Of'),
(135, 'MC', 'Monaco'),
(136, 'MS', 'Montserrat'),
(137, 'MA', 'Morocco'),
(138, 'MZ', 'Mozambique'),
(139, 'MM', 'Myanmar'),
(140, 'NA', 'Namibia'),
(141, 'NP', 'Nepal'),
(142, 'NL', 'Netherlands'),
(143, 'AN', 'Netherlands Antilles'),
(144, 'NV', 'Nevis'),
(145, 'NC', 'New Caledonia'),
(146, 'NZ', 'New Zealand'),
(147, 'NI', 'Nicaragua'),
(148, 'NE', 'Niger'),
(149, 'NG', 'Nigeria'),
(150, 'NU', 'Niue'),
(151, 'NF', 'Norfolk Island'),
(152, 'NB', 'Northern Ireland'),
(153, 'MP', 'Northern Mariana Islands'),
(154, 'NO', 'Norway'),
(155, 'OM', 'Oman'),
(156, 'PK', 'Pakistan'),
(157, 'PW', 'Palau'),
(158, 'PA', 'Panama'),
(159, 'PG', 'Papua New Guinea'),
(160, 'PY', 'Paraguay'),
(161, 'PE', 'Peru'),
(162, 'PH', 'Philippines'),
(163, 'PL', 'Poland'),
(164, 'PO', 'Ponape'),
(165, 'PT', 'Portugal'),
(166, 'PR', 'Puerto Rico'),
(167, 'QA', 'Qatar'),
(168, 'RE', 'Reunion'),
(169, 'RO', 'Romania'),
(170, 'RT', 'Rota'),
(171, 'RU', 'Russian Federation'),
(172, 'RW', 'Rwanda'),
(173, 'SS', 'Saba'),
(174, 'SP', 'Saipan'),
(175, 'SM', 'San Marino'),
(176, 'SA', 'Saudi Arabia'),
(177, 'SF', 'Scotland'),
(178, 'SN', 'Senegal'),
(179, 'SC', 'Seychelles'),
(180, 'SL', 'Sierra Leone'),
(181, 'SG', 'Singapore'),
(182, 'SK', 'Slovakia (Slovak Republic)'),
(183, 'SI', 'Slovenia'),
(184, 'SB', 'Solomon Islands'),
(185, 'ZA', 'South Africa'),
(186, 'ES', 'Spain'),
(187, 'LK', 'Sri Lanka'),
(188, 'NT', 'St. Barthelemy'),
(189, 'SW', 'St. Christopher'),
(190, 'SX', 'St. Croix'),
(191, 'EU', 'St. Eustatius'),
(192, 'UV', 'St. John'),
(193, 'KN', 'Saint Kitts and Nevis'),
(194, 'LC', 'Saint Lucia'),
(195, 'MB', 'St. Maarten'),
(196, 'TB', 'St. Martin'),
(197, 'VL', 'St. Thomas'),
(198, 'VC', 'Saint Vincent and The Grenadines'),
(199, 'SD', 'Sudan'),
(200, 'SR', 'Suriname'),
(201, 'SZ', 'Swaziland'),
(202, 'SE', 'Sweden'),
(203, 'CH', 'Switzerland'),
(204, 'SY', 'Syrian Arab Republic'),
(205, 'TA', 'Tahiti'),
(206, 'TW', 'Taiwan'),
(207, 'TJ', 'Tajikistan'),
(208, 'TZ', 'Tanzania, United Republic Of'),
(209, 'TH', 'Thailand'),
(210, 'TI', 'Tinian'),
(211, 'TG', 'Togo'),
(212, 'TO', 'Tonga'),
(213, 'TL', 'East Timor'),
(214, 'TT', 'Trinidad and Tobago'),
(215, 'TU', 'Truk'),
(216, 'TN', 'Tunisia'),
(217, 'TR', 'Turkey'),
(218, 'TM', 'Turkmenistan'),
(219, 'TC', 'Turks and Caicos Islands'),
(220, 'TV', 'Tuvalu'),
(221, 'VI', 'Virgin Islands (U.S.)'),
(222, 'UG', 'Uganda'),
(223, 'UA', 'Ukraine'),
(224, 'UI', 'Union Island'),
(225, 'AE', 'United Arab Emirates'),
(226, 'GB', 'United Kingdom'),
(227, 'UY', 'Uruguay'),
(228, 'UZ', 'Uzbekistan'),
(229, 'VU', 'Vanuatu'),
(230, 'VE', 'Venezuela'),
(231, 'VN', 'Viet Nam'),
(232, 'VR', 'Virgin Gorda'),
(233, 'WK', 'Wake Island'),
(234, 'WL', 'Wales'),
(235, 'WF', 'Wallis and Futuna Islands'),
(236, 'WS', 'Samoa'),
(237, 'YA', 'Yap'),
(238, 'YE', 'Yemen'),
(239, 'YU', 'Yugoslavia'),
(240, 'ZR', 'Zaire'),
(241, 'ZM', 'Zambia'),
(242, 'ZW', 'Zimbabwe'),
(243, 'AF', 'Afghanistan'),
(244, 'AO', 'Angola'),
(245, 'AQ', 'Antarctica'),
(246, 'BT', 'Bhutan'),
(247, 'BV', 'Bouvet Island'),
(248, 'IO', 'British Indian Ocean Territory'),
(249, 'KM', 'Comoros'),
(250, 'CD', 'Congo, Democratic Republic Of (Was Zaire)'),
(251, 'CU', 'Cuba'),
(252, 'FK', 'Falkland Islands (Malvinas)'),
(253, 'FX', 'France, Metropolitan'),
(254, 'TF', 'French Southern Territories'),
(255, 'HM', 'Heard and Mc Donald Islands'),
(256, 'IQ', 'Iraq'),
(257, 'KP', 'Korea, Democratic People''s Republic Of'),
(258, 'LY', 'Libyan Arab Jamahiriya'),
(259, 'YT', 'Mayotte'),
(260, 'MD', 'Moldova, Republic Of'),
(261, 'MN', 'Mongolia'),
(262, 'NR', 'Nauru'),
(263, 'PS', 'Palestinian Territory, Occupied'),
(264, 'PN', 'Pitcairn'),
(265, 'ST', 'Sao Tome and Principe'),
(266, 'SO', 'Somalia'),
(267, 'GS', 'South Georgia and The South Sandwich Islands'),
(268, 'SH', 'St. Helena'),
(269, 'PM', 'St. Pierre and Miquelon'),
(270, 'SJ', 'Svalbard and Jan Mayen Islands'),
(271, 'TK', 'Tokelau'),
(272, 'UM', 'United States Minor Outlying Islands'),
(273, 'VA', 'Vatican City State (Holy See)'),
(274, 'EH', 'Western Sahara');

-- --------------------------------------------------------

--
-- Table structure for table `counts`
--

CREATE TABLE IF NOT EXISTS `counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `dashboard_count` int(11) NOT NULL DEFAULT '0',
  `project_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `counts`
--

INSERT INTO `counts` (`id`, `user_id`, `dashboard_count`, `project_count`) VALUES
(3, 118, 0, 0),
(4, 1, 0, 0),
(5, 7, 0, 0),
(6, 13, 0, 16),
(7, 55, 0, 0),
(8, 56, 0, 0),
(9, 57, 0, 0),
(10, 58, 0, 0),
(11, 59, 0, 0),
(12, 60, 0, 0),
(13, 61, 0, 0),
(14, 62, 0, 0),
(15, 63, 0, 0),
(16, 64, 0, 0),
(17, 65, 0, 0),
(18, 66, 0, 0),
(19, 67, 0, 0),
(20, 68, 0, 0),
(21, 69, 0, 0),
(22, 70, 0, 0),
(23, 72, 0, 0),
(24, 73, 0, 0),
(25, 74, 0, 0),
(26, 75, 0, 0),
(27, 76, 0, 0),
(28, 79, 0, 1),
(29, 82, 0, 0),
(30, 86, 0, 0),
(31, 87, 0, 0),
(32, 88, 0, 0),
(33, 91, 0, 0),
(34, 92, 0, 0),
(35, 95, 0, 0),
(36, 96, 0, 0),
(37, 97, 0, 0),
(38, 98, 0, 0),
(39, 99, 0, 0),
(40, 100, 0, 2),
(41, 103, 0, 0),
(42, 104, 0, 2),
(43, 105, 0, 1),
(44, 106, 0, 0),
(45, 107, 0, 46),
(46, 108, 0, 0),
(47, 109, 0, 45),
(48, 110, 0, 0),
(49, 111, 0, 0),
(50, 112, 0, 0),
(51, 113, 0, 0),
(52, 114, 0, 0),
(53, 115, 0, 0),
(54, 116, 0, 0),
(55, 117, 0, 0),
(56, 118, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL COMMENT '1 for active, 0 for inactive',
  `created` datetime DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `created_by`, `title`, `active`, `created`, `lastmodified`, `admin_id`) VALUES
(1, 1, 'PHP', 0, '2011-02-24 14:39:41', '2011-02-24 20:39:05', 1),
(2, 7, 'Department1', 0, '2011-02-25 10:03:08', '2011-02-25 16:02:28', 7),
(3, 7, 'English', 0, '2011-02-25 10:03:20', '2011-02-25 16:02:41', 7),
(4, 7, 'Maths', 0, '2011-02-25 10:03:31', '2011-02-25 16:02:51', 7),
(7, 7, 'ooo', 0, '2011-03-09 15:29:08', '2011-03-09 21:29:17', 7),
(8, 19, 'computers', 0, '2011-03-09 16:30:27', '2011-03-09 22:30:37', 19),
(9, 17, 'parent', 0, '2011-03-09 16:51:16', '2011-03-09 22:51:26', 17),
(10, 19, ' @@@@@', 0, '2011-03-09 17:01:21', '2011-03-09 23:01:31', 19),
(11, 19, '########d', 0, '2011-03-09 17:02:13', '2011-03-09 23:02:23', 19),
(12, 19, '1234', 0, '2011-03-09 17:05:14', '2011-03-09 23:05:24', 19),
(13, 19, 'mech', 0, '2011-03-09 17:05:33', '2011-03-09 23:05:43', 19),
(14, 7, 'jj', 0, '2011-03-09 17:06:41', '2011-03-09 23:06:51', 7),
(15, 19, 'computers2', 0, '2011-03-09 17:25:16', '2011-03-09 23:25:26', 19),
(16, 33, 'computers', 0, '2011-03-10 10:03:07', '2011-03-10 16:03:25', 33),
(17, 33, 'mech', 0, '2011-03-10 10:44:43', '2011-03-10 16:45:01', 33),
(18, 33, '####', 0, '2011-03-10 11:10:35', '2011-03-10 17:10:53', 33),
(19, 39, 'Music', 0, '2011-03-11 10:00:15', '2011-03-11 16:00:43', 39),
(20, 55, 'Non-Medical', 0, '2011-03-14 16:08:03', '2011-03-14 21:09:05', 55),
(21, 55, 'Medical', 0, '2011-03-14 17:37:17', '2011-03-14 22:38:19', 55),
(22, 55, 'Art', 0, '2011-03-14 18:16:14', '2011-03-14 23:17:16', 55),
(23, 86, 'math', 0, '2011-03-16 11:27:51', '2011-03-16 16:29:11', 86),
(24, 86, 'computers', 0, '2011-03-16 11:28:18', '2011-03-16 16:29:38', 86),
(25, 67, 'computers', 0, '2011-03-16 18:14:11', '2011-03-16 23:15:34', 67),
(27, 55, 'test project', 0, '2011-03-18 15:23:58', '2011-03-18 20:25:41', 55),
(28, 7, 'c', 0, '2011-03-22 14:37:24', '2011-03-22 19:39:48', 7),
(29, 55, 's', 0, '2011-03-23 15:10:37', '2011-03-23 20:13:12', 55),
(30, 92, 'c', 0, '2011-03-23 17:23:38', '2011-03-23 22:26:14', 92),
(31, 92, 'b', 0, '2011-03-23 17:24:40', '2011-03-23 22:27:16', 92),
(32, 67, 'mech', 0, '2011-03-24 10:09:51', '2011-03-24 15:12:34', 67),
(33, 67, 'sdfsd', 0, '2011-03-24 10:10:40', '2011-03-24 15:13:24', 67),
(34, 7, 'c1', 0, '2011-03-25 12:49:28', '2011-03-25 17:52:22', 7),
(35, 128, 'D!', 0, '2011-03-25 15:21:14', '2011-03-25 20:24:10', 128),
(36, 136, 'Dept1', 0, '2011-03-25 16:34:58', '2011-03-25 21:37:54', 136),
(37, 147, 'Gym', 0, '2011-03-28 09:59:07', '2011-03-28 15:02:32', 147),
(38, 147, 'hel', 0, '2011-03-28 11:18:27', '2011-03-28 16:21:52', 147),
(39, 161, 'Music', 0, '2011-03-28 15:55:08', '2011-03-28 20:58:35', 161),
(40, 173, 'Math-EDU', 0, '2011-03-29 10:15:56', '2011-03-29 15:19:31', 173),
(41, 7, 'j', 0, '2011-03-30 09:15:42', '2011-03-30 14:19:27', 7),
(42, 7, ';', 0, '2011-03-30 09:29:29', '2011-03-30 14:33:14', 7),
(43, 67, 'dance', 0, '2011-03-30 11:04:54', '2011-03-30 16:08:40', 67),
(44, 67, 'ece', 0, '2011-03-30 11:05:12', '2011-03-30 16:08:58', 67),
(45, 67, 'cs', 0, '2011-03-30 11:05:29', '2011-03-30 16:09:14', 67),
(46, 67, 'MBA', 0, '2011-03-30 11:05:42', '2011-03-30 16:09:28', 67),
(47, 67, 'yoga', 0, '2011-03-30 11:06:00', '2011-03-30 16:09:46', 67),
(48, 67, 'panga', 0, '2011-03-30 11:06:18', '2011-03-30 16:10:04', 67),
(49, 67, 'workshop', 0, '2011-03-30 11:06:45', '2011-03-30 16:10:31', 67),
(50, 67, 'oiu', 0, '2011-03-30 11:07:31', '2011-03-30 16:11:16', 67),
(51, 67, 'uuu', 0, '2011-03-30 11:07:40', '2011-03-30 16:11:26', 67),
(52, 67, 'yyyy', 0, '2011-03-30 11:07:57', '2011-03-30 16:11:42', 67),
(53, 67, 'tttt', 0, '2011-03-30 11:08:06', '2011-03-30 16:11:52', 67),
(54, 67, 'aaa', 0, '2011-03-30 11:08:21', '2011-03-30 16:12:07', 67),
(55, 67, 'basket', 0, '2011-03-30 11:08:35', '2011-03-30 16:12:20', 67),
(56, 67, 'fun', 0, '2011-03-30 11:08:53', '2011-03-30 16:12:39', 67),
(57, 67, 'games', 0, '2011-03-30 11:09:10', '2011-03-30 16:12:56', 67),
(58, 67, 'health', 0, '2011-03-30 11:09:28', '2011-03-30 16:13:13', 67),
(59, 7, 'k', 0, '2011-03-31 16:36:15', '2011-03-31 21:40:13', 7),
(60, 1, 'Maths', 0, '2011-04-04 20:22:41', '2011-04-05 01:27:22', 1),
(61, 232, 'computers', 0, '2011-04-15 09:56:03', '2011-04-15 15:02:34', 232),
(62, 232, 'mech', 0, '2011-04-15 15:54:32', '2011-04-15 21:01:05', 232),
(64, 247, 'w', 0, '2011-04-25 11:26:48', '2011-04-25 16:35:04', 247),
(65, 1, 'OOPS', 0, '2011-05-19 01:24:49', '2011-05-19 06:24:49', 1),
(66, 1, 'Music', 0, '2011-05-27 12:48:59', '2011-05-27 17:48:59', 1),
(67, 267, 'A1', 0, '2011-05-30 05:02:05', '2011-05-30 10:02:05', 267),
(68, 270, 'Maths', 0, '2011-06-08 16:11:55', '2011-06-08 21:11:55', 270),
(69, 270, 'English', 0, '2011-06-08 16:25:25', '2011-06-08 21:25:25', 270),
(70, 274, 'Department 1', 0, '2011-07-05 05:24:40', '2011-07-05 10:24:40', 274),
(71, 1, 'Art', 0, '2011-07-14 02:10:08', '2011-07-14 07:10:08', 1),
(72, 297, 'Marketing', 0, '2011-07-19 12:28:37', '2011-07-19 17:28:37', 297),
(73, 1, 'Test Department', 0, '2011-09-09 02:09:21', '2011-09-09 07:09:21', 1),
(74, 304, 'Art', 0, '2011-09-09 11:53:07', '2011-09-09 16:53:07', 304),
(75, 304, 'English', 0, '2011-09-10 08:29:20', '2011-09-10 13:29:20', 304);

-- --------------------------------------------------------

--
-- Table structure for table `department_students`
--

CREATE TABLE IF NOT EXISTS `department_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_students_dc` (`department_id`),
  KEY `department_students_user_dc` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `department_students`
--

INSERT INTO `department_students` (`id`, `department_id`, `user_id`, `created_by`, `created`) VALUES
(35, 42, 224, 7, '2011-04-04 17:14:16'),
(36, 42, 225, 7, '2011-04-04 17:14:48'),
(37, 60, 228, 1, '2011-04-04 20:24:26'),
(38, 45, 234, 67, '2011-04-12 11:36:51'),
(41, 61, 238, 232, '2011-04-15 10:32:20'),
(42, 64, 248, 247, '2011-04-25 11:27:20'),
(43, 64, 249, 247, '2011-04-25 11:27:42'),
(44, 64, 250, 247, '2011-04-25 11:47:44'),
(45, 66, 266, 1, '2011-05-27 12:49:45'),
(46, 67, 268, 267, '2011-05-30 05:02:49'),
(47, 68, 280, 270, '2011-06-08 16:24:10'),
(48, 68, 279, 270, '2011-06-08 16:24:28'),
(49, 70, 292, 274, '2011-07-05 05:25:34'),
(50, 72, 298, 297, '2011-07-19 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `department_teachers`
--

CREATE TABLE IF NOT EXISTS `department_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `leader` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `department_teachers_dc` (`department_id`),
  KEY `department_teachers_user_dc` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `department_teachers`
--

INSERT INTO `department_teachers` (`id`, `department_id`, `user_id`, `created_by`, `created`, `leader`) VALUES
(77, 1, 218, 1, '2011-04-01 19:40:11', 1),
(78, 60, 227, 1, '2011-04-04 20:23:41', 1),
(80, 55, 233, 67, '2011-04-13 14:57:17', 0),
(82, 56, 233, 67, '2011-04-13 14:57:54', 0),
(85, 43, 233, 67, '2011-04-13 14:58:45', 0),
(88, 65, 262, 1, '2011-05-19 01:25:10', 1),
(89, 42, 263, 7, '2011-05-20 01:28:59', 0),
(90, 70, 291, 274, '2011-07-05 05:25:10', 0),
(91, 71, 295, 1, '2011-07-14 02:14:01', 1),
(92, 73, 302, 1, '2011-09-09 02:10:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL COMMENT 'foreign key to ''users.id''',
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT 'foreign key to ''file_categories.id''',
  `tags` text,
  `file_type_id` int(11) NOT NULL COMMENT 'foreign key to ''file_types.id''',
  `version_of` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key to ''files.id''',
  `uploaded` datetime DEFAULT NULL,
  `comment` text COMMENT '//File comment will come here',
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=389 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `created_by`, `name`, `file_name`, `size`, `category_id`, `tags`, `file_type_id`, `version_of`, `uploaded`, `comment`, `order`) VALUES
(1, 1, 'Ford Ikon_1298540241.docx', 'Ford Ikon_1298540241.docx', '21658', 0, NULL, 1, 0, '2011-02-24 15:07:25', NULL, NULL),
(2, 4, 'Correct Postures lighting and chair for computer use_1298541077.docx', 'Correct Postures lighting and chair for computer use_1298541077.docx', '543157', 0, NULL, 1, 0, '2011-02-24 15:21:31', NULL, NULL),
(3, 4, 'Developing Web Services Using PHP_1298541227.docx', 'Developing Web Services Using PHP_1298541227.docx', '254010', 0, NULL, 1, 0, '2011-02-24 15:23:54', NULL, NULL),
(5, 7, 'test_1298617524.jpg', 'test_1298617524.jpg', '110386', 0, NULL, 1, 0, '2011-02-25 12:35:29', NULL, NULL),
(6, 8, 'img_1298617575.gif', 'img_1298617575.gif', '8854', 53, 'vcvcvc', 1, 0, '2011-02-25 12:36:17', NULL, NULL),
(7, 8, 'Joomla Project_1298617825.ppt', 'Joomla Project_1298617825.ppt', '284672', 0, NULL, 5, 0, '2011-02-25 12:40:33', NULL, NULL),
(10, 8, 'edit_1298634947.png', 'edit_1298634947.png', '539', 0, NULL, 1, 6, '2011-02-25 17:25:49', NULL, NULL),
(11, 8, 'plus_1298635013.png', 'plus_1298635013.png', '158', 0, NULL, 1, 6, '2011-02-25 17:26:55', NULL, NULL),
(13, 1, 'template1 large_1298640517.jpg', 'template1 large_1298640517.jpg', '126015', 0, NULL, 1, 0, '2011-02-25 18:58:41', NULL, NULL),
(14, 8, 'screenshot 1_1298954336.png', 'screenshot 1_1298954336.png', '94989', 0, NULL, 1, 0, '2011-03-01 10:09:01', NULL, NULL),
(15, 7, 'template20 large_1298957895.jpg', 'template20 large_1298957895.jpg', '192512', 0, NULL, 1, 0, '2011-03-01 11:08:21', NULL, NULL),
(16, 8, 'template19 large_1298958652.jpg', 'template19 large_1298958652.jpg', '164527', 0, NULL, 1, 0, '2011-03-01 11:20:57', NULL, NULL),
(17, 8, 'template12 large_1298960051.jpg', 'template12 large_1298960051.jpg', '171280', 0, NULL, 1, 0, '2011-03-01 11:44:17', NULL, NULL),
(18, 7, '1281700748_1298981726.jpg', '1281700748_1298981726.jpg', '4927315', 0, NULL, 1, 0, '2011-03-01 17:48:52', NULL, NULL),
(19, 7, 'img_1298985859.gif', 'img_1298985859.gif', '8854', 0, NULL, 1, 0, '2011-03-01 18:54:22', NULL, NULL),
(20, 7, 'img_1299042847.gif', 'img_1299042847.gif', '8854', 0, NULL, 1, 0, '2011-03-02 10:44:09', NULL, NULL),
(21, 7, 'screenshot 1_1299042974.png', 'screenshot 1_1299042974.png', '94989', 0, NULL, 1, 0, '2011-03-02 10:46:18', NULL, NULL),
(23, 7, '1281700748_1299043550.jpg', '1281700748_1299043550.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 10:57:18', NULL, NULL),
(25, 7, 'img_1299044647.gif', 'img_1299044647.gif', '8854', 0, NULL, 1, 23, '2011-03-02 11:14:09', NULL, NULL),
(31, 7, '1281700748_1299048595.jpg', '1281700748_1299048595.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 12:21:24', NULL, NULL),
(32, 8, 'template16 large_1299060555.jpg', 'template16 large_1299060555.jpg', '167928', 0, NULL, 1, 0, '2011-03-02 15:39:22', NULL, NULL),
(33, 8, 'template3 large_1299060631.jpg', 'template3 large_1299060631.jpg', '132301', 0, NULL, 1, 0, '2011-03-02 15:40:37', NULL, NULL),
(34, 8, 'template1 large_1299060647.jpg', 'template1 large_1299060647.jpg', '126015', 0, NULL, 1, 0, '2011-03-02 15:40:52', NULL, NULL),
(35, 8, 'template1 large_1299060833.jpg', 'template1 large_1299060833.jpg', '126015', 0, NULL, 1, 0, '2011-03-02 15:43:58', NULL, NULL),
(36, 8, '1281700748_1299060959.jpg', '1281700748_1299060959.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 15:47:31', NULL, NULL),
(37, 8, '1281700748_1299061352.jpg', '1281700748_1299061352.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 15:54:05', NULL, NULL),
(38, 8, 'Miaow_1299061698.mp3', 'Miaow_1299061698.mp3', '3351325', 0, NULL, 6, 0, '2011-03-02 15:59:21', NULL, NULL),
(39, 7, 'cp_1299062075.jpg', 'cp_1299062075.jpg', '202373', 0, NULL, 1, 0, '2011-03-02 16:04:41', NULL, NULL),
(40, 7, 'thumbnail 23small_1299062092.jpg', 'thumbnail 23small_1299062092.jpg', '292431', 0, NULL, 1, 39, '2011-03-02 16:05:00', NULL, NULL),
(41, 7, 'thumbnail 18small_1299062117.jpg', 'thumbnail 18small_1299062117.jpg', '31344', 0, NULL, 1, 39, '2011-03-02 16:05:20', NULL, NULL),
(42, 7, 'thumbnail 4small_1299062126.jpg', 'thumbnail 4small_1299062126.jpg', '10810', 0, NULL, 1, 39, '2011-03-02 16:05:28', NULL, NULL),
(44, 7, 'subject_1299062563.gif', 'subject_1299062563.gif', '2359350', 45, NULL, 1, 0, '2011-03-02 16:13:28', NULL, NULL),
(45, 8, 'cp_1299063993.jpg', 'cp_1299063993.jpg', '202373', 0, NULL, 1, 0, '2011-03-02 16:36:40', NULL, NULL),
(46, 8, '1281700748_1299064016.jpg', '1281700748_1299064016.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 16:38:26', NULL, NULL),
(47, 8, '1281700748_1299064126.jpg', '1281700748_1299064126.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 16:40:17', NULL, NULL),
(48, 8, '1281700748_1299064229.jpg', '1281700748_1299064229.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 16:41:58', NULL, NULL),
(49, 8, '1281700748_1299064324.jpg', '1281700748_1299064324.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 16:43:34', NULL, NULL),
(50, 8, '1281700748_1299064348.jpg', '1281700748_1299064348.jpg', '4927315', 0, NULL, 1, 0, '2011-03-02 16:43:57', NULL, NULL),
(51, 7, 'screenshot 1_1299064472.png', 'screenshot 1_1299064472.png', '94989', 0, NULL, 1, 0, '2011-03-02 16:44:37', NULL, NULL),
(52, 8, 'cp_1299064486.jpg', 'cp_1299064486.jpg', '202373', 0, NULL, 1, 0, '2011-03-02 16:44:52', NULL, NULL),
(53, 8, 'cp_1299064553.jpg', 'cp_1299064553.jpg', '202373', 0, NULL, 1, 0, '2011-03-02 16:45:59', NULL, NULL),
(54, 7, '1281700748_1299067990.jpg', '1281700748_1299067990.jpg', '4927315', 44, NULL, 1, 0, '2011-03-02 17:44:42', NULL, NULL),
(55, 8, 'concers_1299070541.doc', 'concers_1299070541.doc', '35840', 0, NULL, 2, 0, '2011-03-02 18:25:45', NULL, NULL),
(56, 7, 'rolesmodified_1299129000.JPG', 'rolesmodified_1299129000.JPG', '54999', 0, NULL, 1, 0, '2011-03-03 10:40:05', NULL, NULL),
(57, 7, 'rolesmodified_1299129087.JPG', 'rolesmodified_1299129087.JPG', '54999', 43, NULL, 1, 0, '2011-03-03 10:41:31', NULL, NULL),
(58, 7, 'user img 12930797123_1299129282.gif', 'user img 12930797123_1299129282.gif', '8854', 39, ' fdsfdsf, fkdsfds,f dskfjds ,fds fjkds jfds,fdsk jfds', 1, 0, '2011-03-03 10:44:45', NULL, NULL),
(59, 8, 'template12 large_1299129324.jpg', 'template12 large_1299129324.jpg', '171280', 0, NULL, 1, 0, '2011-03-03 10:45:29', NULL, NULL),
(60, 8, 'template17 large_1299129350.jpg', 'template17 large_1299129350.jpg', '126291', 0, NULL, 1, 0, '2011-03-03 10:45:57', NULL, NULL),
(61, 7, 'screenshot 1_1299145594.png', 'screenshot 1_1299145594.png', '94989', 42, NULL, 1, 0, '2011-03-03 15:16:40', NULL, NULL),
(62, 7, 'template19 large_1299229636.jpg', 'template19 large_1299229636.jpg', '164527', 42, NULL, 1, 0, '2011-03-04 14:37:23', NULL, NULL),
(63, 7, 'plus_1299234667.png', 'plus_1299234667.png', '158', 44, NULL, 1, 0, '2011-03-04 16:01:09', NULL, NULL),
(64, 7, 'template5 large_1299234848.jpg', 'template5 large_1299234848.jpg', '144998', 0, NULL, 1, 0, '2011-03-04 16:04:21', NULL, NULL),
(65, 7, 'concers_1299235630.doc', 'concers_1299235630.doc', '35840', 0, NULL, 2, 0, '2011-03-04 16:17:25', NULL, NULL),
(66, 7, 'manu large_1299237274.jpg', 'manu large_1299237274.jpg', '126015', 0, 'iuyiuy, kyukyu', 1, 0, '2011-03-04 16:44:39', NULL, NULL),
(67, 8, 'AllOnBreak_1299488989.png', 'AllOnBreak_1299488989.png', '6714', 0, NULL, 1, 0, '2011-03-07 14:39:52', NULL, NULL),
(68, 7, 'Changes to the website 28thJan k_1299582930.doc', 'Changes to the website 28thJan k_1299582930.doc', '4', 46, 'fsfsfsfs', 2, 0, '2011-03-08 16:45:34', NULL, NULL),
(70, 7, 'Changes to the website 28thJan Kanwar_1299583917.doc', 'Changes to the website 28thJan Kanwar_1299583917.doc', '4', 0, NULL, 2, 0, '2011-03-08 17:02:00', NULL, NULL),
(71, 8, 'template16 large_1299666482.jpg', 'template16 large_1299666482.jpg', '167928', 0, NULL, 1, 0, '2011-03-09 15:58:09', NULL, NULL),
(72, 17, 'Holiday list 2011_1299669547.pdf', 'Holiday list 2011_1299669547.pdf', '26032', 0, NULL, 4, 0, '2011-03-09 16:49:12', NULL, NULL),
(73, 17, 'Holiday list 2011_1299669587.pdf', 'Holiday list 2011_1299669587.pdf', '26032', 40, 'first tag', 4, 0, '2011-03-09 16:49:50', NULL, NULL),
(74, 17, 'Holiday list 2011_1299669603.pdf', 'Holiday list 2011_1299669603.pdf', '26032', 0, NULL, 4, 73, '2011-03-09 16:50:06', NULL, NULL),
(75, 17, 'New Microsoft Word Document_1299669640.doc', 'New Microsoft Word Document_1299669640.doc', '10752', 0, NULL, 2, 73, '2011-03-09 16:50:43', NULL, NULL),
(76, 8, 'template19_1299669735.jpg', 'template19_1299669735.jpg', '164527', 0, NULL, 1, 0, '2011-03-09 16:52:21', NULL, NULL),
(77, 17, 'Holiday list 2011_1299671130.pdf', 'Holiday list 2011_1299671130.pdf', '26032', 0, NULL, 4, 0, '2011-03-09 17:15:34', NULL, NULL),
(78, 17, 'New Microsoft Word Document_1299675885.doc', 'New Microsoft Word Document_1299675885.doc', '10752', 0, NULL, 2, 0, '2011-03-09 18:34:49', NULL, NULL),
(79, 33, 'DSCN1120_1299730793.JPG', 'DSCN1120_1299730793.JPG', '1704554', 0, NULL, 1, 0, '2011-03-10 09:50:28', NULL, NULL),
(80, 33, 'DSCN1122_1299730828.JPG', 'DSCN1122_1299730828.JPG', '1722974', 0, NULL, 1, 0, '2011-03-10 09:51:00', NULL, NULL),
(81, 8, 'template15 large_1299735884.jpg', 'template15 large_1299735884.jpg', '169255', 0, NULL, 1, 0, '2011-03-10 11:14:55', NULL, NULL),
(82, 8, 'template2 large_1299735916.jpg', 'template2 large_1299735916.jpg', '155531', 0, NULL, 1, 0, '2011-03-10 11:15:21', NULL, NULL),
(83, 8, 'manu large 1299237274_1299736460.jpg', 'manu large 1299237274_1299736460.jpg', '126015', 0, NULL, 1, 0, '2011-03-10 11:24:25', NULL, NULL),
(84, 7, 'template17 large_1299739751.jpg', 'template17 large_1299739751.jpg', '126291', 0, NULL, 1, 63, '2011-03-10 12:19:17', NULL, NULL),
(85, 7, 'template20large_1299739831.jpg', 'template20large_1299739831.jpg', '192512', 0, NULL, 1, 66, '2011-03-10 12:20:31', NULL, NULL),
(86, 33, 'DSCN1121_1299740630.JPG', 'DSCN1121_1299740630.JPG', '1852449', 0, NULL, 1, 0, '2011-03-10 12:34:25', NULL, NULL),
(88, 7, 'template4 large_1299751352.jpg', 'template4 large_1299751352.jpg', '187098', 0, NULL, 1, 68, '2011-03-10 15:32:39', NULL, NULL),
(89, 7, 'template5 large_1299751473.jpg', 'template5 large_1299751473.jpg', '144998', 0, NULL, 1, 68, '2011-03-10 15:34:39', NULL, NULL),
(90, 7, 'manu large_1299753419.jpg', 'manu large_1299753419.jpg', '126015', 0, NULL, 1, 58, '2011-03-10 16:07:04', NULL, NULL),
(92, 33, 'template18 large_1299758425.jpg', 'template18 large_1299758425.jpg', '198413', 0, NULL, 1, 0, '2011-03-10 17:30:32', NULL, NULL),
(94, 35, 'DSCN1118_1299761242.JPG', 'DSCN1118_1299761242.JPG', '1745209', 0, NULL, 1, 0, '2011-03-10 18:17:55', NULL, NULL),
(95, 7, 'template20 large_1299763445.jpg', 'template20 large_1299763445.jpg', '192512', 0, NULL, 1, 61, '2011-03-10 18:54:12', NULL, NULL),
(96, 7, 'template5 large_1299763486.jpg', 'template5 large_1299763486.jpg', '144998', 0, NULL, 1, 58, '2011-03-10 18:54:51', NULL, NULL),
(98, 7, 'template6 large_1299763734.jpg', 'template6 large_1299763734.jpg', '131029', 0, NULL, 1, 54, '2011-03-10 18:58:59', NULL, NULL),
(99, 7, 'manu large_1299764300.jpg', 'manu large_1299764300.jpg', '126015', 48, NULL, 1, 0, '2011-03-10 19:08:25', NULL, NULL),
(100, 7, 'manu large_1299764387.jpg', 'manu large_1299764387.jpg', '126015', 47, NULL, 1, 0, '2011-03-10 19:09:52', NULL, NULL),
(101, 7, 'concers_1299764527.doc', 'concers_1299764527.doc', '35840', 46, NULL, 2, 0, '2011-03-10 19:12:11', NULL, NULL),
(102, 7, 'concers_1299764560.doc', 'concers_1299764560.doc', '35840', 47, NULL, 2, 101, '2011-03-10 19:12:43', NULL, NULL),
(103, 7, 'Referral External Interface Post Only WSv2 HTTP_1299764580.doc', 'Referral External Interface Post Only WSv2 HTTP_1299764580.doc', '203776', 47, NULL, 2, 101, '2011-03-10 19:13:06', NULL, NULL),
(104, 7, 'plan_1299764603.gif', 'plan_1299764603.gif', '242454', 47, NULL, 1, 101, '2011-03-10 19:13:30', NULL, NULL),
(105, 35, 'Petrofsky_1299817115.pdf', 'Petrofsky_1299817115.pdf', '2025052', 0, NULL, 4, 0, '2011-03-11 09:49:12', NULL, NULL),
(106, 39, 'Holiday list 2011_1299817646.pdf', 'Holiday list 2011_1299817646.pdf', '26032', 0, NULL, 4, 0, '2011-03-11 09:57:29', NULL, NULL),
(107, 39, 'Holiday list 2011_1299817669.pdf', 'Holiday list 2011_1299817669.pdf', '26032', 0, NULL, 4, 106, '2011-03-11 09:57:52', NULL, NULL),
(108, 42, 'manu large 1299237274_1299817666.jpg', 'manu large 1299237274_1299817666.jpg', '126015', 49, NULL, 1, 0, '2011-03-11 09:57:52', NULL, NULL),
(110, 42, 'manu large 1299237274_1299818237.jpg', 'manu large 1299237274_1299818237.jpg', '126015', 52, NULL, 1, 0, '2011-03-11 10:07:22', NULL, NULL),
(111, 42, 'btn rpt grey_1299818294.jpg', 'btn rpt grey_1299818294.jpg', '307', 50, NULL, 1, 110, '2011-03-11 10:08:17', NULL, NULL),
(112, 42, 'concers 1299235630_1299818304.doc', 'concers 1299235630_1299818304.doc', '35430', 50, NULL, 2, 110, '2011-03-11 10:08:28', NULL, NULL),
(113, 39, 'New Microsoft Word Document_1299819153.doc', 'New Microsoft Word Document_1299819153.doc', '10752', 0, NULL, 2, 106, '2011-03-11 10:22:36', NULL, NULL),
(114, 8, 'plus 1299234667_1299819758.png', 'plus 1299234667_1299819758.png', '159', 55, NULL, 1, 0, '2011-03-11 10:32:42', NULL, NULL),
(115, 8, 'logo_1299820979.png', 'logo_1299820979.png', '51964', 55, NULL, 1, 0, '2011-03-11 10:53:03', NULL, NULL),
(116, 8, 'manu large 1299237274_1299821128.jpg', 'manu large 1299237274_1299821128.jpg', '126015', 37, NULL, 1, 0, '2011-03-11 10:55:33', NULL, NULL),
(117, 50, 'DesignJava_1299832070.PDF', 'DesignJava_1299832070.PDF', '2293989', 0, NULL, 4, 0, '2011-03-11 13:58:33', NULL, NULL),
(118, 53, 'logo_1299834379.png', 'logo_1299834379.png', '51964', 56, NULL, 1, 0, '2011-03-11 14:36:23', NULL, NULL),
(120, 55, 'New Microsoft Word Document_1300077798.doc', 'New Microsoft Word Document_1300077798.doc', '19968', 58, 'Project Tags', 2, 0, '2011-03-14 10:13:21', NULL, NULL),
(129, 57, 'template20 large_1300096873.jpg', 'template20 large_1300096873.jpg', '192512', 59, NULL, 1, 0, '2011-03-14 15:31:22', NULL, NULL),
(130, 1, 'template19 large_1300097125.jpg', 'template19 large_1300097125.jpg', '164527', 101, NULL, 1, 0, '2011-03-14 15:35:31', NULL, NULL),
(131, 59, 'template19 large_1300097457.jpg', 'template19 large_1300097457.jpg', '164527', 62, NULL, 1, 0, '2011-03-14 15:41:04', NULL, NULL),
(139, 59, 'thumbnail 2small_1300099543.jpg', 'thumbnail 2small_1300099543.jpg', '11551', 61, NULL, 1, 131, '2011-03-14 16:15:45', NULL, NULL),
(140, 59, 'manu large_1300101223.jpg', 'manu large_1300101223.jpg', '126015', 62, NULL, 1, 131, '2011-03-14 16:43:48', NULL, NULL),
(141, 59, 'template19 large_1300101471.jpg', 'template19 large_1300101471.jpg', '164527', 62, NULL, 1, 131, '2011-03-14 16:47:57', NULL, NULL),
(142, 57, 'manu large_1300107307.jpg', 'manu large_1300107307.jpg', '126015', 63, NULL, 1, 0, '2011-03-14 18:25:13', NULL, NULL),
(143, 57, 'template5 large_1300107354.jpg', 'template5 large_1300107354.jpg', '144998', 63, NULL, 1, 142, '2011-03-14 18:25:59', NULL, NULL),
(144, 55, 'WC_1300163831.doc', 'WC_1300163831.doc', '148992', 58, NULL, 2, 120, '2011-03-15 10:07:18', NULL, NULL),
(145, 7, 'Miaow_1300165899.mp3', 'Miaow_1300165899.mp3', '3351325', 47, NULL, 6, 100, '2011-03-15 10:42:41', NULL, NULL),
(146, 7, 'template6_1300166274.jpeg', 'template6_1300166274.jpeg', '131029', 47, NULL, 1, 100, '2011-03-15 10:48:00', NULL, NULL),
(147, 63, 'WC_1300171703.doc', 'WC_1300171703.doc', '148992', 64, NULL, 2, 0, '2011-03-15 12:18:29', NULL, NULL),
(148, 55, 'WC_1300185105.doc', 'WC_1300185105.doc', '148992', 57, NULL, 2, 0, '2011-03-15 16:01:51', NULL, NULL),
(149, 66, 'WC_1300185796.doc', 'WC_1300185796.doc', '148992', 65, NULL, 2, 0, '2011-03-15 16:13:23', NULL, NULL),
(150, 66, 'Mettalica Sad but true_1300185864.mp3', 'Mettalica Sad but true_1300185864.mp3', '4589915', 65, NULL, 6, 0, '2011-03-15 16:15:46', NULL, NULL),
(151, 7, 'concers_1300190435.doc', 'concers_1300190435.doc', '35840', 47, NULL, 2, 0, '2011-03-15 17:30:39', NULL, NULL),
(152, 13, 'concers_1300190537.doc', 'concers_1300190537.doc', '35840', 66, NULL, 2, 0, '2011-03-15 17:32:21', NULL, NULL),
(155, 7, 'template20 large_1300254017.jpg', 'template20 large_1300254017.jpg', '192512', 47, NULL, 1, 0, '2011-03-16 11:10:23', NULL, NULL),
(156, 7, 'template18 large_1300254157.jpg', 'template18 large_1300254157.jpg', '198413', 47, NULL, 1, 0, '2011-03-16 11:12:46', NULL, NULL),
(157, 7, 'thumbnail 7small_1300254541.jpg', 'thumbnail 7small_1300254541.jpg', '10395', 42, NULL, 1, 62, '2011-03-16 11:19:06', NULL, NULL),
(158, 64, 'WC_1300259018.doc', 'WC_1300259018.doc', '148992', 67, NULL, 2, 0, '2011-03-16 12:33:45', NULL, NULL),
(159, 67, 'WayUpArrow_1300259448.gif', 'WayUpArrow_1300259448.gif', '636', 68, NULL, 1, 0, '2011-03-16 12:40:51', NULL, NULL),
(160, 64, 'WC_1300274990.doc', 'WC_1300274990.doc', '148992', 67, NULL, 2, 0, '2011-03-16 16:59:56', NULL, NULL),
(161, 67, 'WayUpArrow_1300280496.gif', 'WayUpArrow_1300280496.gif', '636', 80, NULL, 1, 0, '2011-03-16 18:31:38', NULL, NULL),
(162, 96, 'WC_1300336688.doc', 'WC_1300336688.doc', '148992', 69, NULL, 2, 0, '2011-03-17 10:08:14', NULL, NULL),
(163, 96, 'Mettalica Sad but true_1300336752.mp3', 'Mettalica Sad but true_1300336752.mp3', '4589915', 69, NULL, 6, 0, '2011-03-17 10:10:25', NULL, NULL),
(164, 98, 'New Microsoft Word Document_1300337393.doc', 'New Microsoft Word Document_1300337393.doc', '19968', 71, NULL, 2, 0, '2011-03-17 10:19:56', NULL, NULL),
(165, 98, 'WC_1300337449.doc', 'WC_1300337449.doc', '148992', 72, NULL, 2, 0, '2011-03-17 10:20:53', NULL, NULL),
(166, 98, 'arnav_1300337518.jpg', 'arnav_1300337518.jpg', '55233', 73, NULL, 1, 0, '2011-03-17 10:22:02', NULL, NULL),
(167, 98, 'New Microsoft Word Document 1300077798_1300337558.doc', 'New Microsoft Word Document 1300077798_1300337558.doc', '19971', 74, '4', 2, 0, '2011-03-17 10:22:41', NULL, NULL),
(168, 98, 'New Microsoft Word Document_1300338378.doc', 'New Microsoft Word Document_1300338378.doc', '19968', 70, NULL, 2, 0, '2011-03-17 10:36:21', NULL, NULL),
(169, 55, 'New Microsoft Word Document_1300339403.doc', 'New Microsoft Word Document_1300339403.doc', '19968', 57, NULL, 2, 0, '2011-03-17 10:53:27', NULL, NULL),
(170, 55, 'New Microsoft Word Document_1300339419.doc', 'New Microsoft Word Document_1300339419.doc', '19968', 57, NULL, 2, 0, '2011-03-17 10:53:41', NULL, NULL),
(171, 98, 'WC_1300339569.doc', 'WC_1300339569.doc', '148992', 70, NULL, 2, 0, '2011-03-17 10:56:13', NULL, NULL),
(172, 96, 'WC_1300355347.doc', 'WC_1300355347.doc', '148992', 69, NULL, 2, 0, '2011-03-17 15:19:14', NULL, NULL),
(173, 67, 'DSCN1120_1300426434.jpeg', 'DSCN1120_1300426434.jpeg', '1704554', 78, 'image pdf', 1, 0, '2011-03-18 11:04:24', NULL, NULL),
(174, 107, 'sez_1300426639.doc', 'sez_1300426639.doc', '482304', 75, NULL, 2, 0, '2011-03-18 11:07:30', NULL, NULL),
(175, 67, 'sez_1300429420.doc', 'sez_1300429420.doc', '482304', 68, NULL, 2, 0, '2011-03-18 11:53:51', NULL, NULL),
(176, 67, 'NextArrow_1300680826.gif', 'NextArrow_1300680826.gif', '623', 68, 'picture....', 1, 0, '2011-03-21 09:43:53', NULL, NULL),
(177, 107, 'NextArrow_1300681089.gif', 'NextArrow_1300681089.gif', '623', 75, NULL, 1, 0, '2011-03-21 09:48:12', NULL, NULL),
(179, 67, 'WayUpArrow_1300711606.gif', 'WayUpArrow_1300711606.gif', '636', 68, NULL, 1, 176, '2011-03-21 18:16:49', NULL, NULL),
(180, 111, 'DSCN1123_1300766838.JPG', 'DSCN1123_1300766838.JPG', '1853235', 81, NULL, 1, 0, '2011-03-22 09:37:52', NULL, NULL),
(182, 111, '431757506049011801112006_1300767708.pdf', '431757506049011801112006_1300767708.pdf', '72997', 77, 'pkl', 4, 0, '2011-03-22 09:51:52', NULL, NULL),
(183, 67, 'Petrofsky_1300767757.pdf', 'Petrofsky_1300767757.pdf', '2025052', 79, NULL, 4, 0, '2011-03-22 09:53:59', NULL, NULL),
(184, 7, 'thumbnail 23small_1300790224.jpg', 'thumbnail 23small_1300790224.jpg', '292431', 47, NULL, 1, 0, '2011-03-22 16:07:24', NULL, NULL),
(186, 13, 'New Development Requirements Document OSPEERS 1 0 0 2_1300794842.doc', 'New Development Requirements Document OSPEERS 1 0 0 2_1300794842.doc', '571392', 66, NULL, 2, 0, '2011-03-22 17:24:14', NULL, NULL),
(188, 7, '3_1300942931.gif', '3_1300942931.gif', '53359', 47, NULL, 1, 0, '2011-03-24 10:32:15', NULL, NULL),
(190, 13, '2_1300946681.gif', '2_1300946681.gif', '55969', 66, NULL, 1, 0, '2011-03-24 11:34:45', NULL, NULL),
(192, 92, 'Blue hills_1301042821.jpg', 'Blue hills_1301042821.jpg', '28521', 83, NULL, 1, 0, '2011-03-25 14:17:05', NULL, NULL),
(193, 104, 'Blue hills_1301042946.jpg', 'Blue hills_1301042946.jpg', '28521', 85, NULL, 1, 0, '2011-03-25 14:19:09', NULL, NULL),
(194, 128, 'WC_1301043830.doc', 'WC_1301043830.doc', '148992', 87, NULL, 2, 0, '2011-03-25 14:33:56', NULL, NULL),
(195, 128, 'New Microsoft Word Document_1301043962.doc', 'New Microsoft Word Document_1301043962.doc', '19968', 87, NULL, 2, 194, '2011-03-25 14:36:05', NULL, NULL),
(196, 128, 'WC_1301044011.doc', 'WC_1301044011.doc', '148992', 86, NULL, 2, 0, '2011-03-25 14:36:56', NULL, NULL),
(197, 137, 'WC_1301054855.doc', 'WC_1301054855.doc', '148992', 88, NULL, 2, 0, '2011-03-25 17:37:42', NULL, NULL),
(198, 137, 'New Microsoft Word Document_1301054868.doc', 'New Microsoft Word Document_1301054868.doc', '19968', 88, NULL, 2, 0, '2011-03-25 17:37:50', NULL, NULL),
(199, 137, 'New Microsoft Word Document_1301054933.doc', 'New Microsoft Word Document_1301054933.doc', '19968', 88, NULL, 2, 197, '2011-03-25 17:38:56', NULL, NULL),
(200, 136, 'WC_1301057661.doc', 'WC_1301057661.doc', '148992', 89, NULL, 2, 0, '2011-03-25 18:24:27', NULL, NULL),
(201, 136, 'New Microsoft Word Document_1301057770.doc', 'New Microsoft Word Document_1301057770.doc', '19968', 89, NULL, 2, 0, '2011-03-25 18:26:13', NULL, NULL),
(202, 136, 'WC _1301060633.doc', 'WC _1301060633.doc', '148992', 89, NULL, 2, 0, '2011-03-25 19:14:00', NULL, NULL),
(203, 136, 'WC _1301060762.doc', 'WC _1301060762.doc', '148992', 89, NULL, 2, 0, '2011-03-25 19:16:08', NULL, NULL),
(204, 147, 'WC _1301287348.doc', 'WC _1301287348.doc', '148992', 90, NULL, 2, 0, '2011-03-28 10:12:35', NULL, NULL),
(205, 147, 'WC _1301287390.doc', 'WC _1301287390.doc', '148992', 93, NULL, 2, 0, '2011-03-28 10:13:16', NULL, NULL),
(206, 141, 'WC _1301287611.doc', 'WC _1301287611.doc', '148992', 91, NULL, 2, 0, '2011-03-28 10:16:57', NULL, NULL),
(207, 147, 'WC _1301289442.doc', 'WC _1301289442.doc', '148992', 90, NULL, 2, 0, '2011-03-28 10:47:29', NULL, NULL),
(208, 150, 'WC _1301289873.doc', 'WC _1301289873.doc', '148992', 92, NULL, 2, 0, '2011-03-28 10:54:40', NULL, NULL),
(209, 150, 'WC _1301289928.doc', 'WC _1301289928.doc', '148992', 92, NULL, 2, 0, '2011-03-28 10:55:35', NULL, NULL),
(210, 147, 'WC _1301313323.doc', 'WC _1301313323.doc', '148992', 90, NULL, 2, 0, '2011-03-28 17:25:30', NULL, NULL),
(211, 150, 'WC _1301313494.doc', 'WC _1301313494.doc', '148992', 92, NULL, 2, 0, '2011-03-28 17:28:21', NULL, NULL),
(213, 147, 'WC _1301314610.doc', 'WC _1301314610.doc', '148992', 90, NULL, 2, 0, '2011-03-28 17:46:57', NULL, NULL),
(214, 148, 'DJ testo Armin Van Buuren Eternity_1301314778.mp3', 'DJ testo Armin Van Buuren Eternity_1301314778.mp3', '3873631', 94, NULL, 6, 0, '2011-03-28 17:50:54', NULL, NULL),
(215, 150, 'New Microsoft Word Document_1301314973.doc', 'New Microsoft Word Document_1301314973.doc', '19968', 92, NULL, 2, 0, '2011-03-28 17:52:57', NULL, NULL),
(216, 173, 'WC _1301376155.doc', 'WC _1301376155.doc', '148992', 95, NULL, 2, 0, '2011-03-29 10:52:42', NULL, NULL),
(217, 173, 'WC _1301376208.doc', 'WC _1301376208.doc', '148992', 95, NULL, 2, 0, '2011-03-29 10:53:34', NULL, NULL),
(218, 173, 'WC _1301378592.doc', 'WC _1301378592.doc', '148992', 95, NULL, 2, 0, '2011-03-29 11:33:19', NULL, NULL),
(219, 173, 'WC _1301378632.doc', 'WC _1301378632.doc', '148992', 95, NULL, 2, 0, '2011-03-29 11:33:58', NULL, NULL),
(220, 173, 'WC _1301378671.doc', 'WC _1301378671.doc', '148992', 95, NULL, 2, 0, '2011-03-29 11:34:36', NULL, NULL),
(221, 176, 'WC _1301379122.doc', 'WC _1301379122.doc', '148992', 96, NULL, 2, 0, '2011-03-29 11:42:08', NULL, NULL),
(222, 173, 'WC _1301380764.doc', 'WC _1301380764.doc', '148992', 95, NULL, 2, 0, '2011-03-29 12:09:30', NULL, NULL),
(223, 180, 'New Microsoft Word Document_1301380865.doc', 'New Microsoft Word Document_1301380865.doc', '19968', 97, NULL, 2, 0, '2011-03-29 12:11:09', NULL, NULL),
(224, 181, '1281700748 1298981726_1301391139.jpg', '1281700748 1298981726_1301391139.jpg', '4927315', 98, NULL, 1, 0, '2011-03-29 15:04:07', NULL, NULL),
(225, 147, 'WC _1301453590.doc', 'WC _1301453590.doc', '148992', 90, NULL, 2, 0, '2011-03-30 08:23:18', NULL, NULL),
(226, 150, 'New Microsoft Word Document_1301453654.doc', 'New Microsoft Word Document_1301453654.doc', '19968', 92, NULL, 2, 0, '2011-03-30 08:24:18', NULL, NULL),
(227, 67, 'Petrofsky_1301464461.pdf', 'Petrofsky_1301464461.pdf', '2025052', 68, NULL, 4, 0, '2011-03-30 11:25:00', NULL, NULL),
(228, 107, 'sez_1301465146.doc', 'sez_1301465146.doc', '482304', 75, NULL, 2, 0, '2011-03-30 11:36:00', NULL, NULL),
(229, 7, 'p13a_1301474609.jpg', 'p13a_1301474609.jpg', '12805', 47, NULL, 1, 0, '2011-03-30 14:13:34', NULL, NULL),
(230, 7, 'p14_1301474935.png', 'p14_1301474935.png', '61064', 136, NULL, 1, 0, '2011-03-30 14:19:00', NULL, NULL),
(232, 7, '195274 1384616510 4762285 q_1301546314.jpg', '195274 1384616510 4762285 q_1301546314.jpg', '2703', 135, NULL, 1, 0, '2011-03-31 10:08:42', NULL, NULL),
(233, 7, '195274 1384616510 4762285 q_1301555185.jpg', '195274 1384616510 4762285 q_1301555185.jpg', '2703', 46, NULL, 1, 0, '2011-03-31 12:36:32', NULL, NULL),
(234, 147, 'WC _1301563985.doc', 'WC _1301563985.doc', '148992', 90, NULL, 2, 0, '2011-03-31 15:03:13', NULL, NULL),
(235, 7, 'thumbnail_1301564402.jpeg', 'thumbnail_1301564402.jpeg', '292431', 102, NULL, 1, 0, '2011-03-31 15:10:11', NULL, NULL),
(236, 200, 'thumbnail_1301566262.jpeg', 'thumbnail_1301566262.jpeg', '292431', 99, NULL, 1, 0, '2011-03-31 15:41:11', NULL, NULL),
(237, 13, 'thumbnail_1301566319.jpeg', 'thumbnail_1301566319.jpeg', '292431', 66, NULL, 1, 0, '2011-03-31 15:42:08', NULL, NULL),
(238, 67, 'Water lilies_1301576007.jpg', 'Water lilies_1301576007.jpg', '83794', 68, NULL, 1, 0, '2011-03-31 18:23:33', NULL, NULL),
(239, 67, 'Winter_1301576432.jpg', 'Winter_1301576432.jpg', '105542', 68, NULL, 1, 0, '2011-03-31 18:30:38', NULL, NULL),
(240, 67, 'Blue hills_1301576475.jpg', 'Blue hills_1301576475.jpg', '28521', 68, NULL, 1, 0, '2011-03-31 18:31:19', NULL, NULL),
(241, 67, 'Water lilies_1301576513.jpg', 'Water lilies_1301576513.jpg', '83794', 68, NULL, 1, 0, '2011-03-31 18:31:58', NULL, NULL),
(242, 67, 'Winter_1301648001.jpg', 'Winter_1301648001.jpg', '105542', 68, NULL, 1, 0, '2011-04-01 14:23:28', NULL, NULL),
(243, 131, 'Winter_1301648590.jpg', 'Winter_1301648590.jpg', '105542', 100, NULL, 1, 0, '2011-04-01 14:33:16', NULL, NULL),
(244, 67, 'Blue hills_1301650791.jpg', 'Blue hills_1301650791.jpg', '28521', 68, NULL, 1, 0, '2011-04-01 15:09:56', NULL, NULL),
(245, 1, 'g2_1301666889.png', 'g2_1301666889.png', '8005', 122, NULL, 1, 0, '2011-04-01 19:38:14', NULL, NULL),
(246, 1, 'audio player_1301838223.png', 'audio player_1301838223.png', '47543', 60, NULL, 1, 130, '2011-04-03 19:13:49', NULL, NULL),
(249, 7, 'CloudPollen 1301892755664_1301905835.png', 'CloudPollen 1301892755664_1301905835.png', '75636', 131, NULL, 1, 0, '2011-04-04 14:00:42', NULL, NULL),
(250, 7, 'CloudPollen 1301892755664_1301905851.png', 'CloudPollen 1301892755664_1301905851.png', '75636', 130, NULL, 1, 0, '2011-04-04 14:00:56', NULL, NULL),
(251, 7, 'CloudPollen 1301892755664_1301906906.png', 'CloudPollen 1301892755664_1301906906.png', '75636', 129, NULL, 1, 0, '2011-04-04 14:18:31', NULL, NULL),
(253, 7, 'CloudPollen 1301892755664_1301907403.png', 'CloudPollen 1301892755664_1301907403.png', '75636', 120, NULL, 1, 0, '2011-04-04 14:26:47', NULL, NULL),
(254, 1, '1281700748 1298981726_1301907357.jpg', '1281700748 1298981726_1301907357.jpg', '4927315', 128, NULL, 1, 0, '2011-04-04 14:27:27', NULL, NULL),
(255, 7, 'slow_1301907424.gif', 'slow_1301907424.gif', '2359350', 119, NULL, 1, 0, '2011-04-04 14:27:53', NULL, NULL),
(256, 7, 'slow_1301909146.gif', 'slow_1301909146.gif', '2359350', 47, NULL, 1, 46, '2011-04-04 14:56:35', NULL, NULL),
(257, 7, 'slow_1301909210.gif', 'slow_1301909210.gif', '2359350', 47, NULL, 1, 46, '2011-04-04 14:57:36', NULL, NULL),
(258, 7, 'CloudPollen 1301892755664_1301909283.png', 'CloudPollen 1301892755664_1301909283.png', '75636', 47, NULL, 1, 46, '2011-04-04 14:58:08', NULL, NULL),
(259, 13, 'slow_1301911946.gif', 'slow_1301911946.gif', '2359350', 66, NULL, 1, 111, '2011-04-04 15:43:12', NULL, NULL),
(260, 13, 'slow_1301912017.gif', 'slow_1301912017.gif', '2359350', 66, NULL, 1, 111, '2011-04-04 15:44:24', NULL, NULL),
(261, 13, 'CloudPollen 1301892755664_1301912082.png', 'CloudPollen 1301892755664_1301912082.png', '75636', 66, NULL, 1, 1, '2011-04-04 15:44:47', NULL, NULL),
(262, 13, 'slow_1301912113.gif', 'slow_1301912113.gif', '2359350', 66, NULL, 1, 0, '2011-04-04 15:46:00', NULL, NULL),
(263, 13, 'CloudPollen 1301892755664_1301912180.png', 'CloudPollen 1301892755664_1301912180.png', '75636', 66, NULL, 1, 110, '2011-04-04 15:46:25', NULL, NULL),
(264, 13, 'CloudPollen 1301892755664_1301912200.png', 'CloudPollen 1301892755664_1301912200.png', '75636', 66, NULL, 1, 110, '2011-04-04 15:46:44', NULL, NULL),
(265, 13, 'slow_1301912484.gif', 'slow_1301912484.gif', '2359350', 110, NULL, 1, 110, '2011-04-04 15:52:12', NULL, NULL),
(266, 13, 'CloudPollen 1301892755664_1301912622.png', 'CloudPollen 1301892755664_1301912622.png', '75636', 110, NULL, 1, 0, '2011-04-04 15:53:47', NULL, NULL),
(267, 13, 'CloudPollen 1301892755664_1301912694.png', 'CloudPollen 1301892755664_1301912694.png', '75636', 110, NULL, 1, 266, '2011-04-04 15:54:59', NULL, NULL),
(268, 1, 'yoda_1301914537.jpg', 'yoda_1301914537.jpg', '33368', 121, NULL, 1, 0, '2011-04-04 16:25:42', NULL, NULL),
(269, 223, 'php_1301915281.gif', 'php_1301915281.gif', '2523', 112, NULL, 1, 0, '2011-04-04 16:38:05', NULL, NULL),
(270, 1, 'closelabel_1301920576.gif', 'closelabel_1301920576.gif', '979', 101, NULL, 1, 0, '2011-04-04 18:06:21', NULL, NULL),
(271, 1, 'closelabel_1301920645.gif', 'closelabel_1301920645.gif', '979', 118, NULL, 1, 0, '2011-04-04 18:07:29', NULL, NULL),
(272, 1, 'loading_1301920707.gif', 'loading_1301920707.gif', '2767', 116, NULL, 1, 0, '2011-04-04 18:08:30', NULL, NULL),
(273, 1, 'logo_1301920767.png', 'logo_1301920767.png', '3841', 123, NULL, 1, 0, '2011-04-04 18:09:30', NULL, NULL),
(274, 1, 'shadow_1301920807.gif', 'shadow_1301920807.gif', '49', 0, NULL, 1, 0, '2011-04-04 18:10:10', NULL, NULL),
(275, 1, 'shadow_1301920843.gif', 'shadow_1301920843.gif', '49', 0, NULL, 1, 0, '2011-04-04 18:10:47', NULL, NULL),
(276, 1, 'tl_1301920934.png', 'tl_1301920934.png', '132', 101, NULL, 1, 0, '2011-04-04 18:12:17', NULL, NULL),
(277, 67, 'WayUpArrow_1301921530.gif', 'WayUpArrow_1301921530.gif', '636', 68, NULL, 1, 0, '2011-04-04 18:22:14', NULL, NULL),
(278, 223, 'jupiter_1301924307.jpg', 'jupiter_1301924307.jpg', '59871', 113, NULL, 1, 0, '2011-04-04 19:08:33', NULL, NULL),
(279, 223, 'Spirit Mars Rover 01_1301924323.jpg', 'Spirit Mars Rover 01_1301924323.jpg', '23526', 112, NULL, 1, 0, '2011-04-04 19:08:47', NULL, NULL),
(280, 227, '23 November 2009 Moretti Thanks Letter_1301929535.pdf', '23 November 2009 Moretti Thanks Letter_1301929535.pdf', '356626', 115, NULL, 4, 0, '2011-04-04 20:35:47', NULL, NULL),
(281, 1, 'Picture 1_1301952525.png', 'Picture 1_1301952525.png', '662016', 116, NULL, 1, 0, '2011-04-05 02:59:01', NULL, NULL),
(282, 67, 'UpArrow_1301976336.gif', 'UpArrow_1301976336.gif', '76', 68, NULL, 1, 0, '2011-04-05 09:35:42', NULL, NULL),
(283, 67, 'UpArrow_1301977940.gif', 'UpArrow_1301977940.gif', '76', 68, NULL, 1, 0, '2011-04-05 10:02:24', NULL, NULL),
(284, 67, 'UpArrow_1301977968.gif', 'UpArrow_1301977968.gif', '76', 68, NULL, 1, 0, '2011-04-05 10:02:51', NULL, NULL),
(285, 67, 'TrailMapIcon_1301978487.gif', 'TrailMapIcon_1301978487.gif', '636', 68, NULL, 1, 0, '2011-04-05 10:11:30', NULL, NULL),
(286, 67, 'TrailMapIcon_1301978523.gif', 'TrailMapIcon_1301978523.gif', '636', 68, NULL, 1, 0, '2011-04-05 10:12:06', NULL, NULL),
(287, 67, 'Water lilies_1301978707.jpg', 'Water lilies_1301978707.jpg', '83794', 68, NULL, 1, 0, '2011-04-05 10:15:12', NULL, NULL),
(288, 67, 'Winter_1301980705.jpg', 'Winter_1301980705.jpg', '105542', 68, NULL, 1, 0, '2011-04-05 10:48:36', NULL, NULL),
(289, 7, 'slow_1302001312.gif', 'slow_1302001312.gif', '2359350', 44, NULL, 1, 0, '2011-04-05 16:32:42', NULL, NULL),
(291, 7, '1281700748 1298981726_1302002115.jpg', '1281700748 1298981726_1302002115.jpg', '4927315', 132, NULL, 1, 0, '2011-04-05 16:46:51', NULL, NULL),
(292, 67, 'Winter_1302008734.jpg', 'Winter_1302008734.jpg', '105542', 68, NULL, 1, 0, '2011-04-05 18:35:39', NULL, NULL),
(293, 107, 'Winter_1302070330.jpg', 'Winter_1302070330.jpg', '105542', 75, NULL, 1, 0, '2011-04-06 11:42:16', NULL, NULL),
(294, 131, 'Sunset_1302073520.jpg', 'Sunset_1302073520.jpg', '71189', 100, NULL, 1, 0, '2011-04-06 12:35:26', NULL, NULL),
(295, 131, 'Winter_1302073564.jpg', 'Winter_1302073564.jpg', '105542', 100, NULL, 1, 0, '2011-04-06 12:36:09', NULL, NULL),
(296, 7, 'slow_1302079111.gif', 'slow_1302079111.gif', '2359350', 47, NULL, 1, 0, '2011-04-06 14:09:19', NULL, NULL),
(297, 13, 'CloudPollen 1301892755664_1302080359.png', 'CloudPollen 1301892755664_1302080359.png', '75636', 66, NULL, 1, 0, '2011-04-06 14:29:24', NULL, NULL),
(298, 13, 'slow_1302080911.gif', 'slow_1302080911.gif', '2359350', 66, NULL, 1, 0, '2011-04-06 14:39:16', NULL, NULL),
(299, 13, 'slow_1302082911.gif', 'slow_1302082911.gif', '2359350', 66, NULL, 1, 0, '2011-04-06 15:12:36', NULL, NULL),
(300, 67, 'Winter_1302170192.jpg', 'Winter_1302170192.jpg', '105542', 68, NULL, 1, 0, '2011-04-07 15:26:42', NULL, NULL),
(301, 67, 'Water lilies_1302170202.jpg', 'Water lilies_1302170202.jpg', '83794', 68, NULL, 1, 0, '2011-04-07 15:26:47', NULL, NULL),
(305, 95, 'Winter_1302582737.jpg', 'Winter_1302582737.jpg', '105542', 138, NULL, 1, 0, '2011-04-12 10:02:26', NULL, NULL),
(306, 95, 'Water lilies_1302582774.jpg', 'Water lilies_1302582774.jpg', '83794', 76, NULL, 1, 0, '2011-04-12 10:02:59', NULL, NULL),
(307, 95, 'Sunset_1302583966.jpg', 'Sunset_1302583966.jpg', '71189', 139, NULL, 1, 0, '2011-04-12 10:23:36', NULL, NULL),
(308, 67, 'Water lilies_1302598675.jpg', 'Water lilies_1302598675.jpg', '83794', 68, NULL, 1, 0, '2011-04-12 14:28:01', NULL, NULL),
(309, 107, 'Winter_1302610746.jpg', 'Winter_1302610746.jpg', '105542', 75, NULL, 1, 0, '2011-04-12 17:49:12', NULL, NULL),
(310, 107, 'Winter_1302611634.jpg', 'Winter_1302611634.jpg', '105542', 75, NULL, 1, 0, '2011-04-12 18:04:01', NULL, NULL),
(311, 131, 'Water lilies_1302686588.jpg', 'Water lilies_1302686588.jpg', '83794', 100, NULL, 1, 0, '2011-04-13 14:53:14', NULL, NULL),
(312, 232, 'Water lilies_1302860942.jpg', 'Water lilies_1302860942.jpg', '83794', 141, NULL, 1, 0, '2011-04-15 15:19:11', NULL, NULL),
(313, 176, 'Winter_1303108156.jpg', 'Winter_1303108156.jpg', '105542', 96, NULL, 1, 0, '2011-04-18 11:59:23', NULL, NULL),
(314, 131, 'Winter_1303189155.jpg', 'Winter_1303189155.jpg', '105542', 100, NULL, 1, 0, '2011-04-19 10:29:22', NULL, NULL),
(315, 7, 'template20 large_1303367103.jpg', 'template20 large_1303367103.jpg', '192512', 47, NULL, 1, 0, '2011-04-21 11:55:13', NULL, NULL),
(316, 7, 'template18 large_1303367184.jpg', 'template18 large_1303367184.jpg', '198413', 47, NULL, 1, 0, '2011-04-21 11:56:33', NULL, NULL),
(317, 250, 'template20 large_1303713759.jpg', 'template20 large_1303713759.jpg', '192512', 142, NULL, 1, 0, '2011-04-25 12:12:46', NULL, NULL),
(318, 227, 'IMG00094 20110404 1050_1303727360.jpg', 'IMG00094 20110404 1050_1303727360.jpg', '422276', 115, NULL, 1, 0, '2011-04-25 15:59:30', NULL, NULL),
(319, 227, 'pic_1303727376.jpeg', 'pic_1303727376.jpeg', '10370', 143, NULL, 1, 0, '2011-04-25 15:59:39', NULL, NULL),
(320, 7, 'template17 large_1306755923.jpg', 'template17 large_1306755923.jpg', '126291', 47, NULL, 1, 0, '2011-05-30 06:45:24', NULL, NULL),
(321, 7, 'manu large_1306755946.jpg', 'manu large_1306755946.jpg', '126015', 47, NULL, 1, 0, '2011-05-30 06:45:47', NULL, NULL),
(322, 7, 'template7 large_1306755991.jpg', 'template7 large_1306755991.jpg', '124059', 47, NULL, 1, 0, '2011-05-30 06:46:32', NULL, NULL),
(323, 1, 'template10 large_1306756737.jpg', 'template10 large_1306756737.jpg', '152073', 60, NULL, 1, 0, '2011-05-30 06:58:58', NULL, NULL),
(324, 1, 'manageusers_1306760820.html', 'manageusers_1306760820.html', '5528', 60, NULL, 1, 0, '2011-05-30 08:07:01', NULL, NULL),
(325, 226, 'manageusers_1306761374.html', 'manageusers_1306761374.html', '5528', 145, NULL, 1, 0, '2011-05-30 08:16:14', NULL, NULL),
(326, 1, 'Personal Accounts 1_1306855831.doc', 'Personal Accounts 1_1306855831.doc', '577024', 60, NULL, 2, 0, '2011-05-31 10:30:33', NULL, NULL),
(327, 1, 'Personal Accounts 1_1306855900.doc', 'Personal Accounts 1_1306855900.doc', '577024', 60, NULL, 2, 326, '2011-05-31 10:31:42', NULL, NULL),
(328, 1, 'Bingo Lobby v1_1306855917.pdf', 'Bingo Lobby v1_1306855917.pdf', '469942', 60, NULL, 4, 0, '2011-05-31 10:31:59', NULL, NULL),
(329, 1, 'GettingStarted_1306856214.ppt', 'GettingStarted_1306856214.ppt', '1994752', 60, NULL, 5, 0, '2011-05-31 10:37:01', NULL, NULL),
(330, 219, 'Admin_1307107461.png', 'Admin_1307107461.png', '42300', 146, NULL, 1, 0, '2011-06-03 08:24:22', NULL, NULL),
(331, 219, 'logo cb_1307267409.jpg', 'logo cb_1307267409.jpg', '3833', 146, NULL, 1, 0, '2011-06-05 04:50:10', NULL, NULL),
(332, 219, 'footer logo_1307267419.png', 'footer logo_1307267419.png', '3027', 146, NULL, 1, 0, '2011-06-05 04:50:19', NULL, NULL),
(333, 219, 'featured files_1307267493.png', 'featured files_1307267493.png', '174378', 146, NULL, 1, 0, '2011-06-05 04:51:34', NULL, NULL),
(334, 219, 'featured project side_1307267574.png', 'featured project side_1307267574.png', '150863', 146, NULL, 1, 0, '2011-06-05 04:52:55', NULL, NULL),
(335, 219, 'project drop thumb_1307267722.png', 'project drop thumb_1307267722.png', '12130', 146, NULL, 1, 0, '2011-06-05 04:55:23', NULL, NULL),
(336, 266, 'logo_1307280044.png', 'logo_1307280044.png', '6166', 147, NULL, 1, 0, '2011-06-05 08:20:45', NULL, NULL),
(337, 266, 'featured projects_1307280932.png', 'featured projects_1307280932.png', '214325', 147, NULL, 1, 0, '2011-06-05 08:35:33', NULL, NULL),
(338, 219, 'projects home_1307281721.jpg', 'projects home_1307281721.jpg', '158858', 146, NULL, 1, 0, '2011-06-05 08:48:43', NULL, NULL),
(339, 266, 'logo_1307282076.png', 'logo_1307282076.png', '6166', 147, NULL, 1, 0, '2011-06-05 08:54:36', NULL, NULL),
(340, 270, 'b3ie8_1307434324.jpg', 'b3ie8_1307434324.jpg', '603793', 149, 'stuff', 1, 0, '2011-06-07 03:12:08', NULL, NULL),
(341, 270, 'Nini B_1307568399.jpg', 'Nini B_1307568399.jpg', '90826', 148, NULL, 1, 0, '2011-06-08 16:26:40', NULL, NULL),
(342, 270, 'banner btn_1307568439.png', 'banner btn_1307568439.png', '4135', 149, NULL, 1, 340, '2011-06-08 16:27:20', NULL, NULL),
(343, 270, 'Nini B_1307568466.jpg', 'Nini B_1307568466.jpg', '90826', 148, NULL, 1, 341, '2011-06-08 16:27:47', NULL, NULL),
(344, 270, 'Nini B_1307568485.jpg', 'Nini B_1307568485.jpg', '90826', 148, NULL, 1, 0, '2011-06-08 16:28:06', NULL, NULL),
(345, 270, 'Nini B_1307568609.jpg', 'Nini B_1307568609.jpg', '90826', 148, NULL, 1, 344, '2011-06-08 16:30:10', NULL, NULL),
(346, 270, 'Nini B_1307568634.jpg', 'Nini B_1307568634.jpg', '90826', 148, NULL, 1, 344, '2011-06-08 16:30:35', NULL, NULL),
(347, 270, 'Nini B_1307568884.jpg', 'Nini B_1307568884.jpg', '90826', 148, NULL, 1, 344, '2011-06-08 16:34:45', NULL, NULL),
(348, 219, 'file names_1307972724.png', 'file names_1307972724.png', '183602', 146, NULL, 1, 0, '2011-06-13 08:45:27', NULL, NULL),
(349, 1, 'Penguins.jpg', 'Penguins.jpg', '777835', 60, NULL, 1, 0, '2011-06-14 00:08:39', NULL, NULL),
(350, 219, 'file names.png', 'file names.png', '183602', 146, NULL, 1, 0, '2011-06-14 15:11:40', NULL, NULL),
(351, 219, 'update.png', 'update.png', '120575', 150, NULL, 1, 0, '2011-06-14 15:18:55', NULL, NULL),
(352, 1, 'Penguins.jpg', 'Penguins.jpg', '777835', 60, NULL, 1, 0, '2011-06-17 00:25:28', NULL, NULL),
(353, 1, 'Tulips.jpg', 'Tulips.jpg', '620888', 60, NULL, 1, 0, '2011-06-17 00:26:10', NULL, NULL),
(354, 286, 'image002_1309753702.png', 'image002_1309753702.png', '21521', 151, NULL, 1, 0, '2011-07-03 23:28:23', NULL, NULL),
(355, 266, 'pag eror2_1309773235.png', 'pag eror2_1309773235.png', '5172', 147, NULL, 1, 0, '2011-07-04 04:53:56', NULL, NULL),
(356, 266, '1306139994 arrow 000 medium_1309773266.png', '1306139994 arrow 000 medium_1309773266.png', '485', 147, NULL, 1, 0, '2011-07-04 04:54:27', NULL, NULL),
(357, 286, 'Tickets New 1309773686243_1309773699.png', 'Tickets New 1309773686243_1309773699.png', '21971', 151, NULL, 1, 0, '2011-07-04 05:01:39', NULL, NULL),
(358, 286, 'image002_1309773721.png', 'image002_1309773721.png', '21521', 151, NULL, 1, 0, '2011-07-04 05:02:02', NULL, NULL),
(359, 266, 'joinUs_1309774218.jpg', 'joinUs_1309774218.jpg', '11400', 147, NULL, 1, 0, '2011-07-04 05:10:19', NULL, NULL),
(360, 286, '_1309774497.psd', '_1309774497.psd', '36970', 151, NULL, 1, 0, '2011-07-04 05:14:57', NULL, NULL),
(361, 1, 'Penguins_1309787154.jpg', 'Penguins_1309787154.jpg', '777835', 60, NULL, 1, 0, '2011-07-04 08:45:58', NULL, NULL),
(362, 219, 'open item_1309811897.png', 'open item_1309811897.png', '22906', 146, NULL, 1, 0, '2011-07-04 15:38:18', NULL, NULL),
(363, 1, 'jw 0425 designpatterns1_1309842942.jpg', 'jw 0425 designpatterns1_1309842942.jpg', '10036', 60, NULL, 1, 0, '2011-07-05 00:15:43', NULL, NULL),
(364, 274, 'nobtn_1309861344.png', 'nobtn.png', '180248', 152, NULL, 1, 0, '2011-07-05 05:22:25', NULL, NULL),
(365, 274, 'class diagram_1309861367.png', 'class diagram.png', '56872', 152, NULL, 1, 0, '2011-07-05 05:22:48', NULL, NULL),
(366, 274, 'checkbox_1309861445.png', 'checkbox.png', '360', 152, NULL, 1, 0, '2011-07-05 05:24:06', NULL, NULL),
(367, 7, 'checkbox_1309868545.png', 'checkbox.png', '360', 47, NULL, 1, 0, '2011-07-05 07:22:26', NULL, NULL),
(368, 7, 'image002_1309869943.png', 'image002.png', '21521', 47, NULL, 1, 0, '2011-07-05 07:45:44', NULL, NULL),
(369, 266, 'joinUs_1310559214.jpg', 'joinUs.jpg', '11400', 153, NULL, 1, 0, '2011-07-13 07:13:36', NULL, NULL),
(370, 266, 'test_1310559237.html', 'test.html', '7728', 147, NULL, 1, 0, '2011-07-13 07:13:57', NULL, NULL),
(371, 266, 'test_1310559247.html', 'test.html', '7728', 147, NULL, 1, 370, '2011-07-13 07:14:07', NULL, NULL),
(372, 266, 'test_1310559317.html', 'test.html', '7728', 147, NULL, 1, 370, '2011-07-13 07:15:17', NULL, NULL),
(373, 266, 'joinUs_1310559478.jpg', 'joinUs.jpg', '11400', 147, NULL, 1, 0, '2011-07-13 07:17:58', NULL, NULL),
(374, 219, 'test_1310559950.html', 'test.html', '7728', 146, NULL, 1, 0, '2011-07-13 07:25:51', NULL, NULL),
(375, 295, 'R font_1310627725.png', 'R font.png', '68789', 155, NULL, 1, 0, '2011-07-14 02:15:27', NULL, NULL),
(376, 296, 'me2_1311095828.jpg', 'me2.jpg', '30192', 156, NULL, 1, 0, '2011-07-19 12:17:09', NULL, NULL),
(377, 296, 'me_1311095842.jpg', 'me.jpg', '31166', 157, NULL, 1, 0, '2011-07-19 12:17:22', NULL, NULL),
(378, 297, 'hit small_1311096886.png', 'hit small.png', '3844', 158, NULL, 1, 0, '2011-07-19 12:34:47', NULL, NULL),
(379, 297, 'R font_1311096930.png', 'R font.png', '68789', 158, NULL, 1, 0, '2011-07-19 12:35:31', NULL, NULL),
(380, 219, '1312485441683_1314350540.jpg', '1312485441683.jpg', '36208', 146, NULL, 1, 0, '2011-08-26 02:22:20', NULL, NULL),
(381, 304, 'broken link01_1315669303.jpg', 'broken link01.jpg', '677527', 159, NULL, 1, 0, '2011-09-10 08:41:44', NULL, NULL),
(382, 305, 'Sever Requirements_1315669600.doc', 'Sever Requirements.doc', '35328', 160, NULL, 2, 0, '2011-09-10 08:46:40', NULL, NULL),
(383, 305, 'Sever Requirements_1315819923.doc', 'Sever Requirements.doc', '33280', 160, NULL, 2, 0, '2011-09-12 02:32:03', NULL, NULL),
(384, 305, 'usefullinks_1315820547.doc', 'usefullinks.doc', '24064', 160, NULL, 2, 0, '2011-09-12 02:42:27', NULL, NULL),
(385, 305, 'usefullinks_1315821046.docx', 'usefullinks.docx', '24064', 160, NULL, 1, 0, '2011-09-12 02:50:46', NULL, NULL),
(386, 305, 'curator_1315821081.jpg', 'curator.jpg', '41291', 160, NULL, 1, 0, '2011-09-12 02:51:22', NULL, NULL),
(387, 304, 'Doc1_1315822293.doc', 'Doc1.doc', '606720', 159, NULL, 2, 0, '2011-09-12 03:11:33', NULL, NULL),
(388, 304, 'JAON Calls_1315822564.doc', 'JAON Calls.doc', '24576', 159, NULL, 2, 0, '2011-09-12 03:16:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files_categories`
--

CREATE TABLE IF NOT EXISTS `files_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//Uncategorized category',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `files_categories`
--

INSERT INTO `files_categories` (`id`, `created_by`, `title`, `lastmodified`, `default`) VALUES
(1, 13, 'test', '2010-12-15 21:10:46', 0),
(2, 75, 'English', '2010-12-24 22:58:09', 0),
(3, 75, 'Maths', '2010-12-24 22:58:22', 0),
(4, 11, 'hfghgfhgfhgf', '2010-12-30 17:17:06', 0),
(5, 11, 'hfghgfhgfhgf', '2010-12-30 17:17:06', 0),
(6, 11, 'bvcbcvbcv', '2010-12-30 17:17:23', 0),
(7, 11, 'bvcbcvbcv', '2010-12-30 17:17:23', 0),
(8, 11, 'gdfgfdgfdg', '2010-12-30 17:19:23', 0),
(9, 11, 'vvvbvcbcvbcvbcv', '2010-12-30 17:20:10', 0),
(10, 11, 'bvxcbxvxvb', '2010-12-30 17:20:52', 0),
(11, 11, 'vcbcvbcvbcv', '2010-12-30 17:26:14', 0),
(12, 11, 'fxcfcfxcfxf', '2010-12-30 17:27:49', 0),
(13, 11, 'yutyutru', '2010-12-30 17:28:45', 0),
(14, 11, 'xcccvxcxc', '2010-12-30 17:41:53', 0),
(15, 11, 'gfdgdfgdfg''s', '2010-12-30 17:43:01', 0),
(16, 11, 'cvhcvhcvhcv', '2010-12-30 17:43:26', 0),
(17, 11, 'cvhcvhcvhcvhcvhcvhc', '2010-12-30 17:43:30', 0),
(18, 17, '03-01-11', '2011-01-03 19:51:43', 0),
(23, 3, 'c', '2011-01-05 17:27:48', 0),
(24, 3, 'f', '2011-01-05 17:29:12', 0),
(25, 3, 'S', '2011-01-05 17:29:49', 0),
(26, 3, 'TST Category', '2011-01-05 17:30:51', 0),
(27, 3, 'TST Category 2 2 2 2', '2011-01-05 17:31:35', 0),
(28, 3, 'CECK', '2011-01-05 17:32:08', 0),
(29, 3, 'MANU', '2011-01-05 17:37:12', 0),
(30, 3, 'English', '2011-01-05 17:38:10', 0),
(31, 3, 'y', '2011-01-05 17:39:38', 0),
(32, 3, 'ooops', '2011-01-05 17:39:51', 0),
(33, 31, 'Maths', '2011-01-06 01:24:57', 0),
(34, 2, '22222', '2011-01-21 00:24:12', 0),
(35, 31, 'hey', '2011-01-21 22:46:56', 0),
(36, 3, 'ggg', '2011-02-07 21:48:33', 0),
(37, 8, 'c', '2011-02-25 23:26:56', 0),
(38, 8, ' cvcv', '2011-02-25 23:27:07', 0),
(39, 7, 'ss', '2011-03-08 22:44:57', 0),
(40, 17, 'second category', '2011-03-10 17:50:11', 0),
(41, 7, 'Cat1', '2011-03-10 18:29:31', 0),
(42, 7, 'Cat3', '2011-03-10 18:29:45', 0),
(43, 7, 'Cat5', '2011-03-10 18:30:05', 0),
(44, 7, 'Cat6', '2011-03-10 18:30:15', 0),
(45, 7, 'cat7', '2011-03-10 18:30:24', 0),
(46, 7, 'new Category', '2011-03-10 21:44:50', 0),
(47, 7, 'UnCategorized', '2011-03-11 01:08:46', 1),
(48, 7, 'HIII', '2011-03-11 01:15:44', 0),
(50, 42, 'UnCategorized', '2011-03-11 16:07:50', 1),
(51, 42, 'Cat1', '2011-03-11 16:09:25', 0),
(52, 42, 'Cat2', '2011-03-11 16:09:46', 0),
(53, 8, 'UnCategorized', '2011-03-11 16:33:10', 1),
(54, 8, 'jjjj', '2011-03-11 16:45:21', 0),
(55, 8, 'j', '2011-03-11 16:57:50', 0),
(56, 53, 'UnCategorized', '2011-03-11 20:36:53', 1),
(57, 55, 'UnCategorized', '2011-03-14 14:59:47', 1),
(58, 55, 'Project File.', '2011-03-14 15:32:56', 0),
(59, 57, 'UnCategorized', '2011-03-14 20:32:24', 1),
(60, 1, 'UnCategorized', '2011-03-14 20:36:33', 1),
(61, 59, 'UnCategorized', '2011-03-14 20:42:06', 1),
(62, 59, 'TEST', '2011-03-14 20:54:10', 0),
(63, 57, 'TEST', '2011-03-14 23:26:29', 0),
(64, 63, 'UnCategorized', '2011-03-15 17:19:40', 1),
(65, 66, 'UnCategorized', '2011-03-15 21:14:35', 1),
(66, 13, 'UnCategorized', '2011-03-15 22:33:33', 1),
(67, 64, 'UnCategorized', '2011-03-16 17:35:05', 1),
(68, 67, 'UnCategorized', '2011-03-16 17:42:12', 1),
(69, 96, 'UnCategorized', '2011-03-17 15:09:45', 1),
(70, 98, 'UnCategorized', '2011-03-17 15:21:26', 1),
(71, 98, 'NEW CATEGORY', '2011-03-17 15:22:01', 0),
(72, 98, 'second cate', '2011-03-17 15:23:16', 0),
(73, 98, 'Third', '2011-03-17 15:23:48', 0),
(74, 98, 'forth', '2011-03-17 15:24:35', 0),
(75, 107, 'UnCategorized', '2011-03-18 16:09:11', 1),
(76, 95, 'UnCategorized', '2011-03-21 17:08:30', 1),
(77, 111, 'UnCategorized', '2011-03-22 14:40:14', 1),
(78, 67, 'PDF file', '2011-03-22 18:44:46', 0),
(79, 67, 'long pdf file', '2011-03-22 18:46:22', 0),
(80, 67, 'new', '2011-03-22 19:27:08', 0),
(81, 111, 'new', '2011-03-22 19:36:14', 0),
(82, 111, 'pdf', '2011-03-22 19:37:15', 0),
(83, 92, 'UnCategorized', '2011-03-23 22:39:05', 1),
(85, 104, 'UnCategorized', '2011-03-25 19:22:04', 1),
(86, 128, 'UnCategorized', '2011-03-25 19:36:51', 1),
(87, 128, 'test', '2011-03-25 19:38:48', 0),
(88, 137, 'UnCategorized', '2011-03-25 22:40:39', 1),
(89, 136, 'UnCategorized', '2011-03-25 23:27:24', 1),
(90, 147, 'UnCategorized', '2011-03-28 15:16:00', 1),
(91, 141, 'UnCategorized', '2011-03-28 15:20:22', 1),
(92, 150, 'UnCategorized', '2011-03-28 15:58:05', 1),
(93, 147, 'total', '2011-03-28 19:27:10', 0),
(94, 148, 'UnCategorized', '2011-03-28 22:54:22', 1),
(95, 173, 'UnCategorized', '2011-03-29 15:56:18', 1),
(96, 176, 'UnCategorized', '2011-03-29 16:45:44', 1),
(97, 180, 'UnCategorized', '2011-03-29 17:14:44', 1),
(98, 181, 'UnCategorized', '2011-03-29 20:07:44', 1),
(99, 200, 'UnCategorized', '2011-03-31 20:45:09', 1),
(100, 131, 'UnCategorized', '2011-04-01 19:37:24', 1),
(112, 223, 'UnCategorized', '2011-04-04 21:42:45', 1),
(113, 223, 'OOPS', '2011-04-05 00:12:48', 0),
(114, 1, 'Maths', '2011-04-05 01:10:44', 0),
(115, 227, 'UnCategorized', '2011-04-05 01:40:29', 1),
(116, 1, 'Personal', '2011-04-05 08:02:28', 0),
(131, 7, 'gg', '2011-04-05 21:28:42', 0),
(132, 7, 'g', '2011-04-05 21:29:04', 0),
(133, 7, 'v', '2011-04-05 22:35:16', 0),
(134, 7, 's', '2011-04-05 22:40:00', 0),
(135, 7, 'jj', '2011-04-05 22:40:34', 0),
(136, 7, 'l', '2011-04-05 23:03:03', 0),
(137, 67, 'winter', '2011-04-08 23:47:28', 0),
(138, 95, 'png images', '2011-04-11 16:23:00', 0),
(139, 95, '  asdasd', '2011-04-11 23:50:30', 0),
(140, 131, 'sadsa', '2011-04-13 19:04:33', 0),
(141, 232, 'UnCategorized', '2011-04-15 20:25:45', 1),
(142, 250, 'UnCategorized', '2011-04-25 17:21:02', 1),
(143, 227, 'Sheree', '2011-04-25 21:11:07', 0),
(144, 227, 'Lesson 2', '2011-04-25 21:15:48', 0),
(145, 226, 'UnCategorized', '2011-05-30 13:16:14', 1),
(146, 219, 'UnCategorized', '2011-06-03 13:24:22', 1),
(147, 266, 'UnCategorized', '2011-06-05 13:20:45', 1),
(148, 270, 'UnCategorized', '2011-06-07 08:12:08', 1),
(149, 270, 'Maths', '2011-06-08 21:26:15', 0),
(150, 219, 'dsfsdf', '2011-07-01 16:03:10', 0),
(151, 286, 'UnCategorized', '2011-07-04 04:28:23', 1),
(152, 274, 'UnCategorized', '2011-07-05 10:22:25', 1),
(153, 266, 'Jim', '2011-07-13 12:13:49', 0),
(154, 295, 'UnCategorized', '2011-07-14 07:15:27', 1),
(155, 295, 'Personal', '2011-07-14 07:16:47', 0),
(156, 296, 'UnCategorized', '2011-07-19 17:17:09', 1),
(157, 296, 'pics', '2011-07-19 17:17:41', 0),
(158, 297, 'UnCategorized', '2011-07-19 17:34:47', 1),
(159, 304, 'UnCategorized', '2011-09-10 13:41:44', 1),
(160, 305, 'UnCategorized', '2011-09-10 13:46:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `file_types`
--

CREATE TABLE IF NOT EXISTS `file_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) DEFAULT NULL COMMENT 'jpg, gif, .doc etc',
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `file_types`
--

INSERT INTO `file_types` (`id`, `type`, `icon`) VALUES
(1, 'jpg', 'image.gif'),
(2, 'doc', 'word.gif'),
(3, 'xslx', 'excel.gif'),
(4, 'pdf', 'pdf.gif'),
(5, 'ppt', 'powerpoint.gif'),
(6, 'mp3', 'music.gif'),
(7, 'wav', 'music.gif'),
(8, 'wvi', 'music.gif'),
(9, 'flv', 'media.gif'),
(10, 'mpg', 'media.gif'),
(11, 'mov', 'media.gif'),
(12, 'wmv', 'media.gif'),
(13, 'rm', 'media.gif'),
(14, 'avi', 'media.gif'),
(15, 'mpg', 'media.gif'),
(16, 'swf', 'media.gif');

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE IF NOT EXISTS `metas` (
  `section` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `keyword` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `metas`
--

INSERT INTO `metas` (`section`, `title`, `keyword`, `description`) VALUES
('home', 'Home', 'Home', 'home'),
('projects', 'Projects', 'create project, update project', 'create project, update project'),
('files', 'Files', 'Manage files, List files, Upload Files', 'Manage files, List files, Upload Files'),
('profile', 'Manage Profile, Memberships', 'Manage Profile', 'Edit your personal details'),
('users', 'Manage Profile', 'Manage Profile', 'Manage Profile'),
('dashboard', 'Dashboard', 'Dashboard', 'Dashboard'),
('yeargroups', 'Manage Class groups, Year Groups', 'Manage Class groups, Year Groups', 'Manage Class groups, Year Groups'),
('whiteboards', 'Whiteboards', 'Share your ideas with friends', 'Share your ideas with friends'),
('yeargroups', 'Manage Class groups, Year Groups', 'Manage Class groups, Year Groups', 'Manage Class groups, Year Groups'),
('whiteboards', 'Whiteboards', 'Share your ideas with friends', 'Share your ideas with friends');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `informed_to` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `text` text,
  `activity_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT '30' COMMENT '//in number of days',
  `space` float unsigned NOT NULL DEFAULT '0',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `package_type` enum('trial','free','regular','unlimited') DEFAULT 'regular',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_type_id` int(11) NOT NULL,
  `unlimited` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `amount`, `duration`, `space`, `isdefault`, `package_type`, `active`, `user_type_id`, `unlimited`) VALUES
(3, 'Free Package - Student', 0, 30, 50, 1, 'free', 1, 5, 0),
(4, 'Free Package - Educator', 0, 30, 20, 1, 'free', 1, 3, 0),
(5, 'Standard Package - Teacher', 20, 30, 60, 0, 'regular', 1, 3, 0),
(6, 'Standard Package - Student', 10, 30, 70, 0, 'regular', 1, 5, 0),
(7, 'Regular Package - Admin', 15, 30, 20, 0, 'regular', 1, 1, 0),
(9, 'Extended PAckage- Admin', 20, 30, 50, 0, 'regular', 1, 1, 0),
(10, 'Trial package - Admin', 0, 30, 20, 1, 'trial', 1, 1, 0),
(11, 'restworld', 0, 30, 0, 0, 'unlimited', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL COMMENT 'Paypal reference id',
  `created` datetime DEFAULT NULL,
  `expiryofsubscription` date DEFAULT NULL,
  `status` enum('pending','completed','declined') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=144 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `amount`, `transaction_id`, `created`, `expiryofsubscription`, `status`) VALUES
(1, 1, 1, 'I-2CA9NPWEG76S', '2011-02-24 14:30:58', '2011-03-26', 'completed'),
(2, 6, 1, 'I-TKWUU8THF6K5', '2011-02-24 17:50:56', '2011-03-26', 'completed'),
(3, 7, 1, 'I-96VAT75UYH3U', '2011-02-24 18:09:01', '2011-03-26', 'completed'),
(4, 7, 1, 'I-96VAT75UYH3U', '2011-02-24 18:13:11', '2011-03-26', 'pending'),
(5, 6, 1, 'I-TKWUU8THF6K5', '2011-02-24 18:13:11', '2011-03-26', 'pending'),
(6, 11, 1, 'I-BXFPUWKPGA7P', '2011-03-01 17:13:50', '2011-03-31', 'completed'),
(7, 11, 1, 'I-BXFPUWKPGA7P', '2011-03-01 17:20:59', '2011-03-31', 'pending'),
(8, 17, 1, 'I-MWC3NAEHMRYE', '2011-03-09 15:29:59', '2011-04-08', 'completed'),
(9, 19, 1, 'I-WJK2TJ0STCC5', '2011-03-09 16:21:27', '2011-04-08', 'completed'),
(10, 19, 1, 'I-WJK2TJ0STCC5', '2011-03-09 17:02:37', '2011-04-08', 'pending'),
(11, 17, 1, 'I-MWC3NAEHMRYE', '2011-03-09 17:02:45', '2011-04-08', 'pending'),
(12, 32, 1, 'I-6C967JEH7N7X', '2011-03-09 17:49:22', '2011-04-08', 'completed'),
(13, 32, 1, 'I-6C967JEH7N7X', '2011-03-09 17:50:40', '2011-04-08', 'pending'),
(14, 33, 1, 'I-GRUM2Y5LPBLP', '2011-03-10 09:48:38', '2011-04-09', 'completed'),
(15, 33, 1, 'I-GRUM2Y5LPBLP', '2011-03-10 16:02:45', '2011-04-09', 'pending'),
(16, 39, 1, 'I-U1FVEXU6277M', '2011-03-11 09:47:31', '2011-04-10', 'completed'),
(17, 40, 1, 'I-3R83W1EE6FNH', '2011-03-11 09:51:12', '2011-05-10', 'completed'),
(18, 41, 1, 'I-RWFNNCRX3UDP', '2011-03-11 09:55:06', '2011-04-10', 'completed'),
(19, 42, 1, 'I-R6FFSKFV7801', '2011-03-11 09:57:02', '2011-05-10', 'completed'),
(20, 52, 1, 'I-B42W9R8EKPUF', '2011-03-11 14:20:07', '2011-04-10', 'completed'),
(21, 53, 1, 'I-HM3BB1JJ7CNM', '2011-03-11 14:24:04', '2011-04-10', 'completed'),
(22, 55, 1, 'I-AK0C01XJ22RL', '2011-03-11 15:34:06', '2011-04-10', 'completed'),
(23, 40, 1, 'I-3R83W1EE6FNH', '2011-03-11 15:53:50', '2011-05-10', 'pending'),
(24, 41, 1, 'I-RWFNNCRX3UDP', '2011-03-11 15:53:50', '2011-04-10', 'pending'),
(25, 39, 1, 'I-U1FVEXU6277M', '2011-03-11 15:53:51', '2011-04-10', 'pending'),
(26, 55, 1, 'I-AK0C01XJ22RL', '2011-03-11 15:57:45', '2011-04-10', 'pending'),
(27, 53, 1, 'I-HM3BB1JJ7CNM', '2011-03-11 15:57:57', '2011-04-10', 'pending'),
(28, 58, 1, 'I-9CD38XMNCRSC', '2011-03-14 15:37:14', '2011-04-13', 'completed'),
(29, 58, 1, 'I-9CD38XMNCRSC', '2011-03-14 15:54:45', '2011-04-13', 'pending'),
(30, 67, 1, 'I-FE75ELGF6WA3', '2011-03-14 17:36:26', '2011-04-13', 'completed'),
(31, 67, 1, 'I-FE75ELGF6WA3', '2011-03-14 17:37:42', '2011-04-13', 'pending'),
(32, 70, 1, 'I-0MVPKNE7TYF4', '2011-03-14 17:47:29', '2011-04-13', 'completed'),
(33, 70, 1, 'I-0MVPKNE7TYF4', '2011-03-14 17:48:34', '2011-04-13', 'pending'),
(34, 73, 1, 'I-BVENUTK0LGU0', '2011-03-15 10:31:54', '2011-04-14', 'completed'),
(35, 74, 1, 'I-2DBTGLPSDB39', '2011-03-15 13:48:09', '2011-04-14', 'completed'),
(36, 75, 1, 'I-GW382WXE058F', '2011-03-15 13:55:52', '2011-04-14', 'completed'),
(37, 76, 1, 'I-79G4F7JHK5UB', '2011-03-15 14:02:33', '2011-04-14', 'completed'),
(38, 79, 1, 'I-71N89DRB85LK', '2011-03-15 14:26:26', '2011-04-14', 'completed'),
(39, 75, 1, 'I-GW382WXE058F', '2011-03-15 15:58:22', '2011-04-14', 'pending'),
(40, 76, 1, 'I-79G4F7JHK5UB', '2011-03-15 15:59:26', '2011-04-14', 'pending'),
(41, 79, 1, 'I-71N89DRB85LK', '2011-03-15 15:59:27', '2011-04-14', 'pending'),
(42, 73, 1, 'I-BVENUTK0LGU0', '2011-03-15 15:59:29', '2011-04-14', 'pending'),
(43, 74, 1, 'I-2DBTGLPSDB39', '2011-03-15 15:59:29', '2011-04-14', 'pending'),
(44, 86, 1, 'I-2XDWFDL0G21K', '2011-03-16 11:27:20', '2011-04-15', 'completed'),
(45, 92, 1, 'I-UWMEKTDL9VB3', '2011-03-16 16:25:27', '2011-05-15', 'completed'),
(46, 92, 1, 'I-UWMEKTDL9VB3', '2011-03-16 16:46:25', '2011-05-15', 'pending'),
(47, 86, 1, 'I-2XDWFDL0G21K', '2011-03-16 16:46:26', '2011-04-15', 'pending'),
(48, 104, 1, 'I-SB0JNSXHBPW2', '2011-03-17 15:03:23', '2011-04-16', 'completed'),
(49, 105, 1, 'I-V1FRY6ML1PHX', '2011-03-17 15:05:23', '2011-04-16', 'completed'),
(50, 105, 1, 'I-V1FRY6ML1PHX', '2011-03-17 16:36:22', '2011-04-16', 'pending'),
(51, 104, 1, 'I-SB0JNSXHBPW2', '2011-03-17 16:36:56', '2011-04-16', 'pending'),
(52, 111, 1, 'I-315UHWK0MTB8', '2011-03-22 09:21:47', '2011-04-21', 'completed'),
(53, 111, 1, 'I-315UHWK0MTB8', '2011-03-22 17:29:18', '2011-04-21', 'pending'),
(54, 115, 1, 'I-W31EH4PSAT5M', '2011-03-23 18:00:45', '2011-04-22', 'completed'),
(55, 116, 1, 'I-TDL3C21WLA8T', '2011-03-23 18:02:25', '2011-04-22', 'completed'),
(56, 115, 1, 'I-W31EH4PSAT5M', '2011-03-23 18:04:18', '2011-04-22', 'pending'),
(57, 117, 1, 'I-P3U93SM7K8V6', '2011-03-23 18:06:55', '2011-04-22', 'completed'),
(58, 118, 1, 'I-7HY2N2J9PDE7', '2011-03-23 18:08:18', '2011-04-22', 'completed'),
(59, 124, 1, 'I-FLK9SHUFX9SJ', '2011-03-24 16:41:52', '2011-04-23', 'completed'),
(60, 125, 1, 'I-40K6P854HKE8', '2011-03-24 16:42:27', '2011-04-23', 'completed'),
(61, 128, 1, 'I-ARX6SC6HKFBG', '2011-03-25 14:30:54', '2011-04-24', 'completed'),
(62, 129, 1, 'I-7MY1WBW87XWA', '2011-03-25 14:36:42', '2011-04-24', 'completed'),
(63, 136, 1, 'I-14DGLDW0WGF0', '2011-03-25 16:34:19', '2011-04-24', 'completed'),
(64, 128, 1, 'I-ARX6SC6HKFBG', '2011-03-25 19:12:51', '2011-04-24', 'pending'),
(65, 129, 1, 'I-7MY1WBW87XWA', '2011-03-25 19:13:00', '2011-04-24', 'pending'),
(66, 136, 1, 'I-14DGLDW0WGF0', '2011-03-25 19:13:00', '2011-04-24', 'pending'),
(67, 147, 1, 'I-899S9B57YGED', '2011-03-28 09:40:36', '2011-04-27', 'completed'),
(68, 161, 1, 'I-AKPMD95V3PFE', '2011-03-28 15:46:13', '2011-04-27', 'completed'),
(69, 162, 1, 'I-GWXXD2J94HEV', '2011-03-28 15:58:43', '2011-04-27', 'completed'),
(70, 173, 1, 'I-TC02RA6MUPR0', '2011-03-29 10:03:28', '2011-05-28', 'completed'),
(71, 177, 1, 'I-XWEX8J2WHLLJ', '2011-03-29 10:29:31', '2011-04-28', 'completed'),
(72, 180, 1, 'I-WP4156ACNEGL', '2011-03-29 12:01:45', '2011-04-28', 'completed'),
(73, 181, 1, 'I-05PNMHACA5PA', '2011-03-29 14:53:15', '2011-04-28', 'completed'),
(74, 182, 1, 'I-9C6WVEPHW8FB', '2011-03-29 16:56:06', '2011-04-28', 'completed'),
(75, 189, 1, 'I-7U42H7D5HFPE', '2011-03-31 10:52:36', '2011-04-30', 'completed'),
(76, 195, 1, 'I-GHS3MJCU129E', '2011-03-31 15:21:23', '2011-04-30', 'completed'),
(77, 196, 1, 'I-BSXSBR02D819', '2011-03-31 15:23:23', '2011-05-30', 'completed'),
(78, 197, 1, 'I-P1B9HGAWRU9F', '2011-03-31 15:25:37', '2011-04-30', 'completed'),
(79, 202, 1, 'I-15NN53GLD3A2', '2011-03-31 16:26:22', '2011-04-30', 'completed'),
(80, 203, 1, 'I-7VDSB3TGLB0P', '2011-03-31 16:32:25', '2011-04-30', 'completed'),
(81, 204, 1, 'I-NHY3FV0DKCAT', '2011-03-31 17:09:43', '2011-04-30', 'completed'),
(82, 206, 1, 'I-BSBTXJBSY6NN', '2011-03-31 18:33:24', '2011-04-30', 'completed'),
(83, 209, 1, 'I-34XRED59FAMG', '2011-04-01 10:42:58', '2011-05-01', 'completed'),
(84, 210, 1, 'I-JAYRDE4W4G4U', '2011-04-01 11:50:04', '2011-05-01', 'completed'),
(85, 19, 1, 'I-WJK2TJ0STCC5', '2011-04-08 19:03:29', '2011-04-08', 'pending'),
(86, 32, 1, 'I-6C967JEH7N7X', '2011-04-08 19:03:44', '2011-04-08', 'pending'),
(87, 33, 1, 'I-GRUM2Y5LPBLP', '2011-04-09 16:57:33', '2011-04-09', 'pending'),
(88, 55, 1, 'I-AK0C01XJ22RL', '2011-04-10 16:40:01', '2011-04-10', 'pending'),
(89, 53, 1, 'I-HM3BB1JJ7CNM', '2011-04-10 16:40:09', '2011-04-10', 'pending'),
(90, 39, 1, 'I-U1FVEXU6277M', '2011-04-10 16:41:06', '2011-04-10', 'pending'),
(91, 41, 1, 'I-RWFNNCRX3UDP', '2011-04-10 16:41:13', '2011-04-10', 'pending'),
(92, 232, 1, 'I-59XDPAY5LK29', '2011-04-11 10:18:17', '2011-06-10', 'completed'),
(93, 232, 1, 'I-59XDPAY5LK29', '2011-04-11 17:01:54', '2011-06-10', 'pending'),
(94, 70, 1, 'I-0MVPKNE7TYF4', '2011-04-13 17:32:58', '2011-04-13', 'pending'),
(95, 58, 1, 'I-9CD38XMNCRSC', '2011-04-13 17:33:04', '2011-04-13', 'pending'),
(96, 75, 1, 'I-GW382WXE058F', '2011-04-14 17:28:43', '2011-04-14', 'pending'),
(97, 76, 1, 'I-79G4F7JHK5UB', '2011-04-14 17:28:45', '2011-04-14', 'pending'),
(98, 79, 1, 'I-71N89DRB85LK', '2011-04-14 17:28:49', '2011-04-14', 'pending'),
(99, 74, 1, 'I-2DBTGLPSDB39', '2011-04-14 17:28:53', '2011-04-14', 'pending'),
(100, 86, 1, 'I-2XDWFDL0G21K', '2011-04-15 17:19:50', '2011-04-15', 'pending'),
(101, 241, 1, 'I-CM5H00BAXC9X', '2011-04-18 10:54:16', '2011-05-18', 'completed'),
(102, 241, 1, 'I-CM5H00BAXC9X', '2011-04-18 18:09:35', '2011-05-18', 'pending'),
(103, 242, 1, 'I-NMDWDLW6KKVT', '2011-04-19 14:57:13', '2011-05-19', 'completed'),
(104, 243, 1, 'I-18PX4M35JHS2', '2011-04-19 15:21:05', '2011-05-19', 'completed'),
(105, 242, 1, 'I-NMDWDLW6KKVT', '2011-04-19 17:33:56', '2011-05-19', 'pending'),
(106, 243, 1, 'I-18PX4M35JHS2', '2011-04-19 17:34:05', '2011-05-19', 'pending'),
(107, 111, 1, 'I-315UHWK0MTB8', '2011-04-21 17:01:47', '2011-04-21', 'pending'),
(108, 118, 1, 'I-7HY2N2J9PDE7', '2011-04-22 17:27:06', '2011-04-22', 'pending'),
(109, 115, 1, 'I-W31EH4PSAT5M', '2011-04-22 17:27:18', '2011-04-22', 'pending'),
(110, 128, 1, 'I-ARX6SC6HKFBG', '2011-04-24 17:00:54', '2011-04-24', 'pending'),
(111, 136, 1, 'I-14DGLDW0WGF0', '2011-04-24 17:01:07', '2011-04-24', 'pending'),
(112, 247, 1, 'I-0VT2UR79UVPW', '2011-04-25 11:26:21', '2011-06-24', 'completed'),
(113, 252, 1, 'I-3SHCWYF6XEU4', '2011-04-25 15:38:31', '2011-05-25', 'completed'),
(115, 253, 1, 'I-R37BR7WEUGY2', '2011-04-25 16:03:13', '2011-06-24', 'completed'),
(116, 254, 1, 'I-A1UKGUW14G9J', '2011-04-25 16:06:31', '2011-06-24', 'completed'),
(117, 252, 1, 'I-3SHCWYF6XEU4', '2011-04-25 17:13:01', '2011-05-25', 'pending'),
(118, 247, 1, 'I-0VT2UR79UVPW', '2011-04-25 17:13:08', '2011-06-24', 'pending'),
(119, 255, 1, 'I-WEX7X8AGDL3N', '2011-04-25 17:50:41', '2011-06-24', 'completed'),
(123, 257, 1, 'I-UBX7GXH0L9HY', '2011-04-25 18:23:08', '2011-05-25', 'completed'),
(124, 258, 1, 'I-HNKWSJ2XRVSD', '2011-04-26 09:59:26', '2011-05-26', 'completed'),
(125, 259, 10, 'I-3FKR4XS6F5VR', '2011-04-26 10:12:22', '2011-06-25', 'completed'),
(126, 260, 0.01, 'I-698V63W4TPU0', '2011-04-26 11:02:27', '2011-05-26', 'completed'),
(127, 254, 1, 'I-A1UKGUW14G9J', '2011-04-26 16:48:18', '2011-06-24', 'pending'),
(128, 32, 1, 'I-6C967JEH7N7X', '2011-05-08 18:08:11', '2011-04-08', 'pending'),
(129, 19, 1, 'I-WJK2TJ0STCC5', '2011-05-08 18:08:12', '2011-04-08', 'pending'),
(130, 261, 20, 'I-TAGM3AXJNU91', '2011-05-09 11:26:52', '2011-06-08', 'completed'),
(131, 40, 1, 'I-3R83W1EE6FNH', '2011-05-10 18:05:04', '2011-05-10', 'pending'),
(132, 53, 1, 'I-HM3BB1JJ7CNM', '2011-05-10 18:05:43', '2011-04-10', 'pending'),
(133, 39, 1, 'I-U1FVEXU6277M', '2011-05-10 18:06:17', '2011-04-10', 'pending'),
(134, 41, 1, 'I-RWFNNCRX3UDP', '2011-05-10 18:06:18', '2011-04-10', 'pending'),
(135, 55, 1, 'I-AK0C01XJ22RL', '2011-05-10 18:07:15', '2011-04-10', 'pending'),
(136, 264, 20, 'I-ERW11411RB0F', '2011-05-20 01:50:35', '2011-06-19', 'completed'),
(137, 265, 20, 'I-9375FFVYVFHS', '2011-05-27 09:12:03', '2011-06-26', 'completed'),
(138, 267, 20, 'I-2X57NAKJ4183', '2011-05-30 04:59:36', '2011-06-29', 'completed'),
(139, 270, 10, 'I-TFSW8G8XFN6W', '2011-05-31 12:49:14', '2011-07-30', 'completed'),
(140, 272, 20, 'I-Y5FBSFH7VDW6', '2011-06-01 01:36:22', '2011-07-01', 'completed'),
(141, 274, 20, 'I-0P030AEEG75A', '2011-06-06 06:32:22', '2011-07-06', 'completed'),
(142, 284, 10, 'I-BUMJ5G652SAW', '2011-07-01 05:02:44', '2011-07-31', 'completed'),
(143, 285, 10, 'I-THUGDU8MVPHP', '2011-07-01 05:28:20', '2011-07-31', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `leader_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `groups` text COMMENT '//comma seperated ids of groups',
  `duedate` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0' COMMENT ' 1-published, 0-drafts, 2-archived',
  `otherUsers` text,
  `whiteboards` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `leader_id`, `created_by`, `admin_id`, `subject_id`, `groups`, `duedate`, `created`, `published`, `otherUsers`, `whiteboards`) VALUES
(1, 'Test Project', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 56, 7, 7, 1, '4,11', '2011-03-11', '2011-03-21 10:30:28', 1, '105', ''),
(2, 'Other Project', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 56, 7, 7, 1, '30,11', '2011-03-29', '2011-03-24 10:41:56', 2, '', ''),
(3, 'manu', 'd', 56, 7, 7, 1, '5,4', '2011-03-24', '2011-03-24 11:33:35', 2, '', ''),
(4, 'Test', 'ff', 92, 92, 92, 30, '52', '2011-03-24', '2011-03-24 16:03:40', 1, '', ''),
(5, 'fdfd', 'fdfd', 56, 7, 7, 1, NULL, '2011-03-29', '2011-03-24 17:40:40', 0, NULL, ''),
(6, 'cvcvc', 'vc', 62, 55, 55, 19, NULL, '2011-03-25', '2011-03-25 12:10:25', 0, NULL, ''),
(7, 'TEST by manu', 'bv', 92, 92, 92, 30, '52', '2011-03-29', '2011-03-25 14:16:52', 1, '104', ''),
(8, 'kk\\k', 'jh', 56, 7, 7, 1, NULL, '2011-03-25', '2011-03-25 15:53:09', 0, NULL, ''),
(9, 'ssss', 'ssss', 137, 136, 136, 34, '54', '2011-03-31', '2011-03-25 18:18:03', 1, '', ''),
(10, 'helloooooo', 'helllooooo', 137, 136, 136, 34, '54', '2011-03-31', '2011-03-25 18:24:04', 1, '', ''),
(11, 'rgqre', 'gqregreh', 138, 136, 136, 35, '54', '2011-03-31', '2011-03-25 18:26:03', 1, '', ''),
(12, '*+#@?><,', 'efvwreh4r', 137, 136, 136, 34, '54', '2011-03-31', '2011-03-25 19:11:31', 1, '', ''),
(13, 'fjrstj', 'jrytkj', 137, 136, 136, 34, '54', '2011-03-31', '2011-03-25 19:15:58', 1, '', ''),
(14, 'Urdu', 'Say hello in urdu', 148, 147, 147, 38, NULL, '2011-03-31', '2011-03-28 10:39:07', 1, NULL, ''),
(15, 'Urdu', 'test entry', 148, 148, 147, 38, '56', '2011-04-29', '2011-03-28 10:45:21', 2, '', ''),
(16, 'uploading task', 'uploading task', 148, 147, 147, 38, '56', '2011-03-31', '2011-03-28 10:47:16', 2, '', ''),
(17, '222222', '2222', 148, 148, 147, 38, '56', '2011-03-31', '2011-03-28 11:14:19', 2, '', ''),
(18, 'ttt', 'tttttt', 149, 147, 147, 37, '56', '2011-03-31', '2011-03-28 11:17:28', 2, '', ''),
(19, 'project ok/not ok', 'hello', 149, 147, 147, 37, '56', '2011-03-31', '2011-03-28 16:54:36', 1, '', ''),
(20, 'hindi grammer', 'hindi bolo', 148, 147, 147, 43, '57', '2011-03-31', '2011-03-28 17:25:13', 2, '', ''),
(21, 'Read and write the chapter 2', 'As per description.', 148, 147, 147, 38, '56', '2011-03-29', '2011-03-28 17:42:47', 2, '', ''),
(22, 'Alzebra', 'brief......chapter 5 (All type of derivation)', 173, 173, 173, 46, NULL, '2011-03-29', '2011-03-29 10:25:02', 0, NULL, ''),
(23, 'Alzebra', 'Alzebra-Math\n\nChapter 3', 173, 173, 173, 46, '59', '2011-03-31', '2011-03-29 10:42:07', 1, '', ''),
(24, 'aaaa', 'aaaa', 173, 173, 173, 46, '59', '2011-03-29', '2011-03-29 10:47:56', 1, '', ''),
(25, 'English', 'Grammer test.', 173, 173, 173, 47, '59', '2011-03-30', '2011-03-29 10:52:26', 1, '', ''),
(26, 'sand', 'sand', 173, 173, 173, 46, '59', '2011-03-30', '2011-03-29 11:33:07', 1, '', ''),
(27, 'faesfwe', 'fwefwef', 173, 173, 173, 46, '59', '2011-03-30', '2011-03-29 11:34:26', 1, '', ''),
(28, 'zcxzzx', 'zxxzczxczx', 173, 173, 173, 46, '', '2011-03-30', '2011-03-29 12:04:31', 2, '180', ''),
(29, 'NEW PROJECT', 'g', 173, 173, 173, 47, '59', '2011-03-30', '2011-03-29 12:09:20', 1, '180', ''),
(30, 'fdsgdsg', 'dsfgqregqreg', 148, 147, 147, 38, '56', '2011-03-31', '2011-03-30 08:22:49', 1, '', ''),
(31, 'ddddddd', 'd', 56, 7, 7, 1, NULL, '2011-03-30', '2011-03-30 09:34:49', 0, NULL, ''),
(32, ';', 'fd', 56, 7, 7, 1, '5', '2011-03-31', '2011-03-30 10:12:44', 1, '', ''),
(33, 'by manu', 's', 173, 173, 173, 46, '59', '2011-03-31', '2011-03-30 10:43:17', 1, '', ''),
(34, 'by manu1', 'd', 173, 173, 173, 46, NULL, '2011-03-31', '2011-03-30 10:46:11', 0, NULL, ''),
(35, 'project title : ds', 'explain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfdexplain ds.........jsdlkfjsdkljfklsdjflsdkjfsdlfsdlfd', 95, 67, 67, 26, '40,44', '2011-03-31', '2011-03-30 11:23:11', 1, '', ''),
(36, 'sss', 'sss', 148, 147, 147, 38, NULL, '2011-03-31', '2011-03-31 15:02:08', 0, NULL, ''),
(37, 'fff', 'fff', 148, 147, 147, 38, NULL, '2011-03-31', '2011-03-31 15:03:00', 0, NULL, ''),
(38, 'bbbb', 'b', 56, 7, 7, 1, '30', '2011-03-31', '2011-03-31 15:04:35', 1, '', ''),
(39, 'bnb', 'nb', 56, 7, 7, 1, NULL, '2011-03-31', '2011-03-31 15:06:01', 0, NULL, ''),
(40, 'sss', 'sss', 148, 147, 147, 38, '56', '2011-03-31', '2011-03-31 15:12:01', 1, '', ''),
(41, 's', 's', 173, 173, 173, 47, '59', '2011-03-31', '2011-03-31 15:18:25', 1, '', ''),
(43, 'asdad', 'asdasdasd', 95, 67, 67, 26, NULL, '2011-03-31', '2011-03-31 16:22:48', 1, NULL, ''),
(44, 'ds', 'ds', 56, 7, 7, 1, NULL, '2011-03-31', '2011-03-31 16:27:29', 0, NULL, ''),
(45, 'project1', 'f', 149, 147, 147, 37, NULL, '2011-03-31', '2011-03-31 17:24:37', 0, NULL, ''),
(46, 'manutest', 'manutest', 173, 173, 173, 46, '59', '2011-03-31', '2011-03-31 17:54:28', 1, '', ''),
(47, 'pro title: linux', 'Brief: discription..........sad.', 95, 67, 67, 26, '40,44,73,81', '2011-04-01', '2011-03-31 18:21:53', 1, '125', ''),
(48, 'pro title: Numerical math', 'what is NM', 108, 67, 67, 61, '40,44,81,73', '2011-03-31', '2011-03-31 18:29:31', 1, '', ''),
(49, 'dsfsd', 'sdfsafas', 171, 67, 67, 60, '40,44,81,73', '2011-03-31', '2011-03-31 18:35:07', 1, '', ''),
(50, 'sdfs', 'fsdfsd', 123, 67, 67, 62, NULL, '2011-03-31', '2011-03-31 19:15:49', 0, NULL, ''),
(51, 'pro tile: linux', 'linux eg should be proprer', 108, 67, 67, 62, '73,81,44,40', '2011-04-02', '2011-04-01 14:22:11', 1, '125,79,197', ''),
(52, 'proj det: nm', ' Brief :details of nm in NM project fgfdgfdgdfgdfgddfgdf', 171, 67, 67, 60, '40,44,73', '2011-04-07', '2011-04-01 15:02:15', 1, '125', ''),
(53, 'sdfsd', 'sdfsdfd', 95, 67, 67, 26, '40,81', '2011-04-04', '2011-04-01 15:03:43', 1, '', ''),
(55, 'New Project', 'The department leader should an educator for that subject also.', 218, 1, 1, 5, '2', '2011-04-27', '2011-04-04 16:24:27', 1, '', ''),
(56, 'fghfgh', 'fghfghf', 262, 1, 1, 75, '86', '2011-04-20', '2011-04-04 20:14:28', 1, '', ''),
(57, 'fsdfsdf', 'dsfdsfsd', 121, 67, 67, 60, '40,44,73', '2011-04-06', '2011-04-05 14:23:12', 1, '', ''),
(58, 'delete', 'asdsadas', 127, 67, 67, 58, NULL, '2011-04-05', '2011-04-05 14:26:42', 0, NULL, ''),
(59, 'delete', 'asdsadas', 127, 67, 67, 58, '40,44', '2011-04-05', '2011-04-05 14:26:45', 1, '', ''),
(60, 'dfgdf', 'gdfgsddfs', 95, 67, 67, 26, '40,44', '2011-04-06', '2011-04-05 14:33:38', 2, '', ''),
(61, 'vcvvvvvvvvvvv', 'vvvv', 56, 7, 7, 2, NULL, '2011-04-12', '2011-04-05 15:44:49', 0, NULL, ''),
(62, 'sadas', 'dasdasd', 95, 67, 67, 26, NULL, '2011-04-05', '2011-04-05 15:45:33', 0, NULL, ''),
(63, 'sadas', 'dasdasd', 95, 67, 67, 26, '40,44', '2011-04-05', '2011-04-05 15:45:35', 2, '', ''),
(64, 'dsfadfasfa', 'fasdfasfasfas', 171, 67, 67, 60, '44,81', '2011-04-06', '2011-04-05 15:48:36', 1, '', ''),
(65, 'gfdhgf', 'hdhdhdhdfg', 127, 67, 67, 58, NULL, '2011-04-06', '2011-04-05 15:49:50', 0, NULL, ''),
(66, 'gfdhgf', 'hdhdhdhdfg', 127, 67, 67, 58, '44,40,73,81', '2011-04-06', '2011-04-05 15:49:51', 1, '', ''),
(67, 'cvbxcvbxc', 'vbxcbxcbxcbxc', 127, 67, 67, 58, '40,44,81', '2011-04-07', '2011-04-05 15:51:10', 1, '125', ''),
(68, 'pro title:demo for marking', 'Brief : demo', 108, 67, 67, 62, '40,44,73,81', '2011-04-07', '2011-04-06 12:42:18', 1, '', ''),
(69, 'demo:fdgdfsgsdfg', 'dfssfdgfsd', 108, 67, 67, 62, '40,44,81', '2011-04-07', '2011-04-06 12:56:01', 1, '', ''),
(70, 'sdsdfsdfsd', 'dsfsdafdasfsdafas', 95, 67, 67, 26, '40,44,73,81', '2011-04-07', '2011-04-07 10:15:03', 1, '', ''),
(71, 'sasssass', 'cvcxvxcvxc', 95, 67, 67, 26, NULL, '2011-04-08', '2011-04-07 14:21:13', 0, NULL, ''),
(72, 'sasssass', 'cvcxvxcvxc', 95, 67, 67, 26, NULL, '2011-04-08', '2011-04-07 14:21:13', 0, NULL, ''),
(73, 'asdasdas', '  fgfsdgsdf', 171, 67, 67, 60, NULL, '2011-04-08', '2011-04-07 14:59:19', 0, NULL, ''),
(74, 'asdasdas', '  fgfsdgsdf', 171, 67, 67, 60, NULL, '2011-04-08', '2011-04-07 14:59:20', 0, NULL, ''),
(75, 'asdasdas', '  fgfsdgsdf', 171, 67, 67, 60, NULL, '2011-04-08', '2011-04-07 14:59:22', 0, NULL, ''),
(76, 'dfghdgh', 'fhfhggdh', 95, 67, 67, 60, NULL, '2011-04-08', '2011-04-07 15:12:06', 0, NULL, ''),
(77, 'ertert', 'retret', 123, 67, 67, 62, '40,44', '2011-04-08', '2011-04-07 16:11:57', 1, '', ''),
(78, 'dsdfsdf', 'sdfsdfsdf', 95, 67, 67, 26, '40,44,73', '2011-04-08', '2011-04-07 17:27:10', 0, '', ''),
(79, 'demo for drafts section', 'drafts (Brief)', 108, 67, 67, 62, '40,44', '2011-04-08', '2011-04-07 17:30:30', 0, '', ''),
(80, 'demo', 'demo brief', 95, 67, 67, 26, '40', '2011-04-08', '2011-04-07 17:41:25', 0, '', ''),
(81, 'gfhgf', 'hghgdfhgfhgf', 127, 67, 67, 62, '40,44', '2011-04-08', '2011-04-07 18:21:10', 1, '', ''),
(82, 'vc', 'vxvxczv', 123, 67, 67, 62, NULL, '2011-04-08', '2011-04-08 11:09:16', 0, NULL, ''),
(83, 'leaving with task', 'leaving with task (Brief)......', 95, 67, 67, 26, NULL, '2011-04-08', '2011-04-08 11:20:40', 0, NULL, ''),
(84, 'dfsd', 'fsdfsdfsd', 95, 95, 67, 26, '40,44,81', '2011-04-11', '2011-04-11 10:42:12', 1, '', ''),
(85, 'dsfds', 'fdsfsdfsdfsdf', 95, 95, 67, 26, NULL, '2011-04-11', '2011-04-11 17:30:03', 0, NULL, ''),
(86, 'asdsa', 'dsadasdas', 95, 67, 67, 26, NULL, '2011-04-12', '2011-04-12 12:07:40', 0, NULL, ''),
(87, 'asdsa', 'dsadasdas', 95, 67, 67, 26, '40,44,73,81', '2011-04-12', '2011-04-12 12:07:47', 1, '', ''),
(88, 'pro title : jsdfjdfsj', 'BRief: sdfsdfds', 95, 67, 67, 26, '40,44,81,73', '2011-04-13', '2011-04-12 14:27:18', 1, '', ''),
(89, 'dfgdf', 'gdfgdfgdf', 108, 67, 67, 60, NULL, '2011-04-13', '2011-04-13 14:56:08', 0, NULL, ''),
(90, 'dfgdf', 'gdfgdfgdf', 108, 67, 67, 60, '40,44', '2011-04-13', '2011-04-13 14:56:13', 1, '', ''),
(91, 'hrhgf', 'hfgdhgh', 120, 67, 67, 70, NULL, '2011-04-14', '2011-04-13 15:06:29', 0, NULL, ''),
(92, 'hrhgf', 'hfgdhgh', 120, 67, 67, 70, '40,44,81,73', '2011-04-14', '2011-04-13 15:06:30', 1, '', ''),
(93, 'sfsdf', 'sdfsdfsdfs', 126, 67, 67, 71, '40,44,81', '2011-04-14', '2011-04-13 15:07:27', 1, '', ''),
(94, 'sdfsdf', 'dfsdfsdfs', 171, 67, 67, 56, '40,44,73', '2011-04-14', '2011-04-13 15:08:17', 1, '', ''),
(95, 'hkhjkhj', 'khjkhjkhjkhjk', 233, 67, 67, 68, '40,44', '2011-04-15', '2011-04-13 15:09:06', 1, '', ''),
(96, 'Project titl: hadfsdahfks', 'Brief : jdsfksdafkasdf', 232, 232, 232, 72, '83', '2011-04-15', '2011-04-15 15:18:18', 1, '', ''),
(97, 'dfdsaf', 'safasdfsdafsa', 232, 232, 232, 72, '83', '2011-04-15', '2011-04-15 15:21:25', 2, '', ''),
(98, 'test', 'w', 218, 1, 1, 5, '86', '2011-06-30', '2011-04-18 09:55:30', 1, '', ''),
(99, 'manu', 'dd', 56, 7, 7, 2, '4', '2011-04-23', '2011-04-21 10:41:14', 0, '', ''),
(100, 'ff', 'ffff', 247, 247, 247, 74, '85', '2011-04-27', '2011-04-25 11:49:07', 0, '', ''),
(101, 'New Project', 'Aenean sit, placerat in magnis egestas aliquet tristique adipiscing augue velit elit ac elit mauris habitasse eu eu, ut vel, non aliquet eu vel ut vut est ridiculus magnis tincidunt augue elementum vel? Dictumst tristique arcu dolor pulvinar et velit, quis ac dolor turpis in natoque nisi porta urna. Aliquam.\n\nPid turpis lorem aenean adipiscing, magna a. Nunc tortor aliquet ac quis! Magnis elit mid parturient dictumst ridiculus enim, augue porttitor, augue lectus odio eu urna, phasellus pid augue, sed ac pid scelerisque, cursus rhoncus placerat pulvinar sit a, nec, urna, sed vel. Aliquet. Est aenean adipiscing massa! Nisi.\n\nRhoncus diam placerat turpis dis! Mattis scelerisque sed velit tristique magnis, risus, scelerisque et arcu nascetur. Ut elit! Nunc ac eros nunc egestas turpis et tristique cras, sed odio pulvinar dolor pulvinar placerat scelerisque in, enim in, magna lectus! Dolor elit ridiculus placerat, rhoncus! Risus enim nisi ultrices urna.', 218, 1, 1, 5, NULL, '2011-05-31', '2011-05-16 02:16:38', 0, NULL, ''),
(102, 'test', 'hhfhv', 218, 1, 1, 5, '86', '2011-05-31', '2011-05-17 05:29:54', 1, '', ''),
(103, 'test project 19-05', ';lkkj ', 262, 1, 1, 75, '87', '2011-05-31', '2011-05-19 02:22:32', 1, '', ''),
(104, 'v', 'v', 56, 7, 7, 1, NULL, '2011-05-25', '2011-05-20 00:59:46', 0, NULL, ''),
(105, 'Jimmy''s super music solo', 'Jimmy has to create a super duper music solo', 262, 1, 1, 75, '88', '2011-05-28', '2011-05-27 12:52:47', 1, '', ''),
(106, 'Integer turpis dolor', 'Integer turpis dolor, blandit et vulputate vel, fermentum ac ligula. Sed suscipit facilisis ipsum ultrices sodales. Cras ut lorem eget nulla auctor dictum. Sed nec ante eros, a viverra nibh. Nulla scelerisque ullamcorper elementum. Cras justo enim, condimentum consequat blandit eget, facilisis non tellus. Donec vitae urna leo. Mauris scelerisque posuere lectus, at posuere dui vulputate vitae. Suspendisse ac lacus odio. Maecenas sagittis dolor ut ipsum ultricies ac consequat tellus pulvinar. Phasellus non eros nulla, id laoreet libero. Nam bibendum lacinia massa, tincidunt mattis libero tempor in. Praesent adipiscing, orci in hendrerit egestas, massa erat fringilla lacus, et ultricies tellus libero eu turpis. Donec non erat orci, sed aliquet nisl. ', 267, 267, 267, 77, NULL, '2011-06-10', '2011-05-30 05:06:36', 0, NULL, ''),
(107, 'p1', 'd', 56, 7, 7, 1, '30', '2011-06-01', '2011-05-30 06:46:23', 1, '', ''),
(108, 'Test Project', 'c', 218, 1, 1, 5, '86,88', '2011-06-06', '2011-05-30 08:14:54', 1, '', ''),
(109, 'Graphic design', 'This is a project on graphic design, it will go through pixels to vectors', 262, 219, 1, 75, '88', '2011-06-30', '2011-06-03 08:23:22', 1, '', ''),
(110, 'Inheritance project', 'The project is create a selection of information that can be submitted to beginners wanting to learn PHP', 218, 219, 1, 5, NULL, '2011-06-29', '2011-06-05 04:49:32', 0, NULL, ''),
(111, 'Another attempt to create a project', 'File upload is not working correctly', 218, 219, 1, 5, '88,86', '2011-06-30', '2011-06-05 04:51:15', 1, '', ''),
(112, 'Great poster design', 'The project is to create a great poster design', 218, 219, 1, 5, '88', '2011-06-30', '2011-06-05 05:06:10', 1, '', ''),
(113, 'A great project', 'sdfsd sdfsdf sdf sdf', 218, 219, 1, 5, '88', '2011-06-21', '2011-06-13 09:04:16', 1, '', ''),
(114, 'project 1', 'this is project 1', 262, 219, 1, 75, '88', '2011-06-22', '2011-06-14 15:11:19', 1, '', ''),
(115, 'project 2', 'project 2', 262, 219, 1, 75, '88', '2011-06-30', '2011-06-14 15:18:42', 1, '', ''),
(116, 'project 3', 'project 3', 262, 219, 1, 75, '88', '2011-06-24', '2011-06-14 15:20:27', 1, '', ''),
(117, 'ccvcvc', 'xcxc', 218, 1, 1, 5, NULL, '2011-06-30', '2011-06-17 01:05:31', 0, NULL, ''),
(118, 'Test Project - English', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occae', 56, 7, 7, 2, '5', '2011-07-02', '2011-06-29 07:03:29', 1, '', ''),
(119, 'Brand New project', 'its about doing it right', 262, 219, 1, 75, NULL, '2011-07-13', '2011-07-01 11:04:03', 0, NULL, ''),
(120, 'A brand new project for my cool students', 'This is what it''s all about', 262, 219, 1, 75, '88,94', '2011-07-31', '2011-07-01 11:21:02', 1, '', ''),
(121, 'Lovely', 'Hey', 262, 219, 1, 75, NULL, '2011-07-29', '2011-07-01 16:22:46', 0, NULL, ''),
(122, 'Lovely', 'Hey', 262, 219, 1, 75, NULL, '2011-07-29', '2011-07-01 16:23:19', 0, NULL, ''),
(123, 'Lovely', 'Hey', 262, 219, 1, 75, NULL, '2011-07-29', '2011-07-01 16:23:19', 0, NULL, ''),
(124, 'Lovely', 'Hey', 262, 219, 1, 75, NULL, '2011-07-29', '2011-07-01 16:23:19', 0, NULL, ''),
(125, 'Lovely', 'Hey', 262, 219, 1, 75, '93', '2011-07-29', '2011-07-01 16:23:20', 1, '', ''),
(126, 'Sweeeet', 'dfsdfsd', 262, 219, 1, 75, '94', '2011-08-30', '2011-07-04 05:29:14', 1, '', ''),
(127, 'Test Issues - 06th July 2011', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas.\n\nmolestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. \n\nEt harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.', 56, 7, 7, 1, NULL, '2011-07-31', '2011-07-06 07:48:45', 0, NULL, ''),
(128, 'Test Project - 6th July', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sin\nt occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi \noptio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.', 56, 7, 7, 1, '5', '2011-07-31', '2011-07-06 07:50:18', 1, '', '0,110,'),
(129, 'Fun fun', 'Asdfsdf', 262, 219, 1, 75, '88', '2011-07-27', '2011-07-06 12:18:47', 0, '', ''),
(130, 'Create an advertising campaign', 'Make the most awesome campaign to make loads of money', 297, 297, 297, 81, NULL, '2011-07-27', '2011-07-19 12:34:31', 0, NULL, ''),
(131, 'Project cloudroom is done', 'Read the doc', 218, 219, 1, 5, '88', '2011-09-30', '2011-09-09 10:44:02', 1, '298', ''),
(132, 'Make a poster design', 'Using photoshop design a great poster', 304, 304, 304, 86, '100', '2011-09-24', '2011-09-10 08:32:45', 1, '', ''),
(133, 'Create a leaflet design', 'Create a great leaflet that goes with your poster using photoshop', 304, 304, 304, 86, '100', '2011-09-23', '2011-09-10 08:41:10', 1, '', ''),
(134, 'TEsted', 't', 56, 7, 7, 1, '', '2011-09-21', '2011-09-14 23:27:37', 1, '100', '');

-- --------------------------------------------------------

--
-- Table structure for table `project_comments`
--

CREATE TABLE IF NOT EXISTS `project_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posted_by` int(11) DEFAULT NULL COMMENT '//user id who has post the comment',
  `project_id` int(11) DEFAULT NULL,
  `received_by` int(11) DEFAULT NULL,
  `admin_ids` varchar(255) DEFAULT NULL COMMENT '//So that comments can be binded to admin also',
  `task_id` int(11) DEFAULT NULL,
  `student_doc_id` int(11) NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '1' COMMENT '//Comment is private or not',
  `comment` text,
  `comment_type` enum('project','task','studentdoc','prjComment') NOT NULL COMMENT 'prjComment if student has posted comment on project',
  `created` datetime DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=287 ;

--
-- Dumping data for table `project_comments`
--

INSERT INTO `project_comments` (`id`, `posted_by`, `project_id`, `received_by`, `admin_ids`, `task_id`, `student_doc_id`, `private`, `comment`, `comment_type`, `created`, `updated_on`) VALUES
(1, 7, 1, NULL, NULL, 1, 0, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'task', '2011-03-24 10:30:52', '2011-06-13 12:47:56'),
(2, 7, 1, NULL, NULL, 2, 0, 1, 'c', 'task', '2011-03-24 10:32:20', '2011-06-13 12:47:56'),
(3, 7, 2, NULL, NULL, 3, 0, 1, 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 'task', '2011-03-24 10:42:13', '2011-06-13 12:47:56'),
(4, 7, 2, NULL, NULL, 4, 0, 1, 'cx', 'task', '2011-03-24 10:42:42', '2011-06-13 12:47:56'),
(5, 13, 1, 56, ',7,7,103,112,', 1, 1, 1, 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 'studentdoc', '2011-03-24 10:43:40', '2011-06-13 12:47:56'),
(6, 13, 2, 56, ',7,7,103,112,', 3, 2, 1, 'ds', 'studentdoc', '2011-03-24 10:45:43', '2011-06-13 12:47:56'),
(10, 92, 4, NULL, NULL, 6, 0, 1, '2', 'task', '2011-03-24 16:03:59', '2011-06-13 12:47:56'),
(11, 92, 7, NULL, NULL, 7, 0, 1, 'TE', 'task', '2011-03-25 14:17:12', '2011-06-13 12:47:56'),
(12, 104, 7, 92, ',92,92,103,112,', 7, 4, 1, 'n', 'studentdoc', '2011-03-25 14:19:55', '2011-06-13 12:47:56'),
(13, 136, 9, NULL, NULL, 8, 0, 1, 'sfsfasfasfas', 'task', '2011-03-25 18:18:31', '2011-06-13 12:47:56'),
(14, 136, 9, NULL, NULL, NULL, 0, 1, 'fhbdfnbaetnqet', 'project', '2011-03-25 18:19:15', '2011-06-13 12:47:56'),
(15, 136, 11, NULL, NULL, 9, 0, 1, '4gfdgrehbetrnbdefnbtrehbetr', 'task', '2011-03-25 18:26:22', '2011-06-13 12:47:56'),
(16, 139, 9, 137, ',136,136,103,112,', 8, 5, 1, 'weryhteykluetykjw', 'studentdoc', '2011-03-25 18:33:38', '2011-06-13 12:47:56'),
(17, 136, 9, NULL, NULL, NULL, 0, 1, 'check one 1 2 3 4 5 6 7 8 9', 'project', '2011-03-25 19:09:06', '2011-06-13 12:47:56'),
(18, 136, 11, NULL, NULL, NULL, 0, 1, '@?hello', 'project', '2011-03-28 10:15:05', '2011-06-13 12:47:56'),
(19, 141, 11, 138, ',136,136,103,112,146,', 9, 6, 1, '@?', 'studentdoc', '2011-03-28 10:17:04', '2011-06-13 12:47:56'),
(20, 147, 15, NULL, NULL, 10, 0, 1, 'check the comment on dashboard#.', 'task', '2011-03-28 10:46:13', '2011-06-13 12:47:56'),
(21, 147, 16, NULL, NULL, 11, 0, 1, 'upload#hello.', 'task', '2011-03-28 10:47:45', '2011-06-13 12:47:56'),
(22, 150, 16, 148, ',147,147,103,112,146,', 11, 7, 1, '@$#_hello. check it out.whether completed or not.', 'studentdoc', '2011-03-28 10:55:23', '2011-06-13 12:47:56'),
(23, 150, 16, 148, ',147,147,103,112,146,', 11, 8, 1, '11111111111111111111111111111111111111122222222222222222222222222222222222222222233333333333333333333333333333333333344444444444444444444444444444444444455555555555555555555555555555555555555566666666666666666666666666666667777777777777777777777777777777888888888888888888888', 'studentdoc', '2011-03-28 10:55:54', '2011-06-13 12:47:56'),
(25, 147, 18, NULL, NULL, 12, 0, 1, 'yyyy', 'task', '2011-03-28 11:17:38', '2011-06-13 12:47:56'),
(26, 148, 15, NULL, NULL, NULL, 0, 1, 'comment by jatinder', 'project', '2011-03-28 12:40:11', '2011-06-13 12:47:56'),
(27, 158, 15, 148, ',148,147,103,112,146,', 10, 9, 1, 'help help help help', 'studentdoc', '2011-03-28 12:42:56', '2011-06-13 12:47:56'),
(28, 150, 16, 148, ',147,147,103,112,146,', 11, 8, 1, 'new comment at 12 44', 'studentdoc', '2011-03-28 12:44:24', '2011-06-13 12:47:56'),
(29, 147, 19, NULL, NULL, 13, 0, 1, 'ssss', 'task', '2011-03-28 16:55:13', '2011-06-13 12:47:56'),
(30, 150, 19, 149, ',147,147,103,112,146,', 13, 10, 1, 'work done by parvesh.pls cross check the assignment', 'studentdoc', '2011-03-28 16:56:48', '2011-06-13 12:47:56'),
(32, 150, 19, 149, ',147,147,103,112,146,', 13, 10, 1, '333333333', 'studentdoc', '2011-03-28 16:57:06', '2011-06-13 12:47:56'),
(33, 149, 18, NULL, NULL, NULL, 0, 1, 'llllllooooooolllllll', 'project', '2011-03-28 17:01:25', '2011-06-13 12:47:56'),
(34, 150, 15, 148, ',148,147,103,112,146,', 10, 11, 1, '#jyfkuyfulyfvulbvl', 'studentdoc', '2011-03-28 17:10:22', '2011-06-13 12:47:56'),
(35, 147, 20, NULL, NULL, 14, 0, 1, 'whenever you complete the project...report to admin section', 'task', '2011-03-28 17:25:59', '2011-06-13 12:47:56'),
(36, 150, 20, 148, ',147,147,103,112,146,', 14, 12, 1, 'by parvesh........................kumar', 'studentdoc', '2011-03-28 17:28:09', '2011-06-13 12:47:56'),
(37, 147, 21, NULL, NULL, 16, 0, 1, 'With comments', 'task', '2011-03-28 17:47:21', '2011-06-13 12:47:56'),
(38, 147, 21, NULL, NULL, NULL, 0, 1, 's', 'project', '2011-03-28 17:47:35', '2011-06-13 12:47:56'),
(39, 148, 21, NULL, NULL, NULL, 0, 1, '564865', 'project', '2011-03-28 17:52:19', '2011-06-13 12:47:56'),
(43, 173, 22, NULL, NULL, 18, 0, 1, 'Ok....be honest', 'task', '2011-03-29 10:25:33', '2011-06-13 12:47:56'),
(44, 173, 24, NULL, NULL, 19, 0, 1, 'a', 'task', '2011-03-29 10:48:04', '2011-06-13 12:47:56'),
(45, 173, 25, NULL, NULL, NULL, 0, 1, '77', 'project', '2011-03-29 10:53:39', '2011-06-13 12:47:56'),
(46, 174, 24, 173, ',173,173,103,112,146,', 19, 14, 1, 'ho gya....yipppeeeee', 'studentdoc', '2011-03-29 11:18:23', '2011-06-13 12:47:56'),
(47, 176, 24, 173, ',173,173,103,112,146,', 19, 15, 1, 'Done knoe about the tsak', 'studentdoc', '2011-03-29 11:19:35', '2011-06-13 12:47:56'),
(48, 175, 24, 173, ',173,173,103,112,146,', 19, 16, 1, 'Done by jyoti', 'studentdoc', '2011-03-29 11:20:08', '2011-06-13 12:47:56'),
(49, 173, 26, NULL, NULL, NULL, 0, 1, 'degfwreg', 'project', '2011-03-29 11:34:08', '2011-06-13 12:47:56'),
(50, 173, 27, NULL, NULL, 20, 0, 1, 'dgvgbwgbwergb', 'task', '2011-03-29 11:34:43', '2011-06-13 12:47:56'),
(51, 176, 27, 173, ',173,173,103,112,146,', 20, 17, 1, 'done done done done done by pk', 'studentdoc', '2011-03-29 11:42:54', '2011-06-13 12:47:56'),
(52, 173, 29, NULL, NULL, 21, 0, 1, 'gggggggggggggggggggggggggggggggggggggg', 'task', '2011-03-29 12:09:46', '2011-06-13 12:47:56'),
(53, 180, 29, 173, ',173,173,103,112,146,', 21, 18, 1, 'rhytrejtnujbdvgact4t2645896579', 'studentdoc', '2011-03-29 12:11:24', '2011-06-13 12:47:56'),
(54, 176, 29, 173, ',173,173,103,112,146,', 21, 19, 1, 'ho gya gya sangwan', 'studentdoc', '2011-03-29 12:22:05', '2011-06-13 12:47:56'),
(55, 147, 30, NULL, NULL, 22, 0, 1, 'q4tgqregbth', 'task', '2011-03-30 08:23:26', '2011-06-13 12:47:56'),
(56, 150, 30, 148, ',147,147,103,146,', 22, 20, 1, 'check', 'studentdoc', '2011-03-30 08:24:28', '2011-06-13 12:47:56'),
(57, 7, 31, NULL, NULL, 23, 0, 1, '2', 'task', '2011-03-30 09:35:02', '2011-06-13 12:47:56'),
(58, 7, 31, NULL, NULL, 24, 0, 1, 'ew', 'task', '2011-03-30 09:35:18', '2011-06-13 12:47:56'),
(59, 173, 33, NULL, NULL, 25, 0, 1, 'c', 'task', '2011-03-30 10:43:29', '2011-06-13 12:47:56'),
(60, 173, 33, NULL, NULL, NULL, 0, 1, 'c', 'project', '2011-03-30 10:43:56', '2011-06-13 12:47:56'),
(61, 67, 35, NULL, NULL, 26, 0, 1, 'asdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasdaasdasdasdasdasda', 'task', '2011-03-30 11:24:04', '2011-06-13 12:47:56'),
(62, 67, 35, NULL, NULL, 27, 0, 1, 'cvxcvzxcvzxz', 'task', '2011-03-30 11:25:15', '2011-06-13 12:47:56'),
(63, 67, 35, NULL, NULL, NULL, 0, 1, 'dsfdsfdsfdsfsdfdsfdsfsd', 'project', '2011-03-30 11:28:44', '2011-06-13 12:47:56'),
(64, 107, 35, 95, ',67,67,103,146,', 26, 21, 1, 'sadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAssadsadasasaSAsaSAsaSAsaSAs', 'studentdoc', '2011-03-30 11:35:29', '2011-06-13 12:47:56'),
(65, 107, 35, 95, ',67,67,103,146,', 27, 22, 1, 'sdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasdsdasdasdasdasdasdasdasdsadasd', 'studentdoc', '2011-03-30 11:36:17', '2011-06-13 12:47:56'),
(66, 7, 32, NULL, NULL, 28, 0, 1, 'ds', 'task', '2011-03-30 14:03:28', '2011-06-13 12:47:56'),
(67, 7, 32, NULL, NULL, 29, 0, 1, 'c', 'task', '2011-03-30 14:14:02', '2011-06-13 12:47:56'),
(68, 7, 32, NULL, NULL, 30, 0, 1, 'c', 'task', '2011-03-30 14:16:56', '2011-06-13 12:47:56'),
(69, 7, 32, NULL, NULL, 31, 0, 1, 'gg', 'task', '2011-03-30 14:18:37', '2011-06-13 12:47:56'),
(70, 7, 32, NULL, NULL, 32, 0, 1, 'd', 'task', '2011-03-30 14:21:16', '2011-06-13 12:47:56'),
(71, 7, 32, NULL, NULL, 33, 0, 1, 'f', 'task', '2011-03-30 14:21:39', '2011-06-13 12:47:56'),
(72, 7, 32, NULL, NULL, NULL, 0, 1, ';;;;', 'project', '2011-03-30 14:28:27', '2011-06-13 12:47:56'),
(73, 7, 32, NULL, NULL, 34, 0, 1, 'd', 'task', '2011-03-30 14:29:28', '2011-06-13 12:47:56'),
(74, 7, 32, NULL, NULL, NULL, 0, 1, 'm', 'project', '2011-03-30 14:29:31', '2011-06-13 12:47:56'),
(75, 7, 32, NULL, NULL, NULL, 0, 1, 'v', 'project', '2011-03-31 10:45:51', '2011-06-13 12:47:56'),
(76, 7, 32, NULL, NULL, 35, 0, 1, 'cx', 'task', '2011-03-31 12:36:37', '2011-06-13 12:47:56'),
(77, 7, 38, NULL, NULL, 36, 0, 1, 'f', 'task', '2011-03-31 15:04:43', '2011-06-13 12:47:56'),
(78, 7, 39, NULL, NULL, 37, 0, 1, 'bv', 'task', '2011-03-31 15:06:22', '2011-06-13 12:47:56'),
(79, 7, 38, NULL, NULL, 38, 0, 1, 'cv', 'task', '2011-03-31 15:09:49', '2011-06-13 12:47:56'),
(80, 7, 38, NULL, NULL, 39, 0, 1, 'uy', 'task', '2011-03-31 15:10:25', '2011-06-13 12:47:56'),
(81, 7, 38, NULL, NULL, NULL, 0, 1, 'h', 'project', '2011-03-31 15:10:34', '2011-06-13 12:47:56'),
(82, 147, 40, NULL, NULL, 40, 0, 1, 's', 'task', '2011-03-31 15:12:08', '2011-06-13 12:47:56'),
(83, 173, 41, NULL, NULL, 41, 0, 1, 's', 'task', '2011-03-31 15:18:32', '2011-06-13 12:47:56'),
(84, 13, 32, 56, ',7,7,103,146,193,', 34, 23, 1, 's', 'studentdoc', '2011-03-31 15:29:18', '2011-06-13 12:47:56'),
(85, 13, 32, 56, ',7,7,103,146,193,', 35, 24, 1, '2', 'studentdoc', '2011-03-31 15:29:29', '2011-06-13 12:47:56'),
(86, 7, 42, NULL, NULL, 42, 0, 1, 'ds', 'task', '2011-03-31 15:40:16', '2011-06-13 12:47:56'),
(87, 200, 42, 56, ',7,7,103,146,193,199,', 42, 25, 1, 'cx', 'studentdoc', '2011-03-31 15:41:18', '2011-06-13 12:47:56'),
(88, 13, 42, 56, ',7,7,103,146,193,199,', 42, 26, 1, 'kj', 'studentdoc', '2011-03-31 15:42:14', '2011-06-13 12:47:56'),
(89, 7, 42, 13, ',7,7,103,146,193,', 42, 26, 1, 'f', 'studentdoc', '2011-03-31 16:00:18', '2011-06-13 12:47:56'),
(90, 147, 45, NULL, NULL, 43, 0, 1, 'c', 'task', '2011-03-31 17:24:47', '2011-06-13 12:47:56'),
(91, 173, 46, NULL, NULL, 44, 0, 1, 'f', 'task', '2011-03-31 17:54:58', '2011-06-13 12:47:56'),
(92, 67, 47, NULL, NULL, 45, 0, 1, 'Detail info of linux', 'task', '2011-03-31 18:23:15', '2011-06-13 12:47:56'),
(93, 67, 47, NULL, NULL, 46, 0, 1, 'watch pic.......', 'task', '2011-03-31 18:23:54', '2011-06-13 12:47:56'),
(94, 67, 48, NULL, NULL, 49, 0, 1, 'pic of water lilies', 'task', '2011-03-31 18:32:18', '2011-06-13 12:47:56'),
(95, 67, 51, NULL, NULL, 51, 0, 1, 'explain about linux...............how it work', 'task', '2011-04-01 14:23:11', '2011-06-13 12:47:56'),
(96, 67, 51, NULL, NULL, 52, 0, 1, 'enjoy pic', 'task', '2011-04-01 14:23:44', '2011-06-13 12:47:56'),
(97, 131, 47, 121, ',67,67,103,146,193,', 45, 27, 1, 'lg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsalg;dfsgl;dfsgl;fdgdfglfdglfdgfdgkfdjgldfskjlgjfsdjgkfjsdlkgsgdfkgjkdfsjglsdfkjgdfksjidasfljsa', 'studentdoc', '2011-04-01 14:32:54', '2011-06-13 12:47:56'),
(98, 131, 47, 121, ',67,67,103,146,193,', 46, 28, 1, 'xcvxcvvvvdsfgfdccccccccccccc...............', 'studentdoc', '2011-04-01 14:33:29', '2011-06-13 12:47:56'),
(99, 131, 47, 121, ',67,67,103,146,193,', 46, 28, 1, 'second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............second comments on same pic.............', 'studentdoc', '2011-04-01 14:34:04', '2011-06-13 12:47:56'),
(100, 131, 47, 121, ',67,67,103,146,193,', 46, 28, 1, 'third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...third comments on same pic...', 'studentdoc', '2011-04-01 14:34:40', '2011-06-13 12:47:56'),
(101, 67, 52, NULL, NULL, 53, 0, 1, 'sdfsfsdfsd', 'task', '2011-04-01 15:02:39', '2011-06-13 12:47:56'),
(102, 67, 53, NULL, NULL, 54, 0, 1, 'fsdfsdfsdf', 'task', '2011-04-01 15:04:00', '2011-06-13 12:47:56'),
(103, 67, 54, NULL, NULL, 55, 0, 1, 'hgfhfdhdghghgfh', 'task', '2011-04-01 15:09:16', '2011-06-13 12:47:56'),
(104, 67, 54, NULL, NULL, 56, 0, 1, '2 second class group', 'task', '2011-04-01 15:10:21', '2011-06-13 12:47:56'),
(105, 67, 47, NULL, NULL, NULL, 0, 1, 'in Breif: section', 'project', '2011-04-01 18:18:19', '2011-06-13 12:47:56'),
(106, 67, 47, NULL, NULL, NULL, 0, 1, 'sadas', 'project', '2011-04-01 18:18:40', '2011-06-13 12:47:56'),
(107, 67, 47, NULL, NULL, NULL, 0, 1, 'sadas', 'project', '2011-04-01 18:49:26', '2011-06-13 12:47:56'),
(108, 67, 53, NULL, NULL, NULL, 0, 1, 'gfhdgfhgf', 'project', '2011-04-04 10:37:29', '2011-06-13 12:47:56'),
(109, 67, 53, NULL, NULL, NULL, 0, 1, 'test', 'project', '2011-04-04 10:56:55', '2011-06-13 12:47:56'),
(110, 67, 54, NULL, NULL, NULL, 0, 1, 'sdfsdfsdf', 'project', '2011-04-04 11:06:48', '2011-06-13 12:47:56'),
(111, 1, 55, NULL, NULL, 57, 0, 1, 'Which character is this ?????????????/', 'task', '2011-04-04 16:26:16', '2011-06-13 12:47:56'),
(112, 1, 55, NULL, NULL, NULL, 0, 1, 'The department leader should an educator for that subject also', 'project', '2011-04-04 16:27:28', '2011-06-13 12:47:56'),
(113, 1, 55, NULL, NULL, NULL, 0, 1, 'aaaaaa', 'project', '2011-04-04 16:37:21', '2011-06-13 12:47:56'),
(114, 223, 55, 218, ',1,1,103,146,193,219,', 57, 30, 1, 'on php image', 'studentdoc', '2011-04-04 16:38:16', '2011-06-13 12:47:56'),
(115, 67, 52, NULL, NULL, 58, 0, 1, 'dsfsdfsdfsdfsd', 'task', '2011-04-04 16:48:40', '2011-06-13 12:47:56'),
(116, 67, 52, NULL, NULL, 60, 0, 1, 'sadasdas', 'task', '2011-04-04 18:39:24', '2011-06-13 12:47:56'),
(117, 1, 56, NULL, NULL, 61, 0, 1, 'sdfsdf', 'task', '2011-04-04 20:14:54', '2011-06-13 12:47:56'),
(118, 67, 52, NULL, NULL, NULL, 0, 1, 'two groups are removed.', 'project', '2011-04-05 10:50:58', '2011-06-13 12:47:56'),
(119, 67, 52, NULL, NULL, NULL, 0, 1, 'sdfgdfgdfgfdgfd', 'project', '2011-04-05 11:03:35', '2011-06-13 12:47:56'),
(120, 67, 52, NULL, NULL, NULL, 0, 1, 'change in sunject...', 'project', '2011-04-05 11:14:41', '2011-06-13 12:47:56'),
(121, 67, 52, NULL, NULL, NULL, 0, 1, 'date', 'project', '2011-04-05 11:15:28', '2011-06-13 12:47:56'),
(122, 67, 52, NULL, NULL, NULL, 0, 1, 'deleted project', 'project', '2011-04-05 11:19:10', '2011-06-13 12:47:56'),
(123, 67, 52, NULL, NULL, NULL, 0, 1, 'new group added', 'project', '2011-04-05 11:35:34', '2011-06-13 12:47:56'),
(124, 67, 52, NULL, NULL, NULL, 0, 1, 'bvnbvnbvnbv', 'project', '2011-04-05 12:01:36', '2011-06-13 12:47:56'),
(125, 67, 52, NULL, NULL, NULL, 0, 1, 'add newv group', 'project', '2011-04-05 12:02:18', '2011-06-13 12:47:56'),
(126, 67, 52, NULL, NULL, NULL, 0, 1, 'new premium student....', 'project', '2011-04-05 12:16:20', '2011-06-13 12:47:56'),
(127, 67, 52, NULL, NULL, NULL, 0, 1, 'dfsdfdsfsd', 'project', '2011-04-05 12:17:01', '2011-06-13 12:47:56'),
(128, 67, 52, NULL, NULL, NULL, 0, 1, '     nbmbvmbn', 'project', '2011-04-05 14:11:45', '2011-06-13 12:47:56'),
(129, 67, 57, NULL, NULL, 62, 0, 1, 'dasdasdasd', 'task', '2011-04-05 14:23:21', '2011-06-13 12:47:56'),
(130, 67, 59, NULL, NULL, 63, 0, 1, 'asdsasa', 'task', '2011-04-05 14:27:10', '2011-06-13 12:47:56'),
(131, 67, 60, NULL, NULL, 64, 0, 1, 'gfsdgdfds', 'task', '2011-04-05 14:33:52', '2011-06-13 12:47:56'),
(132, 67, 63, NULL, NULL, 65, 0, 1, 'dsadasdasdasd', 'task', '2011-04-05 15:45:50', '2011-06-13 12:47:56'),
(133, 67, 64, NULL, NULL, 66, 0, 1, 'dfasfa', 'task', '2011-04-05 15:49:00', '2011-06-13 12:47:56'),
(134, 67, 66, NULL, NULL, 67, 0, 1, 'hfgjgjf', 'task', '2011-04-05 15:50:04', '2011-06-13 12:47:56'),
(135, 67, 67, NULL, NULL, 68, 0, 1, 'sgfsdgfsdgsdfgds', 'task', '2011-04-05 15:51:22', '2011-06-13 12:47:56'),
(136, 67, 54, NULL, NULL, 69, 0, 1, 'rfdgdfgdf', 'task', '2011-04-05 18:35:51', '2011-06-13 12:47:56'),
(137, 67, 54, NULL, NULL, NULL, 0, 1, '   xzczx', 'project', '2011-04-05 18:36:29', '2011-06-13 12:47:56'),
(138, 107, 57, 121, ',67,67,103,146,193,219,', 62, 31, 1, 'Dbms project have been done from my side...............enjoy', 'studentdoc', '2011-04-06 11:41:01', '2011-06-13 12:47:56'),
(139, 107, 52, 171, ',67,67,103,146,193,219,', 53, 32, 1, 'hgjghjghjghjgjhgjghjhgjhgjghjghj', 'studentdoc', '2011-04-06 11:41:59', '2011-06-13 12:47:56'),
(140, 107, 52, 171, ',67,67,103,146,193,219,', 60, 33, 1, 'enjoy..\n', 'studentdoc', '2011-04-06 11:42:29', '2011-06-13 12:47:56'),
(141, 107, 66, 127, ',67,67,103,146,193,219,', 67, 34, 1, 'cvxcvxcvxcvxcvxzvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', 'studentdoc', '2011-04-06 11:44:21', '2011-06-13 12:47:56'),
(142, 109, 67, 127, ',67,67,103,146,193,219,', 68, 35, 1, 'asdsadasdssadasdsa', 'studentdoc', '2011-04-06 11:47:26', '2011-06-13 12:47:56'),
(143, 131, 51, 108, ',67,67,103,146,193,219,', 51, 36, 1, 'ewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewrewrwerwerwerwerewr', 'studentdoc', '2011-04-06 12:35:11', '2011-06-13 12:47:56'),
(144, 131, 51, 108, ',67,67,103,146,193,219,', 52, 37, 1, 'nice pic.............', 'studentdoc', '2011-04-06 12:35:37', '2011-06-13 12:47:56'),
(145, 131, 48, 108, ',67,67,103,146,193,219,', 49, 38, 1, 'winter pic.............', 'studentdoc', '2011-04-06 12:36:22', '2011-06-13 12:47:56'),
(146, 131, 64, 171, ',67,67,103,146,193,219,', 66, 39, 1, 'fgfdsgfdsgdfsgdsgdfsgsdfgdfgfsdgfsdgdfsgdf', 'studentdoc', '2011-04-06 12:36:47', '2011-06-13 12:47:56'),
(147, 131, 49, 171, ',67,67,103,146,193,219,', 50, 40, 1, 'jhjhgjhgjhgjhgjhgjhjhgjhghgghhjhjghjghj', 'studentdoc', '2011-04-06 12:37:14', '2011-06-13 12:47:56'),
(148, 131, 53, 95, ',67,67,103,146,193,219,', 54, 41, 1, 'new project of DBMS i have done it................', 'studentdoc', '2011-04-06 12:38:37', '2011-06-13 12:47:56'),
(149, 131, 59, 127, ',67,67,103,146,193,219,', 63, 42, 1, 'ver nice...................demo.....', 'studentdoc', '2011-04-06 12:39:19', '2011-06-13 12:47:56'),
(150, 67, 68, NULL, NULL, 70, 0, 1, 'this is demo for marking.........................', 'task', '2011-04-06 12:43:22', '2011-06-13 12:47:56'),
(151, 107, 68, 108, ',67,67,103,146,193,219,', 70, 43, 1, 'i m done.............................with demo..', 'studentdoc', '2011-04-06 12:51:16', '2011-06-13 12:47:56'),
(152, 67, 69, NULL, NULL, 71, 0, 1, 'dsfsdfdsfsdfsdfsd', 'task', '2011-04-06 12:56:23', '2011-06-13 12:47:56'),
(153, 7, 1, NULL, NULL, 72, 0, 1, 'test', 'task', '2011-04-06 14:08:21', '2011-06-13 12:47:56'),
(154, 7, 1, NULL, NULL, 73, 0, 1, 'TESTTTTTTTTTTTTTTTT', 'task', '2011-04-06 14:09:37', '2011-06-13 12:47:56'),
(155, 7, 1, NULL, NULL, 74, 0, 1, 'Google I/O is a two-day developer event that will take place May 10-11 at Moscone Center, San Francisco. The agenda includes several sessions about Android, presented by Android engineers and other team members.', 'task', '2011-04-06 14:09:57', '2011-06-13 12:47:56'),
(156, 13, 1, 56, ',7,7,103,146,193,219,', 73, 44, 1, 'dd', 'studentdoc', '2011-04-06 14:31:44', '2011-06-13 12:47:56'),
(157, 13, 1, 56, ',7,7,103,146,193,219,', 2, 45, 1, 'hjj', 'studentdoc', '2011-04-06 14:38:17', '2011-06-13 12:47:56'),
(158, 13, 1, 56, ',7,7,103,146,193,219,', 2, 46, 1, ' , ', 'studentdoc', '2011-04-06 15:12:51', '2011-06-13 12:47:56'),
(159, 67, 48, 131, ',67,67,103,146,193,219,', 49, 38, 1, '    sadasdasdas', 'studentdoc', '2011-04-06 18:42:13', '2011-06-13 12:47:56'),
(160, 67, 48, 131, ',67,67,103,146,193,219,', 49, 38, 1, '    sadasdasdas', 'studentdoc', '2011-04-06 18:42:19', '2011-06-13 12:47:56'),
(162, 67, 70, NULL, NULL, 75, 0, 1, 'afsadfsafsdafsdafasdfsa', 'task', '2011-04-07 10:15:21', '2011-06-13 12:47:56'),
(163, 67, 68, 107, ',67,67,103,146,193,219,', 70, 43, 1, 'sdfsdfsd', 'studentdoc', '2011-04-07 10:58:11', '2011-06-13 12:47:56'),
(164, 67, 75, NULL, NULL, 76, 0, 1, 'asdasda', 'task', '2011-04-07 15:11:32', '2011-06-13 12:47:56'),
(165, 67, 76, NULL, NULL, 77, 0, 1, 'dasdasdsa', 'task', '2011-04-07 15:21:42', '2011-06-13 12:47:56'),
(166, 67, 76, NULL, NULL, 78, 0, 1, 'sfsdfssdfdfs', 'task', '2011-04-07 15:33:42', '2011-06-13 12:47:56'),
(167, 67, 67, NULL, NULL, 79, 0, 1, 'sdfsdf', 'task', '2011-04-07 16:03:28', '2011-06-13 12:47:56'),
(168, 67, 77, NULL, NULL, 80, 0, 1, 'fsdafasdfsfa', 'task', '2011-04-07 17:22:49', '2011-06-13 12:47:56'),
(169, 67, 78, NULL, NULL, 81, 0, 1, 'xvxcvxcvxc', 'task', '2011-04-07 17:28:06', '2011-06-13 12:47:56'),
(170, 67, 79, NULL, NULL, 82, 0, 1, 'dsfdsfsdf', 'task', '2011-04-07 17:31:11', '2011-06-13 12:47:56'),
(171, 67, 80, NULL, NULL, 83, 0, 1, 'sdsadas', 'task', '2011-04-07 18:06:29', '2011-06-13 12:47:56'),
(172, 67, 81, NULL, NULL, 84, 0, 1, 'dsfsdfsdfsdfsd', 'task', '2011-04-07 18:29:28', '2011-06-13 12:47:56'),
(173, 67, 81, NULL, NULL, NULL, 0, 1, 'update in brief section', 'project', '2011-04-08 14:19:48', '2011-06-13 12:47:56'),
(174, 95, 84, NULL, NULL, 85, 0, 1, 'sdfsdfsdf', 'task', '2011-04-11 10:42:44', '2011-06-13 12:47:56'),
(175, 95, 70, 107, ',67,67,103,146,193,219,', 75, 47, 1, 'hjkhjhjkkhk', 'studentdoc', '2011-04-11 16:11:51', '2011-06-13 12:47:56'),
(176, 67, 87, NULL, NULL, 86, 0, 1, 'asdfdsafasfdsfsadfsdf', 'task', '2011-04-12 12:08:01', '2011-06-13 12:47:56'),
(177, 67, 88, NULL, NULL, 87, 0, 1, 'Comments :dsfsdfdsfhdksjfhksdhafjsdkfhjksdhfjksdhfksd', 'task', '2011-04-12 14:27:50', '2011-06-13 12:47:56'),
(178, 67, 88, NULL, NULL, 88, 0, 1, 'sdasdasdsdsadsadasdskladaskkdjfdksafjl', 'task', '2011-04-12 14:28:20', '2011-06-13 12:47:56'),
(179, 107, 88, 95, ',67,67,103,146,193,219,', 87, 49, 1, 'sfsdfsdfdsfdsfdsfsddddddddddddddddddddddddddddddd', 'studentdoc', '2011-04-12 16:35:47', '2011-06-13 12:47:56'),
(180, 107, 88, 95, ',67,67,103,146,193,219,', 87, 49, 1, 'sadasasdasdas', 'studentdoc', '2011-04-12 17:15:35', '2011-06-13 12:47:56'),
(181, 107, 88, 95, ',67,67,103,146,193,219,', 87, 49, 1, 'fffffffffffffffffff', 'studentdoc', '2011-04-12 17:24:53', '2011-06-13 12:47:56'),
(182, 107, 88, 95, ',67,67,103,146,193,219,', 88, 50, 1, 'new addedcomment of files', 'studentdoc', '2011-04-12 17:58:46', '2011-06-13 12:47:56'),
(183, 107, 88, 95, ',67,67,103,146,193,219,', 88, 50, 1, 'fdgdfgdfgdf', 'studentdoc', '2011-04-12 17:59:15', '2011-06-13 12:47:56'),
(184, 107, 88, 95, ',67,67,103,146,193,219,', 88, 51, 1, 'ghgfhgfhf', 'studentdoc', '2011-04-12 18:32:42', '2011-06-13 12:47:56'),
(185, 131, 88, 95, ',67,67,103,146,193,219,', 87, 52, 1, 'dfgdfgf', 'studentdoc', '2011-04-13 14:36:21', '2011-06-13 12:47:56'),
(186, 131, 88, 95, ',67,67,103,146,193,219,', 88, 53, 1, 'dfsdfdsfsdfd', 'studentdoc', '2011-04-13 14:53:21', '2011-06-13 12:47:56'),
(187, 67, 90, NULL, NULL, 89, 0, 1, 'dsfgsdfgsdfgdfs', 'task', '2011-04-13 14:56:21', '2011-06-13 12:47:56'),
(188, 67, 92, NULL, NULL, 90, 0, 1, 'sdfsdfsdfds', 'task', '2011-04-13 15:06:52', '2011-06-13 12:47:56'),
(189, 67, 93, NULL, NULL, 91, 0, 1, 'sdafsdfsdfa', 'task', '2011-04-13 15:07:40', '2011-06-13 12:47:56'),
(190, 67, 94, NULL, NULL, 92, 0, 1, 'afsdafdassdaf', 'task', '2011-04-13 15:08:36', '2011-06-13 12:47:56'),
(191, 67, 95, NULL, NULL, 93, 0, 1, 'gfhjghjghjhgjghjg', 'task', '2011-04-13 15:09:19', '2011-06-13 12:47:56'),
(192, 131, 90, 108, ',67,67,103,146,193,219,', 89, 54, 1, 'dsadasdasd', 'studentdoc', '2011-04-13 15:11:14', '2011-06-13 12:47:56'),
(193, 131, 92, 120, ',67,67,103,146,193,219,', 90, 55, 1, 'sadsadasdas', 'studentdoc', '2011-04-13 15:11:27', '2011-06-13 12:47:56'),
(194, 131, 93, 126, ',67,67,103,146,193,219,', 91, 56, 1, 'asdasdasdas', 'studentdoc', '2011-04-13 15:11:40', '2011-06-13 12:47:56'),
(195, 131, 94, 171, ',67,67,103,146,193,219,', 92, 57, 1, 'sadsadfdgdfgdfgfd', 'studentdoc', '2011-04-13 15:11:58', '2011-06-13 12:47:56'),
(196, 131, 95, 233, ',67,67,103,146,193,219,', 93, 58, 1, 'dsfdsfdfhgjkkhjklhkhj', 'studentdoc', '2011-04-13 15:12:25', '2011-06-13 12:47:56'),
(197, 131, 69, 108, ',67,67,103,146,193,219,', 71, 59, 1, 'sdfsdfsdfsdf', 'studentdoc', '2011-04-13 15:13:52', '2011-06-13 12:47:56'),
(198, 131, 77, 123, ',67,67,103,146,193,219,', 80, 60, 1, 'dfdsfsdfsdf', 'studentdoc', '2011-04-13 17:56:53', '2011-06-13 12:47:56'),
(199, 232, 96, NULL, NULL, 94, 0, 1, 'fdsfsdfdsfsdfdsfsdfdfdfdsfds', 'task', '2011-04-15 15:18:48', '2011-06-13 12:47:56'),
(200, 232, 96, NULL, NULL, 95, 0, 1, 'dfdsfdsfdsfsdfsdfsdfsdfs', 'task', '2011-04-15 15:19:20', '2011-06-13 12:47:56'),
(201, 232, 97, NULL, NULL, 96, 0, 1, 'fdsafsdafdasffdasfsd', 'task', '2011-04-15 15:21:42', '2011-06-13 12:47:56'),
(202, 1, 55, NULL, NULL, 98, 0, 1, 'take notes', 'task', '2011-04-16 14:17:38', '2011-06-13 12:47:56'),
(203, 1, 55, NULL, NULL, NULL, 0, 1, 'Added task', 'project', '2011-04-16 14:20:08', '2011-06-13 12:47:56'),
(204, 1, 55, NULL, NULL, NULL, 0, 1, 'I am testing edit project notifications', 'project', '2011-04-18 10:05:17', '2011-06-13 12:47:56'),
(205, 176, 46, 173, ',173,173,103,146,193,219,240,', 44, 61, 1, 'asaSAsaSA', 'studentdoc', '2011-04-18 13:56:52', '2011-06-13 12:47:56'),
(206, 7, 99, NULL, NULL, 99, 0, 1, 's', 'task', '2011-04-21 10:41:39', '2011-06-13 12:47:56'),
(207, 7, 99, NULL, NULL, 100, 0, 1, 'e', 'task', '2011-04-21 10:41:56', '2011-06-13 12:47:56'),
(208, 7, 99, NULL, NULL, 101, 0, 1, 'ds', 'task', '2011-04-21 11:10:29', '2011-06-13 12:47:56'),
(209, 7, 99, NULL, NULL, 102, 0, 1, 'ee', 'task', '2011-04-21 11:39:53', '2011-06-13 12:47:56'),
(210, 7, 99, NULL, NULL, 103, 0, 1, 'kkkkk', 'task', '2011-04-21 11:43:42', '2011-06-13 12:47:56'),
(211, 7, 99, NULL, NULL, 104, 0, 1, 'yyy', 'task', '2011-04-21 11:49:02', '2011-06-13 12:47:56'),
(212, 7, 99, NULL, NULL, 105, 0, 1, 'fgfgdfg', 'task', '2011-04-21 11:49:51', '2011-06-13 12:47:56'),
(213, 7, 99, NULL, NULL, 106, 0, 1, 'vcx', 'task', '2011-04-21 11:51:08', '2011-06-13 12:47:56'),
(214, 7, 99, NULL, NULL, 107, 0, 1, 'hgfhfgh', 'task', '2011-04-21 11:54:06', '2011-06-13 12:47:56'),
(215, 7, 99, NULL, NULL, 108, 0, 1, 'hhh', 'task', '2011-04-21 11:55:22', '2011-06-13 12:47:56'),
(216, 7, 99, NULL, NULL, 109, 0, 1, 'k', 'task', '2011-04-21 11:56:44', '2011-06-13 12:47:56'),
(217, 7, 99, NULL, NULL, 110, 0, 1, 'f', 'task', '2011-04-21 12:03:20', '2011-06-13 12:47:56'),
(218, 247, 100, NULL, NULL, 111, 0, 1, '2', 'task', '2011-04-25 11:49:20', '2011-06-13 12:47:56'),
(219, 1, 102, NULL, NULL, 113, 0, 1, 'free', 'task', '2011-05-17 05:30:11', '2011-06-13 12:47:56'),
(220, 1, 56, NULL, NULL, NULL, 0, 1, 'test change', 'project', '2011-05-17 05:32:36', '2011-06-13 12:47:56'),
(221, 1, 56, NULL, NULL, NULL, 0, 1, 'klk', 'project', '2011-05-19 02:21:56', '2011-06-13 12:47:56'),
(222, 1, 103, NULL, NULL, 114, 0, 1, 'test', 'task', '2011-05-19 02:22:49', '2011-06-13 12:47:56'),
(223, 1, 103, NULL, NULL, NULL, 0, 1, 'kjkjhk', 'project', '2011-05-27 12:45:51', '2011-06-13 12:47:56'),
(224, 266, 105, 1, ',1,1,103,146,193,219,', 116, 63, 1, 'what if it sounds terriblefsds', 'studentdoc', '2011-05-27 12:59:52', '2011-06-13 12:47:56'),
(225, 7, 107, NULL, NULL, 117, 0, 1, 'u', 'task', '2011-05-30 06:46:39', '2011-06-13 12:47:56'),
(226, 1, 103, NULL, NULL, 118, 0, 1, 'd', 'task', '2011-05-30 06:59:04', '2011-06-13 12:47:56'),
(227, 1, 103, NULL, NULL, NULL, 0, 1, 'c', 'project', '2011-05-30 06:59:11', '2011-06-13 12:47:56'),
(228, 1, 108, NULL, NULL, 119, 0, 1, 'g', 'task', '2011-05-30 08:15:15', '2011-06-13 12:47:56'),
(229, 226, 108, 218, ',1,1,103,146,193,219,', 119, 64, 1, 'Please check', 'studentdoc', '2011-05-30 08:16:24', '2011-06-13 12:47:56'),
(230, 1, 108, NULL, NULL, 121, 0, 1, '1', 'task', '2011-05-30 08:27:22', '2011-06-13 12:47:56'),
(231, 1, 108, NULL, NULL, 122, 0, 1, '2', 'task', '2011-06-01 00:57:10', '2011-06-13 12:47:56'),
(232, 1, 108, NULL, NULL, 123, 0, 1, '2', 'task', '2011-06-01 00:59:59', '2011-06-13 12:47:56'),
(233, 1, 108, NULL, NULL, NULL, 0, 1, 'Added in file', 'project', '2011-06-03 08:14:28', '2011-06-13 12:47:56'),
(234, 219, 109, NULL, NULL, 125, 0, 1, 'View this design and comment on it''s design', 'task', '2011-06-03 08:36:05', '2011-06-13 12:47:56'),
(235, 219, 111, NULL, NULL, 126, 0, 1, 'Use this to help your progress', 'task', '2011-06-05 04:52:38', '2011-06-13 12:47:56'),
(236, 219, 111, NULL, NULL, 129, 0, 1, 'nice logo', 'task', '2011-06-05 05:00:01', '2011-06-13 12:47:56'),
(237, 219, 111, NULL, NULL, 130, 0, 1, 'Don''t forget sugar', 'task', '2011-06-05 05:00:23', '2011-06-13 12:47:56'),
(238, 219, 111, NULL, NULL, NULL, 0, 1, 'Added document', 'project', '2011-06-05 05:05:30', '2011-06-13 12:47:56'),
(239, 219, 112, NULL, NULL, 131, 0, 1, 'dfsdf', 'task', '2011-06-05 05:06:29', '2011-06-13 12:47:56'),
(240, 219, 112, NULL, NULL, 132, 0, 1, 'Upload your logo', 'task', '2011-06-05 05:06:58', '2011-06-13 12:47:56'),
(241, 266, 111, 218, ',219,1,103,146,193,219,', 126, 65, 1, 'sadsadasd', 'studentdoc', '2011-06-05 08:35:02', '2011-06-13 12:47:56'),
(242, 219, 108, NULL, NULL, 133, 0, 1, 'tst', 'task', '2011-06-05 08:49:02', '2011-06-13 12:47:56'),
(243, 219, 108, NULL, NULL, 134, 0, 1, 'Do it', 'task', '2011-06-06 15:52:50', '2011-06-13 12:47:56'),
(244, 219, 108, NULL, NULL, NULL, 0, 1, 'stuff', 'project', '2011-06-06 15:53:07', '2011-06-13 12:47:56'),
(245, 1, 111, NULL, NULL, NULL, 0, 1, 'fff', 'project', '2011-06-08 02:15:30', '2011-06-13 12:47:56'),
(246, 1, 111, NULL, NULL, NULL, 0, 1, 'Assigned to Mec', 'project', '2011-06-08 02:22:53', '2011-06-13 12:47:56'),
(247, 1, 109, NULL, NULL, NULL, 0, 1, 'assigned to mec', 'project', '2011-06-08 03:50:13', '2011-06-13 12:47:56'),
(248, 1, 98, NULL, NULL, 135, 0, 1, 'lll', 'task', '2011-06-08 04:22:08', '2011-06-13 12:47:56'),
(249, 219, 98, NULL, NULL, 137, 0, 1, 'sdfs', 'task', '2011-06-10 14:19:41', '2011-06-13 12:47:56'),
(250, 266, 111, 218, ',219,1,103,146,193,219,', 126, 65, 1, 'This is aweosme', 'studentdoc', '2011-06-10 14:32:42', '2011-06-13 12:47:56'),
(252, 219, 115, NULL, NULL, 140, 0, 1, 'sddf', 'task', '2011-06-14 15:19:26', '0000-00-00 00:00:00'),
(253, 7, 118, NULL, NULL, 147, 0, 1, 'This is the first task', 'task', '2011-06-29 07:03:52', '0000-00-00 00:00:00'),
(254, 7, 118, NULL, ',7,7,103,146,193,219,', 147, 0, 1, 'Test Message', 'task', '2011-06-29 07:52:46', '0000-00-00 00:00:00'),
(255, 7, 118, NULL, NULL, NULL, 0, 1, 'Added Comments\r\n', 'project', '2011-06-29 08:04:41', '0000-00-00 00:00:00'),
(256, 7, 107, NULL, ',7,7,103,146,193,219,', 117, 0, 1, 'This is first comment', 'task', '2011-06-29 08:09:15', '0000-00-00 00:00:00'),
(257, 7, 118, NULL, ',7,7,103,146,193,219,', 147, 0, 1, 'This task is necessary', 'task', '2011-06-29 08:09:46', '0000-00-00 00:00:00'),
(258, 13, 118, 56, ',7,7,103,146,193,219,', 147, 66, 1, 'Please check', 'studentdoc', '2011-06-29 08:19:41', '0000-00-00 00:00:00'),
(259, 219, 119, NULL, NULL, 151, 0, 1, 'should be top', 'task', '2011-07-01 11:05:54', '0000-00-00 00:00:00'),
(260, 281, 120, 262, ',219,1,103,146,193,219,', 153, 67, 1, 'I think I did it', 'studentdoc', '2011-07-01 11:23:54', '0000-00-00 00:00:00'),
(261, 219, 120, NULL, ',219,1,103,146,193,219,', 152, 0, 1, 'heeeeey', 'task', '2011-07-01 11:34:20', '0000-00-00 00:00:00'),
(262, 219, 126, NULL, NULL, 154, 0, 1, 'dfsdf', 'task', '2011-07-04 05:29:29', '0000-00-00 00:00:00'),
(263, 7, 1, NULL, ',7,7,103,146,193,219,', 74, 0, 1, 'fff', 'task', '2011-07-05 07:24:37', '0000-00-00 00:00:00'),
(264, 7, 127, NULL, NULL, 157, 0, 1, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.', 'task', '2011-07-06 07:49:01', '0000-00-00 00:00:00'),
(265, 7, 128, NULL, NULL, 158, 0, 1, 'Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. ', 'task', '2011-07-06 07:50:37', '0000-00-00 00:00:00'),
(266, 7, 128, NULL, ',7,7,103,146,193,219,', 158, 0, 1, 'c', 'task', '2011-07-06 07:50:52', '0000-00-00 00:00:00'),
(267, 7, 128, NULL, NULL, NULL, 0, 1, '8', 'project', '2011-07-06 08:10:04', '0000-00-00 00:00:00'),
(268, 297, 130, NULL, NULL, 160, 0, 1, 'check this', 'task', '2011-07-19 12:35:00', '0000-00-00 00:00:00'),
(269, 297, 130, NULL, NULL, 162, 0, 1, 'Create a document and upload it ', 'task', '2011-07-19 12:36:22', '0000-00-00 00:00:00'),
(270, 219, 120, NULL, NULL, NULL, 0, 1, 'this', 'project', '2011-07-19 16:29:44', '0000-00-00 00:00:00'),
(271, 219, 126, NULL, NULL, NULL, 0, 1, 'sd', 'project', '2011-07-19 16:32:18', '0000-00-00 00:00:00'),
(272, 1, 125, NULL, NULL, 165, 0, 1, 'Comment', 'task', '2011-09-09 02:04:19', '0000-00-00 00:00:00'),
(273, 305, 133, 304, ',304,304,103,146,193,219,', 170, 76, 1, 'Test', 'studentdoc', '2011-09-12 02:32:11', '0000-00-00 00:00:00'),
(274, 305, 133, 304, ',304,304,103,146,193,219,', 170, 77, 1, 'Test', 'studentdoc', '2011-09-12 02:42:34', '0000-00-00 00:00:00'),
(275, 304, 133, NULL, NULL, 171, 0, 1, 'test', 'task', '2011-09-12 03:16:15', '0000-00-00 00:00:00'),
(276, 13, 128, 56, ',7,7,103,146,193,219,', 158, 72, 1, 'Test', 'studentdoc', '2011-09-12 05:25:11', '0000-00-00 00:00:00'),
(277, 13, 128, 56, ',7,7,103,146,193,219,', 158, 72, 1, 'd', 'studentdoc', '2011-09-12 05:25:21', '0000-00-00 00:00:00'),
(279, 13, 107, 56, ',7,7,103,146,193,219,', 117, 78, 1, 'Comment', 'studentdoc', '2011-09-12 05:28:02', '0000-00-00 00:00:00'),
(280, 13, 128, 56, ',7,7,103,146,193,219,', 158, 72, 1, '..', 'studentdoc', '2011-09-12 05:33:09', '0000-00-00 00:00:00'),
(281, 13, 107, 56, ',7,7,103,146,193,219,', 117, 79, 1, 'p', 'studentdoc', '2011-09-12 05:56:50', '0000-00-00 00:00:00'),
(282, 13, 107, 56, ',7,7,103,146,193,219,', 117, 80, 1, '\np', 'studentdoc', '2011-09-12 05:57:21', '0000-00-00 00:00:00'),
(283, 7, 134, NULL, NULL, 172, 0, 1, 'Comment', 'task', '2011-09-14 23:27:47', '0000-00-00 00:00:00'),
(284, 7, 134, NULL, NULL, 173, 0, 1, '2', 'task', '2011-09-14 23:29:16', '0000-00-00 00:00:00'),
(285, 7, 134, NULL, NULL, NULL, 0, 1, 'r', 'project', '2011-09-14 23:29:34', '0000-00-00 00:00:00'),
(286, 13, 1, 56, ',7,7,103,146,193,219,', 74, 62, 1, 'b', 'studentdoc', '2011-09-15 22:03:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_students`
--

CREATE TABLE IF NOT EXISTS `project_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `project_id` int(11) DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `submitted_date` datetime DEFAULT NULL,
  `marked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_students_prj_id` (`project_id`),
  KEY `project_students_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=355 ;

--
-- Dumping data for table `project_students`
--

INSERT INTO `project_students` (`id`, `user_id`, `group_id`, `project_id`, `completed`, `submitted_date`, `marked`) VALUES
(280, 238, 83, 96, 0, NULL, 0),
(281, 238, 83, 97, 0, NULL, 0),
(284, 220, 2, 55, 0, NULL, 0),
(285, 223, 2, 55, 0, NULL, 0),
(286, 250, 85, 100, 0, NULL, 0),
(288, 220, 86, 56, 0, NULL, 0),
(289, 266, 88, 105, 1, '2011-05-27 12:59:52', 1),
(298, 220, 86, 108, 0, NULL, 0),
(299, 226, 86, 108, 0, NULL, 0),
(300, 266, 88, 108, 0, NULL, 0),
(302, 220, 86, 111, 0, NULL, 0),
(303, 226, 86, 111, 0, NULL, 0),
(304, 278, 86, 111, 0, NULL, 0),
(305, 266, 88, 111, 0, NULL, 0),
(306, 266, 88, 109, 0, NULL, 0),
(307, 220, 86, 98, 0, NULL, 0),
(308, 226, 86, 98, 0, NULL, 0),
(309, 278, 86, 98, 0, NULL, 0),
(310, 266, 88, 113, 0, NULL, 0),
(311, 281, 88, 113, 0, NULL, 0),
(312, 266, 88, 114, 0, NULL, 0),
(313, 281, 88, 114, 0, NULL, 0),
(314, 266, 88, 115, 0, NULL, 0),
(315, 281, 88, 115, 0, NULL, 0),
(316, 266, 88, 116, 0, NULL, 0),
(317, 281, 88, 116, 0, NULL, 0),
(345, 266, 88, 120, 0, NULL, 0),
(346, 281, 88, 120, 0, NULL, 0),
(347, 281, 94, 126, 0, NULL, 0),
(348, 266, 93, 125, 0, NULL, 0),
(349, 301, 93, 125, 0, NULL, 0),
(350, 266, 88, 131, 0, NULL, 0),
(351, 281, 88, 131, 0, NULL, 0),
(352, 298, 0, 131, 0, NULL, 0),
(353, 305, 100, 132, 1, '2011-09-10 08:39:25', 1),
(354, 305, 100, 133, 0, '2011-09-12 02:42:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_student_task_docs`
--

CREATE TABLE IF NOT EXISTS `project_student_task_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type_id` int(11) DEFAULT NULL,
  `refer_file_id` int(11) NOT NULL DEFAULT '0',
  `submitted_date` datetime DEFAULT NULL,
  `marks` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `project_student_task_docs`
--

INSERT INTO `project_student_task_docs` (`id`, `user_id`, `task_id`, `project_id`, `title`, `file_name`, `file_type_id`, `refer_file_id`, `submitted_date`, `marks`) VALUES
(1, 13, 1, 1, 'Task Completed', '', NULL, 0, '2011-03-24 10:43:40', NULL),
(2, 13, 3, 2, 'Task Completed', '', NULL, 0, '2011-03-24 10:45:43', NULL),
(3, 13, 5, 3, '2_1300946681', '2_1300946681.gif', 1, 190, '2011-03-24 11:35:06', NULL),
(4, 104, 7, 7, 'Blue hills_1301042946', 'Blue hills_1301042946.jpg', 1, 193, '2011-03-25 14:19:55', NULL),
(5, 139, 8, 9, 'Task Completed', '', NULL, 0, '2011-03-25 18:33:38', NULL),
(6, 141, 9, 11, 'WC _1301287611', 'WC _1301287611.doc', 2, 206, '2011-03-28 10:17:04', NULL),
(7, 150, 11, 16, 'WC _1301289873', 'WC _1301289873.doc', 2, 208, '2011-03-28 10:55:23', NULL),
(8, 150, 11, 16, 'WC _1301289928', 'WC _1301289928.doc', 2, 209, '2011-03-28 10:55:54', NULL),
(9, 158, 10, 15, 'Task Completed', '', NULL, 0, '2011-03-28 12:42:56', NULL),
(10, 150, 13, 19, 'Task Completed', '', NULL, 0, '2011-03-28 16:56:48', NULL),
(11, 150, 10, 15, 'Task Completed', '', NULL, 0, '2011-03-28 17:10:22', NULL),
(12, 150, 14, 20, 'WC _1301289873', 'WC _1301289873.doc', 2, 208, '2011-03-28 17:28:09', NULL),
(13, 150, 15, 21, 'New Microsoft Word Document_1301314973', 'New Microsoft Word Document_1301314973.doc', 2, 215, '2011-03-28 17:53:24', NULL),
(14, 174, 19, 24, 'Task Completed', '', NULL, 0, '2011-03-29 11:18:23', NULL),
(15, 176, 19, 24, 'Task Completed', '', NULL, 0, '2011-03-29 11:19:35', NULL),
(16, 175, 19, 24, 'Task Completed', '', NULL, 0, '2011-03-29 11:20:08', NULL),
(17, 176, 20, 27, 'WC _1301379122', 'WC _1301379122.doc', 2, 221, '2011-03-29 11:42:54', NULL),
(18, 180, 21, 29, 'New Microsoft Word Document_1301380865', 'New Microsoft Word Document_1301380865.doc', 2, 223, '2011-03-29 12:11:24', NULL),
(19, 176, 21, 29, 'WC _1301379122', 'WC _1301379122.doc', 2, 221, '2011-03-29 12:22:05', NULL),
(20, 150, 22, 30, 'New Microsoft Word Document_1301453654', 'New Microsoft Word Document_1301453654.doc', 2, 226, '2011-03-30 08:24:28', NULL),
(21, 107, 26, 35, 'Task Completed', '', NULL, 0, '2011-03-30 11:35:29', NULL),
(22, 107, 27, 35, 'sez_1301465146', 'sez_1301465146.doc', 2, 228, '2011-03-30 11:36:17', NULL),
(23, 13, 34, 32, 'Task Completed', '', NULL, 0, '2011-03-31 15:29:18', NULL),
(24, 13, 35, 32, 'concers_1300190537', 'concers_1300190537.doc', 2, 152, '2011-03-31 15:29:29', NULL),
(25, 200, 42, 42, 'thumbnail_1301566262', 'thumbnail_1301566262.jpeg', 1, 236, '2011-03-31 15:41:18', NULL),
(26, 13, 42, 42, 'thumbnail_1301566319', 'thumbnail_1301566319.jpeg', 1, 237, '2011-03-31 15:42:14', NULL),
(27, 131, 45, 47, 'Task Completed', '', NULL, 0, '2011-04-01 14:32:54', NULL),
(28, 131, 46, 47, 'Winter_1301648590', 'Winter_1301648590.jpg', 1, 243, '2011-04-01 14:33:29', NULL),
(29, 109, 55, 54, 'Task Completed', '', NULL, 0, '2011-04-01 15:13:53', NULL),
(30, 223, 57, 55, 'php_1301915281', 'php_1301915281.gif', 1, 269, '2011-04-04 16:38:16', NULL),
(31, 107, 62, 57, 'Task Completed', '', NULL, 0, '2011-04-06 11:41:01', NULL),
(32, 107, 53, 52, 'Task Completed', '', NULL, 0, '2011-04-06 11:41:59', NULL),
(33, 107, 60, 52, 'Winter_1302070330', 'Winter_1302070330.jpg', 1, 293, '2011-04-06 11:42:29', NULL),
(34, 107, 67, 66, 'Task Completed', '', NULL, 0, '2011-04-06 11:44:21', NULL),
(35, 109, 68, 67, 'Task Completed', '', NULL, 0, '2011-04-06 11:47:26', NULL),
(36, 131, 51, 51, 'Task Completed', '', NULL, 0, '2011-04-06 12:35:11', NULL),
(37, 131, 52, 51, 'Sunset_1302073520', 'Sunset_1302073520.jpg', 1, 294, '2011-04-06 12:35:37', NULL),
(38, 131, 49, 48, 'Winter_1302073564', 'Winter_1302073564.jpg', 1, 295, '2011-04-06 12:36:22', NULL),
(39, 131, 66, 64, 'Task Completed', '', NULL, 0, '2011-04-06 12:36:47', NULL),
(40, 131, 50, 49, 'Task Completed', '', NULL, 0, '2011-04-06 12:37:14', NULL),
(41, 131, 54, 53, 'Task Completed', '', NULL, 0, '2011-04-06 12:38:37', NULL),
(42, 131, 63, 59, 'Task Completed', '', NULL, 0, '2011-04-06 12:39:19', NULL),
(43, 107, 70, 68, 'Task Completed', '', NULL, 0, '2011-04-06 12:51:16', NULL),
(44, 13, 73, 1, 'CloudPollen 1301892755664_1302080359', 'CloudPollen 1301892755664_1302080359.png', 1, 297, '2011-04-06 14:31:44', NULL),
(45, 13, 2, 1, '2_1300946681', '2_1300946681.gif', 1, 190, '2011-04-06 14:38:17', NULL),
(46, 13, 2, 1, 'slow_1302082911', 'slow_1302082911.gif', 1, 299, '2011-04-06 15:12:51', NULL),
(47, 107, 75, 70, 'Task Completed', '', NULL, 0, '2011-04-07 10:18:15', NULL),
(48, 107, 86, 87, 'Task Completed', '', NULL, 0, '2011-04-12 16:04:08', NULL),
(49, 107, 87, 88, 'Task Completed', '', NULL, 0, '2011-04-12 16:35:47', NULL),
(50, 107, 88, 88, 'Winter_1302610746', 'Winter_1302610746.jpg', 1, 309, '2011-04-12 17:58:46', NULL),
(51, 107, 88, 88, 'Winter_1302611634', 'Winter_1302611634.jpg', 1, 310, '2011-04-12 18:32:42', NULL),
(52, 131, 87, 88, 'Task Completed', '', NULL, 0, '2011-04-13 14:36:21', NULL),
(53, 131, 88, 88, 'Water lilies_1302686588', 'Water lilies_1302686588.jpg', 1, 311, '2011-04-13 14:53:21', NULL),
(54, 131, 89, 90, 'Task Completed', '', NULL, 0, '2011-04-13 15:11:14', NULL),
(55, 131, 90, 92, 'Task Completed', '', NULL, 0, '2011-04-13 15:11:27', NULL),
(56, 131, 91, 93, 'Task Completed', '', NULL, 0, '2011-04-13 15:11:40', NULL),
(57, 131, 92, 94, 'Task Completed', '', NULL, 0, '2011-04-13 15:11:58', NULL),
(58, 131, 93, 95, 'Task Completed', '', NULL, 0, '2011-04-13 15:12:25', NULL),
(59, 131, 71, 69, 'Task Completed', '', NULL, 0, '2011-04-13 15:13:52', NULL),
(60, 131, 80, 77, 'Task Completed', '', NULL, 0, '2011-04-13 17:56:53', NULL),
(61, 176, 44, 46, 'Task Completed', '', NULL, 0, '2011-04-18 13:56:52', NULL),
(62, 13, 74, 1, 'concers_1300190537', 'concers_1300190537.doc', 2, 152, '2011-05-19 03:47:10', NULL),
(63, 266, 116, 105, 'Task Completed', '', NULL, 0, '2011-05-27 12:59:52', NULL),
(64, 226, 119, 108, 'manageusers_1306761374', 'manageusers_1306761374.html', 1, 325, '2011-05-30 08:16:24', NULL),
(65, 266, 126, 111, 'logo_1307280044', 'logo_1307280044.png', 1, 336, '2011-06-05 08:35:02', NULL),
(66, 13, 147, 118, 'CloudPollen 1301892755664_1301912180', 'CloudPollen 1301892755664_1301912180.png', 1, 263, '2011-06-29 08:19:41', NULL),
(67, 281, 153, 120, 'Task Completed', '', NULL, 0, '2011-07-01 11:23:54', NULL),
(68, 266, 153, 120, 'Task Completed', '', NULL, 0, '2011-07-13 07:17:41', NULL),
(69, 266, 152, 120, 'joinUs', 'joinUs.jpg', 1, 373, '2011-07-13 07:18:18', NULL),
(70, 266, 152, 120, '1306139994 arrow 000 medium_1309773266', '1306139994 arrow 000 medium_1309773266.png', 1, 356, '2011-07-13 07:19:07', NULL),
(71, 266, 152, 120, 'joinUs', 'joinUs.jpg', 1, 373, '2011-07-13 07:19:24', NULL),
(72, 13, 158, 128, 'Task Completed', '', NULL, 0, '2011-07-19 06:53:47', NULL),
(73, 305, 169, 132, 'Task Completed', '', NULL, 0, '2011-09-10 08:39:19', NULL),
(74, 305, 168, 132, 'Task Completed', '', NULL, 0, '2011-09-10 08:39:25', NULL),
(75, 305, 170, 133, 'Sever Requirements', 'Sever Requirements.doc', 2, 382, '2011-09-10 08:46:47', NULL),
(76, 305, 170, 133, 'Sever Requirements', 'Sever Requirements.doc', 2, 383, '2011-09-12 02:32:11', NULL),
(77, 305, 170, 133, 'usefullinks', 'usefullinks.doc', 2, 384, '2011-09-12 02:42:34', NULL),
(78, 13, 117, 107, '2_1300946681', '2_1300946681.gif', 1, 190, '2011-09-12 05:28:02', NULL),
(79, 13, 117, 107, 'concers_1300190537', 'concers_1300190537.doc', 2, 152, '2011-09-12 05:56:50', NULL),
(80, 13, 117, 107, 'concers_1300190537', 'concers_1300190537.doc', 2, 152, '2011-09-12 05:57:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_student_task_marks`
--

CREATE TABLE IF NOT EXISTS `project_student_task_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `marks` float DEFAULT NULL,
  `marked` tinyint(1) NOT NULL DEFAULT '0',
  `submitted_date` datetime DEFAULT NULL,
  `marked_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `project_student_task_marks`
--

INSERT INTO `project_student_task_marks` (`id`, `user_id`, `project_id`, `task_id`, `marks`, `marked`, `submitted_date`, `marked_date`) VALUES
(1, 13, 1, 1, 2, 1, '2011-03-24 10:43:40', '2011-03-30 14:39:21'),
(2, 13, 2, 3, NULL, 0, '2011-03-24 10:45:43', NULL),
(3, 13, 3, 5, 1, 1, '2011-03-24 11:35:06', '2011-03-24 12:26:20'),
(4, 104, 7, 7, NULL, 0, '2011-03-25 14:19:55', NULL),
(5, 139, 9, 8, 1, 1, '2011-03-25 18:33:38', '2011-03-25 18:34:27'),
(6, 141, 11, 9, NULL, 0, '2011-03-28 10:17:04', NULL),
(7, 150, 16, 11, 3, 1, '2011-03-28 10:55:54', '2011-03-28 17:03:20'),
(8, 158, 15, 10, NULL, 0, '2011-03-28 12:42:56', NULL),
(9, 150, 19, 13, 4, 1, '2011-03-28 16:56:48', '2011-03-28 17:02:50'),
(10, 150, 15, 10, NULL, 0, '2011-03-28 17:10:22', NULL),
(11, 150, 20, 14, NULL, 0, '2011-03-28 17:28:09', NULL),
(12, 150, 21, 15, 2, 1, '2011-03-28 17:53:24', '2011-03-28 18:02:00'),
(13, 174, 24, 19, NULL, 0, '2011-03-29 11:18:23', NULL),
(14, 176, 24, 19, NULL, 0, '2011-03-29 11:19:35', NULL),
(15, 175, 24, 19, NULL, 0, '2011-03-29 11:20:08', NULL),
(16, 176, 27, 20, 3, 1, '2011-03-29 11:42:54', '2011-03-29 11:43:29'),
(17, 180, 29, 21, 4, 1, '2011-03-29 12:11:24', '2011-03-29 12:12:18'),
(18, 176, 29, 21, 3, 1, '2011-03-29 12:22:05', '2011-03-29 12:23:20'),
(19, 150, 30, 22, 5, 1, '2011-03-30 08:24:28', '2011-03-30 08:24:52'),
(20, 107, 35, 26, 76, 1, '2011-03-30 11:35:29', '2011-03-30 11:38:29'),
(21, 107, 35, 27, 56, 1, '2011-03-30 11:36:17', '2011-03-30 11:38:29'),
(22, 13, 32, 34, NULL, 0, '2011-03-31 15:29:18', NULL),
(23, 13, 32, 35, NULL, 0, '2011-03-31 15:29:29', NULL),
(24, 200, 42, 42, 2, 1, '2011-03-31 15:41:18', '2011-03-31 15:51:45'),
(25, 13, 42, 42, 2, 1, '2011-03-31 15:42:14', '2011-03-31 16:00:25'),
(26, 131, 47, 45, NULL, 0, '2011-04-01 14:32:54', NULL),
(27, 131, 47, 46, NULL, 0, '2011-04-01 14:33:29', NULL),
(28, 109, 54, 55, NULL, 0, '2011-04-01 15:13:53', NULL),
(29, 223, 55, 57, 15, 1, '2011-04-04 16:38:16', '2011-04-05 02:55:37'),
(30, 107, 57, 62, NULL, 0, '2011-04-06 11:41:01', NULL),
(31, 107, 52, 53, NULL, 0, '2011-04-06 11:41:59', NULL),
(32, 107, 52, 60, NULL, 0, '2011-04-06 11:42:29', NULL),
(33, 107, 66, 67, NULL, 0, '2011-04-06 11:44:21', NULL),
(34, 109, 67, 68, NULL, 0, '2011-04-06 11:47:26', NULL),
(35, 131, 51, 51, 9, 1, '2011-04-06 12:35:11', '2011-04-13 09:30:28'),
(36, 131, 51, 52, 21, 1, '2011-04-06 12:35:37', '2011-04-13 09:30:28'),
(37, 131, 48, 49, 22, 1, '2011-04-06 12:36:22', '2011-04-07 10:37:10'),
(38, 131, 64, 66, 34, 1, '2011-04-06 12:36:47', '2011-04-13 09:27:37'),
(39, 131, 49, 50, 12, 1, '2011-04-06 12:37:14', '2011-04-13 09:27:50'),
(40, 131, 53, 54, 32, 1, '2011-04-06 12:38:37', '2011-04-13 09:28:29'),
(41, 131, 59, 63, 23, 1, '2011-04-06 12:39:19', '2011-04-13 09:29:04'),
(42, 107, 68, 70, 1, 1, '2011-04-06 12:51:16', '2011-04-07 11:30:36'),
(43, 13, 1, 73, NULL, 0, '2011-04-06 14:31:44', NULL),
(44, 13, 1, 2, 1, 1, '2011-04-06 15:12:51', '2011-04-06 17:05:53'),
(45, 107, 70, 75, NULL, 0, '2011-04-07 10:18:15', NULL),
(46, 107, 87, 86, NULL, 0, '2011-04-12 16:04:08', NULL),
(47, 107, 88, 87, NULL, 0, '2011-04-12 16:35:47', NULL),
(48, 107, 88, 88, NULL, 0, '2011-04-12 18:32:42', NULL),
(49, 131, 88, 87, 45, 1, '2011-04-13 14:36:21', '2011-04-13 14:54:29'),
(50, 131, 88, 88, 34, 1, '2011-04-13 14:53:21', '2011-04-13 14:54:29'),
(51, 131, 90, 89, 45, 1, '2011-04-13 15:11:14', '2011-04-13 15:19:55'),
(52, 131, 92, 90, 23, 1, '2011-04-13 15:11:27', '2011-04-13 15:19:29'),
(53, 131, 93, 91, 50, 1, '2011-04-13 15:11:40', '2011-04-13 15:19:17'),
(54, 131, 94, 92, 32, 1, '2011-04-13 15:11:58', '2011-04-13 15:19:01'),
(55, 131, 95, 93, 67, 1, '2011-04-13 15:12:25', '2011-04-13 15:18:34'),
(56, 131, 69, 71, 23, 1, '2011-04-13 15:13:52', '2011-04-13 15:18:17'),
(57, 131, 77, 80, NULL, 0, '2011-04-13 17:56:53', NULL),
(58, 176, 46, 44, NULL, 0, '2011-04-18 13:56:52', NULL),
(59, 13, 1, 74, NULL, 0, '2011-05-19 03:47:10', NULL),
(60, 266, 105, 116, 9, 1, '2011-05-27 12:59:52', '2011-05-31 10:48:53'),
(61, 226, 108, 119, NULL, 0, '2011-05-30 08:16:24', NULL),
(62, 266, 111, 126, 20, 1, '2011-06-05 08:35:02', '2011-06-05 08:51:37'),
(63, 13, 118, 147, 3, 1, '2011-06-29 08:19:41', '2011-06-29 08:20:15'),
(64, 281, 120, 153, NULL, 0, '2011-07-01 11:23:54', NULL),
(65, 266, 120, 153, 9, 1, '2011-07-13 07:17:41', '2011-07-13 07:21:40'),
(66, 266, 120, 152, 18, 1, '2011-07-13 07:19:24', '2011-07-13 07:21:40'),
(67, 13, 128, 158, NULL, 0, '2011-07-19 06:53:47', NULL),
(68, 305, 132, 169, 25, 1, '2011-09-10 08:39:19', '2011-09-10 08:40:15'),
(69, 305, 132, 168, 65, 1, '2011-09-10 08:39:25', '2011-09-10 08:40:15'),
(70, 305, 133, 170, NULL, 0, '2011-09-12 02:42:34', NULL),
(71, 13, 107, 117, NULL, 0, '2011-09-12 05:57:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_tasks`
--

CREATE TABLE IF NOT EXISTS `project_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `refer_file_id` int(11) NOT NULL DEFAULT '0',
  `weight` float DEFAULT NULL,
  `monitor` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Dumping data for table `project_tasks`
--

INSERT INTO `project_tasks` (`id`, `project_id`, `file_name`, `title`, `description`, `file_type_id`, `refer_file_id`, `weight`, `monitor`, `created`) VALUES
(2, 1, '3_1300942931.gif', '3_1300942931', '', 1, 188, 1, 0, NULL),
(3, 2, NULL, 'T2', '', 0, 0, 2, 0, NULL),
(4, 2, '1281700748_1299048595.jpg', '1281700748_1299048595', '', 1, 31, 2, 0, NULL),
(6, 4, NULL, 'T2', '', 0, 0, 2, 0, NULL),
(7, 7, 'Blue hills_1301042821.jpg', 'Blue hills_1301042821', '', 1, 192, 2, 0, NULL),
(8, 9, NULL, 'fffff', '', 0, 0, 8, 0, NULL),
(9, 11, 'New Microsoft Word Document_1301057770.doc', 'New Microsoft Word Document_1301057770', '', 2, 201, 4, 0, NULL),
(10, 15, NULL, 'tick task', '', 0, 0, 5, 0, NULL),
(11, 16, 'WC _1301289442.doc', 'WC _1301289442', '', 2, 207, 3, 0, NULL),
(13, 19, NULL, 'ssss', '', 0, 0, 4, 0, NULL),
(14, 20, 'WC _1301313323.doc', 'WC _1301313323', '', 2, 210, 10, 0, NULL),
(16, 21, 'WC _1301314610.doc', 'WC _1301314610', '', 2, 213, 2, 0, NULL),
(17, 21, 'DJ testo Armin Van Buuren Eternity_1301314778.mp3', 'DJ testo Armin Van Buuren Eternity_1301314778', '', 6, 214, 1, 0, NULL),
(18, 22, NULL, 'Read chapter 5', '', 0, 0, 4, 0, NULL),
(19, 24, NULL, 'a', '', 0, 0, 2, 0, NULL),
(20, 27, 'WC _1301378671.doc', 'WC _1301378671', '', 2, 220, 3, 0, NULL),
(21, 29, 'WC _1301380764.doc', 'WC _1301380764', '', 2, 222, 5, 0, NULL),
(22, 30, 'WC _1301453590.doc', 'WC _1301453590', '', 2, 225, 6, 0, NULL),
(23, 31, NULL, 't1', '', 0, 0, 2, 0, NULL),
(24, 31, '1281700748_1298981726.jpg', '1281700748_1298981726', '', 1, 18, 2, 0, NULL),
(25, 33, 'WC _1301378592.doc', 'WC _1301378592', '', 2, 218, 2, 0, NULL),
(26, 35, NULL, 'task title : ds', '', 0, 0, 76, 0, NULL),
(27, 35, 'Petrofsky_1301464461.pdf', 'Petrofsky_1301464461', '', 4, 227, 99, 0, NULL),
(34, 32, NULL, 'j', '', 0, 0, 2, 0, NULL),
(35, 32, '195274 1384616510 4762285 q_1301555185.jpg', '195274 1384616510 4762285 q_1301555185', '', 1, 233, 2, 0, NULL),
(37, 39, '1281700748_1298981726.jpg', '1281700748_1298981726', '', 1, 18, 2, 0, NULL),
(40, 40, NULL, 's', '', 0, 0, 3, 0, NULL),
(41, 41, NULL, 's', '', 0, 0, 3, 0, NULL),
(43, 45, NULL, 't1', '', 0, 0, 2, 0, NULL),
(44, 46, NULL, 't1', '', 0, 0, 2, 0, NULL),
(45, 47, NULL, 'task title: Linux tsk', '', 0, 0, 12, 0, NULL),
(46, 47, 'Water lilies_1301576007.jpg', 'Water lilies_1301576007', '', 1, 238, 32, 0, NULL),
(49, 48, 'Water lilies_1301576513.jpg', 'Water lilies_1301576513', '', 1, 241, 25, 0, NULL),
(50, 49, NULL, 'sdafdsfsa', '', 0, 0, 52, 0, NULL),
(51, 51, NULL, 'task tit: linux', '', 0, 0, 21, 0, NULL),
(52, 51, 'Winter_1301648001.jpg', 'Winter_1301648001', '', 1, 242, 34, 0, NULL),
(53, 52, NULL, 'task: nm', '', 0, 0, 32, 0, NULL),
(54, 53, NULL, 'sdfsa', '', 0, 0, 45, 0, NULL),
(57, 55, 'yoda_1301914537.jpg', 'yoda_1301914537', '', 1, 268, 25, 0, NULL),
(60, 52, 'WayUpArrow_1301921530.gif', 'WayUpArrow_1301921530', '', 1, 277, 34, 0, NULL),
(61, 56, NULL, 'fdgdfdfg', '', 0, 0, 50, 0, NULL),
(62, 57, NULL, 'asds', '', 0, 0, 23, 0, NULL),
(63, 59, NULL, 'demo for delete', '', 0, 0, 32, 0, NULL),
(64, 60, NULL, 'dfgfddf', '', 0, 0, 45, 0, NULL),
(65, 63, NULL, 'asdasda', '', 0, 0, 32, 0, NULL),
(66, 64, NULL, 'asdfasa', '', 0, 0, 65, 0, NULL),
(67, 66, NULL, 'dfgdhf', '', 0, 0, 88, 0, NULL),
(68, 67, NULL, 'sdgfsd', '', 0, 0, 76, 0, NULL),
(70, 68, NULL, 'tsk title: demo of marking', '', 0, 0, 78, 0, NULL),
(71, 69, NULL, 'demo linux', '', 0, 0, 56, 0, NULL),
(72, 1, '1281700748 1298981726_1302002115.jpg', '1281700748 1298981726_1302002115', '', 1, 291, 2, 0, NULL),
(73, 1, 'slow_1302079111.gif', 'slow_1302079111', '', 1, 296, 2, 0, NULL),
(74, 1, '1281700748_1299048595.jpg', '1281700748_1299048595', '', 1, 31, 23, 0, NULL),
(75, 70, NULL, 'sdfsdafds', '', 0, 0, 45, 0, NULL),
(78, 76, 'Water lilies_1302170202.jpg', 'Water lilies_1302170202', '', 1, 301, 12, 0, NULL),
(79, 67, NULL, 'sdfsdfsd', '', 0, 0, 34, 0, NULL),
(80, 77, NULL, 'sdfasdfsda', '', 0, 0, 23, 0, NULL),
(81, 78, NULL, 'draft', '', 0, 0, 34, 0, NULL),
(82, 79, NULL, 'asdasd', '', 0, 0, 32, 0, NULL),
(83, 80, NULL, 'drafts', '', 0, 0, 23, 0, NULL),
(84, 81, NULL, 'sdfsdfsd', '', 0, 0, 67, 0, NULL),
(85, 84, NULL, 'dsfdsf', '', 0, 0, 12, 0, NULL),
(86, 87, NULL, 'sdfsdfsd', '', 0, 0, 45, 0, NULL),
(87, 88, NULL, 'task tit: sadasd', '', 0, 0, 76, 0, NULL),
(88, 88, 'Water lilies_1302598675.jpg', 'Water lilies_1302598675', '', 1, 308, 56, 0, NULL),
(89, 90, NULL, 'sdgdfsgfdsg', '', 0, 0, 56, 0, NULL),
(90, 92, NULL, 'sdfdsf', '', 0, 0, 45, 0, NULL),
(91, 93, NULL, 'sdafsdaf', '', 0, 0, 56, 0, NULL),
(92, 94, NULL, 'sdfsdfsdfsd', '', 0, 0, 45, 0, NULL),
(93, 95, NULL, 'hjghj', '', 0, 0, 87, 0, NULL),
(94, 96, NULL, 'task : dsfsdfsdf', '', 0, 0, 54, 0, NULL),
(95, 96, 'Water lilies_1302860942.jpg', 'Water lilies_1302860942', '', 1, 312, 76, 0, NULL),
(96, 97, NULL, 'asdf', '', 0, 0, 59, 0, NULL),
(97, 56, '1281700748 1298981726_1301907357.jpg', '1281700748 1298981726_1301907357', '', 1, 254, 20, 0, NULL),
(98, 55, NULL, 'Read chapters 10 - 15', '', 0, 0, 40, 0, NULL),
(99, 99, NULL, '111', '', 0, 0, 2, 0, NULL),
(101, 99, '1281700748 1298981726_1302002115.jpg', '1281700748 1298981726_1302002115', '', 1, 291, 2, 0, NULL),
(104, 99, 'Changes to the website 28thJan Kanwar_1299583917.doc', 'Changes to the website 28thJan Kanwar_1299583917', '', 2, 70, 6, 0, NULL),
(106, 99, 'Changes to the website 28thJan k_1299582930.doc', 'Changes to the website 28thJan k_1299582930', '', 2, 68, 2, 0, NULL),
(107, 99, 'Changes to the website 28thJan k_1299582930.doc', 'Changes to the website 28thJan k_1299582930', '', 2, 68, 3, 0, NULL),
(108, 99, 'template20 large_1303367103.jpg', 'template20 large_1303367103', '', 1, 315, 7, 0, NULL),
(111, 100, NULL, 's1', '', 0, 0, 2, 0, NULL),
(112, 101, NULL, 'test task', '', 0, 0, 2, 0, NULL),
(113, 102, NULL, 'hiiiiiiiiiiiii', '', 0, 0, 10, 0, NULL),
(114, 103, NULL, 'hiiiiiiiiii', '', 0, 0, 12, 0, NULL),
(116, 105, NULL, 'Practice page 1 of the uploaded document', '', 0, 0, 10, 0, NULL),
(117, 107, 'template7 large_1306755991.jpg', 'template7 large_1306755991', '', 1, 322, 2, 0, NULL),
(118, 103, 'template10 large_1306756737.jpg', 'template10 large_1306756737', '', 1, 323, 2, 0, NULL),
(119, 108, '1281700748 1298981726_1301907357.jpg', '1281700748 1298981726_1301907357', '', 1, 254, 2, 0, NULL),
(120, 103, NULL, 'nnnnnnnn', '', 0, 0, 12, 0, NULL),
(124, 109, NULL, 'Pixels, describe what they are', '', 0, 0, 25, 0, NULL),
(125, 109, 'Admin_1307107461.png', 'Admin_1307107461', '', 1, 330, 10, 0, NULL),
(126, 111, 'featured files_1307267493.png', 'featured files_1307267493', '', 1, 333, 30, 0, NULL),
(127, 111, NULL, 'This is adding a task to a document?', '', 0, 0, 30, 0, NULL),
(128, 111, 'featured project side_1307267574.png', 'featured project side_1307267574', '', 1, 334, 30, 0, NULL),
(129, 111, 'logo cb_1307267409.jpg', 'logo cb_1307267409', '', 1, 331, 10, 0, NULL),
(130, 111, NULL, 'Make a cup of tea', '', 0, 0, 30, 0, NULL),
(131, 112, 'Admin_1307107461.png', 'Admin_1307107461', '', 1, 330, 23, 0, NULL),
(132, 112, NULL, 'Create a logo', '', 0, 0, 33, 0, NULL),
(133, 108, 'projects home_1307281721.jpg', 'projects home_1307281721', '', 1, 338, 12, 0, NULL),
(134, 108, NULL, 'Awesome task', '', 0, 0, 13, 0, NULL),
(135, 98, NULL, 'test 2', '', 0, 0, 2, 0, NULL),
(136, 98, NULL, 'jhbmn', '', 0, 0, 23, 0, NULL),
(137, 98, 'Admin_1307107461.png', 'Admin_1307107461', '', 1, 330, 11, 0, NULL),
(138, 113, NULL, 'fsdfsd', '', 0, 0, 23, 0, NULL),
(139, 114, 'file names.png', 'file names', '', 1, 350, 20, 0, NULL),
(140, 115, NULL, 'weird', '', 0, 0, 22, 0, NULL),
(141, 115, 'update.png', 'update', '', 1, 351, 60, 0, NULL),
(142, 116, NULL, 'yo', '', 0, 0, 70, 0, NULL),
(143, 113, NULL, 'jhgjhggjg', '', 0, 0, 1, 0, NULL),
(144, 113, 'Penguins.jpg', 'Penguins', '', 1, 352, 12, 0, NULL),
(145, 113, NULL, 'dfgfdg', '', 0, 0, 1, 0, NULL),
(146, 113, '1281700748 1298981726_1301907357.jpg', '1281700748 1298981726_1301907357', '', 1, 254, 2, 0, NULL),
(147, 118, '1281700748_1298981726.jpg', '1281700748_1298981726', '', 1, 18, 12, 0, NULL),
(149, 119, NULL, 'Task 1 - should be bottom', '', 0, 0, 20, 0, '2011-07-01 11:05:28'),
(150, 119, NULL, 'Task 2 - should be middle', '', 0, 0, 20, 0, '2011-07-01 11:05:42'),
(151, 119, 'Admin_1307107461.png', 'Admin_1307107461', '', 1, 330, 50, 0, '2011-07-01 11:05:54'),
(152, 120, 'Admin_1307107461.png', 'Admin_1307107461', '', 1, 330, 20, 0, '2011-07-01 11:21:12'),
(153, 120, NULL, 'Jig it around and see what u get', '', 0, 0, 10, 0, '2011-07-01 11:21:30'),
(154, 126, NULL, 'Oi', '', 0, 0, 10, 0, '2011-07-04 05:29:29'),
(155, 126, NULL, 'me', '', 0, 0, 90, 0, '2011-07-04 05:30:04'),
(156, 126, NULL, 'sdfsd', '', 0, 0, 4, 0, '2011-07-04 05:30:10'),
(157, 127, NULL, 'Task T1', '', 0, 0, 20, 0, '2011-07-06 07:49:01'),
(158, 128, NULL, 'T1', '', 0, 0, 2, 0, '2011-07-06 07:50:37'),
(159, 129, NULL, 'fdfgdfgd', '', 0, 0, 12, 0, '2011-07-06 12:19:07'),
(160, 130, 'hit small.png', 'hit small', '', 1, 378, 20, 0, '2011-07-19 12:35:00'),
(161, 130, 'R font.png', 'R font', '', 1, 379, 40, 0, '2011-07-19 12:35:41'),
(162, 130, NULL, 'Now create the magic', '', 0, 0, 40, 0, '2011-07-19 12:36:22'),
(163, 126, NULL, 'feregrg', '', 0, 0, 12, 0, '2011-07-19 16:31:21'),
(164, 126, NULL, 'erf', '', 0, 0, 22, 0, '2011-07-19 16:32:11'),
(165, 125, '1281700748 1298981726_1301907357.jpg', '1281700748 1298981726_1301907357', '', 1, 254, 2, 0, '2011-09-09 02:04:19'),
(166, 131, NULL, 'Make a good doc', '', 0, 0, 12, 0, '2011-09-09 10:44:31'),
(167, 131, NULL, 'Don''t forget the butter', '', 0, 0, 26, 0, '2011-09-09 10:45:56'),
(168, 132, NULL, 'Create poster and upload jpg and psd', '', 0, 0, 70, 0, '2011-09-10 08:33:17'),
(169, 132, NULL, 'Upload a write up the concept of your poster in word format', '', 0, 0, 30, 0, '2011-09-10 08:33:42'),
(170, 133, 'broken link01.jpg', 'broken link01', '', 1, 381, 10, 0, '2011-09-10 08:44:48'),
(171, 133, 'JAON Calls.doc', 'JAON Calls', '', 2, 388, 2, 0, '2011-09-12 03:16:15'),
(172, 134, NULL, 'T1', '', 0, 0, 2, 0, '2011-09-14 23:27:47'),
(173, 134, '1281700748_1298981726.jpg', '1281700748_1298981726', '', 1, 18, 2, 0, '2011-09-14 23:29:16');

-- --------------------------------------------------------

--
-- Table structure for table `project_task_extra_docs`
--

CREATE TABLE IF NOT EXISTS `project_task_extra_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type_id` int(11) DEFAULT NULL,
  `refer_file_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `project_task_extra_docs`
--

INSERT INTO `project_task_extra_docs` (`id`, `user_id`, `task_id`, `project_id`, `title`, `file_name`, `file_type_id`, `refer_file_id`, `created`) VALUES
(1, 7, 74, 1, NULL, NULL, NULL, 367, '2011-07-05 07:22:27'),
(3, 219, 159, 129, NULL, NULL, NULL, 330, '2011-07-06 12:19:29'),
(4, 219, 159, 129, NULL, NULL, NULL, 334, '2011-07-06 12:19:37'),
(5, 219, 159, 129, NULL, NULL, NULL, 350, '2011-07-06 12:19:41'),
(6, 297, 160, 130, NULL, NULL, NULL, 378, '2011-07-19 12:35:15'),
(7, 1, 165, 125, NULL, NULL, NULL, 270, '2011-09-09 02:05:29'),
(8, 219, 166, 131, NULL, NULL, NULL, 380, '2011-09-09 10:45:11'),
(9, 219, 166, 131, NULL, NULL, NULL, 330, '2011-09-09 10:45:17'),
(11, 219, 166, 131, NULL, NULL, NULL, 348, '2011-09-09 10:45:23'),
(12, 219, 166, 131, NULL, NULL, NULL, 332, '2011-09-09 10:45:25'),
(13, 219, 166, 131, NULL, NULL, NULL, 380, '2011-09-09 10:45:28'),
(14, 219, 166, 131, NULL, NULL, NULL, 362, '2011-09-09 10:45:32'),
(15, 219, 166, 131, NULL, NULL, NULL, 350, '2011-09-09 10:45:36'),
(16, 304, 170, 133, NULL, NULL, NULL, 387, '2011-09-12 03:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `abbrev` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `abbrev`) VALUES
(1, 'Alabama', 'AL'),
(2, 'Alaska', 'AK'),
(3, 'Arizona', 'AZ'),
(4, 'Arkansas', 'AR'),
(5, 'California', 'CA'),
(6, 'Colorado', 'CO'),
(7, 'Connecticut', 'CT'),
(8, 'Delaware', 'DE'),
(9, 'Florida', 'FL'),
(10, 'Georgia', 'GA'),
(11, 'Hawaii', 'HI'),
(12, 'Idaho', 'ID'),
(13, 'Illinois', 'IL'),
(14, 'Indiana', 'IN'),
(15, 'Iowa', 'IA'),
(16, 'Kansas', 'KS'),
(17, 'Kentucky', 'KY'),
(18, 'Louisiana', 'LA'),
(19, 'Maine', 'ME'),
(20, 'Maryland', 'MD'),
(21, 'Massachusetts', 'MA'),
(22, 'Michigan', 'MI'),
(23, 'Minnesota', 'MN'),
(24, 'Mississippi', 'MS'),
(25, 'Missouri', 'MO'),
(26, 'Montana', 'MT'),
(27, 'Nebraska', 'NE'),
(28, 'Nevada', 'NV'),
(29, 'New Hampshire', 'NH'),
(30, 'New Jersey', 'NJ'),
(31, 'New Mexico', 'NM'),
(32, 'New York', 'NY'),
(33, 'North Carolina', 'NC'),
(34, 'North Dakota', 'ND'),
(35, 'Ohio', 'OH'),
(36, 'Oklahoma', 'OK'),
(37, 'Oregon', 'OR'),
(38, 'Pennsylvania', 'PA'),
(39, 'Rhode Island', 'RI'),
(40, 'South Carolina', 'SC'),
(41, 'South Dakota', 'SD'),
(42, 'Tennessee', 'TN'),
(43, 'Texas', 'TX'),
(44, 'Utah', 'UT'),
(45, 'Vermont', 'VT'),
(46, 'Virginia', 'VA'),
(47, 'Washington', 'WA'),
(48, 'West Virginia', 'WV'),
(49, 'Wisconsin', 'WI'),
(50, 'Wyoming', 'WY'),
(51, 'District of Columbia', 'DC');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `title`, `created`, `admin_id`, `created_by`, `department_id`) VALUES
(1, 'CA', '2011-02-25', 7, 7, 2),
(2, 'OS', '2011-02-25', 7, 7, 3),
(3, 'd', '2011-02-25', 7, 7, 4),
(5, 'Inheritance', '2011-02-25', 1, 1, 1),
(6, 'English', '2011-03-08', 7, 7, 6),
(7, 'dd', '2011-03-09', 7, 7, 6),
(8, 'Music', '2011-03-09', 17, 17, 9),
(9, 'Dms', '2011-03-09', 19, 19, 8),
(10, 'DS', '2011-03-09', 19, 19, 8),
(11, 'hindi', '2011-03-09', 17, 17, 9),
(12, 'Data structure', '2011-03-10', 33, 33, 16),
(13, 'Data Structure', '2011-03-10', 33, 33, 17),
(14, 'Data structure1', '2011-03-10', 33, 33, 17),
(15, 'DMS', '2011-03-10', 33, 33, 17),
(16, 'Guitar', '2011-03-11', 39, 39, 19),
(17, 'Music', '2011-03-11', 33, 33, 18),
(18, 'Games', '2011-03-11', 33, 33, 18),
(19, 'Physics', '2011-03-14', 55, 55, 20),
(20, 'Chemistry', '2011-03-14', 55, 55, 20),
(21, 'Math', '2011-03-14', 55, 55, 20),
(22, 'Biology', '2011-03-14', 55, 55, 21),
(23, 'Chemistry', '2011-03-14', 55, 55, 21),
(24, 'Physical Education', '2011-03-14', 55, 55, 21),
(25, 'History', '2011-03-15', 55, 55, 22),
(26, 'Data structure', '2011-03-16', 67, 67, 25),
(27, 'Economics', '2011-03-17', 55, 55, 22),
(28, 'music', '2011-03-18', 67, 67, 26),
(29, 'urdu', '2011-03-18', 55, 55, 27),
(30, 'Test Subject', '2011-03-24', 92, 92, 31),
(31, 'CA -1', '2011-03-24', 7, 7, 2),
(34, 'Sport', '2011-03-25', 136, 136, 36),
(35, 'hhhhhhhhhh', '2011-03-25', 136, 136, 36),
(36, 'sdsf', '2011-03-25', 67, 67, 33),
(37, 'english', '2011-03-28', 147, 147, 37),
(38, 'urdu', '2011-03-28', 147, 147, 37),
(39, 'c1', '2011-03-28', 7, 7, 28),
(42, 'kkkkkk', '2011-03-28', 161, 161, 39),
(43, 'hindi', '2011-03-28', 147, 147, 37),
(45, 'ds', '2011-03-28', 7, 7, 34),
(46, 'Math-Subject', '2011-03-29', 173, 173, 40),
(47, 'English-subject', '2011-03-29', 173, 173, 40),
(48, 'kj', '2011-03-30', 173, 173, 40),
(49, 'j', '2011-03-30', 173, 173, 40),
(50, 'p', '2011-03-30', 173, 173, 40),
(52, 'k', '2011-03-31', 7, 7, 42),
(53, 'h', '2011-03-31', 7, 7, 42),
(54, 'f', '2011-03-31', 7, 7, 42),
(55, 'a', '2011-03-31', 7, 7, 42),
(56, 'digtal', '2011-03-31', 67, 67, 44),
(57, 'swtich', '2011-03-31', 67, 67, 44),
(58, 'hockey', '2011-03-31', 67, 67, 57),
(59, 'football', '2011-03-31', 67, 67, 57),
(60, 'DBMS', '2011-03-31', 67, 67, 45),
(61, 'NM', '2011-03-31', 67, 67, 45),
(62, 'Linux', '2011-03-31', 67, 67, 45),
(63, 'DT', '2011-04-03', 1, 1, 1),
(64, 'Maths Lit', '2011-04-04', 1, 1, 60),
(65, 's', '2011-04-05', 7, 7, 4),
(66, 'v', '2011-04-05', 7, 7, 42),
(67, 'c', '2011-04-05', 7, 7, 42),
(68, 'jumping', '2011-04-13', 67, 67, 55),
(69, 'Data structure', '2011-04-13', 67, 67, 55),
(70, 'break dance', '2011-04-13', 67, 67, 43),
(71, 'panjabi dance', '2011-04-13', 67, 67, 43),
(72, 'CO', '2011-04-15', 232, 232, 61),
(73, 'C#', '2011-04-15', 232, 232, 61),
(74, 's1', '2011-04-25', 247, 247, 64),
(75, 'G1', '2011-05-19', 1, 1, 65),
(76, 'Drums', '2011-05-27', 1, 1, 66),
(77, 's1', '2011-05-30', 267, 267, 67),
(78, 'Lit', '2011-06-08', 270, 270, 68),
(79, 'Applied', '2011-06-08', 270, 270, 68),
(80, 's1', '2011-07-05', 274, 274, 70),
(81, 'Advertising', '2011-07-19', 297, 297, 72),
(82, 'English', '2011-08-26', 1, 219, 71),
(83, 's1', '2011-09-09', 1, 1, 73),
(84, 'S2', '2011-09-09', 1, 1, 73),
(85, 'S3', '2011-09-09', 1, 1, 73),
(86, 'Design', '2011-09-09', 304, 304, 74),
(87, 'Language', '2011-09-10', 304, 304, 75);

-- --------------------------------------------------------

--
-- Table structure for table `subject_educators`
--

CREATE TABLE IF NOT EXISTS `subject_educators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'userid = educators',
  `subject_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `subject_educators`
--

INSERT INTO `subject_educators` (`id`, `user_id`, `subject_id`, `department_id`) VALUES
(3, 3, 5, 1),
(4, 9, 2, 3),
(5, 12, 3, 4),
(6, 26, 8, 9),
(7, 24, 9, 10),
(8, 24, 10, 10),
(9, 34, 12, 16),
(10, 36, 13, 17),
(11, 36, 14, 17),
(12, 38, 13, 17),
(13, 34, 13, 16),
(14, 44, 16, 19),
(15, 43, 16, 19),
(16, 47, 16, 19),
(17, 50, 18, 18),
(18, 56, 1, 2),
(19, 56, 2, 2),
(20, 60, 21, 20),
(21, 69, 24, 21),
(22, 82, 24, 21),
(23, 82, 23, 21),
(24, 61, 20, 20),
(28, 62, 19, 20),
(29, 95, 26, 25),
(30, 96, 27, 22),
(31, 108, 28, 26),
(32, 137, 34, 36),
(33, 138, 35, 36),
(34, 87, 39, 28),
(35, 148, 38, 37),
(36, 149, 37, 37),
(37, 127, 40, 25),
(38, 95, 40, 25),
(39, 126, 40, 25),
(41, 167, 42, 39),
(42, 148, 43, 37),
(43, 171, 56, 44),
(44, 127, 59, 57),
(45, 127, 58, 57),
(46, 171, 60, 45),
(47, 126, 62, 45),
(48, 108, 62, 45),
(49, 123, 62, 45),
(50, 121, 62, 45),
(51, 120, 62, 45),
(52, 171, 62, 45),
(53, 126, 61, 45),
(54, 123, 61, 45),
(55, 108, 61, 45),
(56, 121, 61, 45),
(57, 120, 61, 45),
(58, 218, 5, 1),
(59, 233, 68, 55),
(60, 126, 68, 55),
(61, 233, 70, 55),
(62, 120, 70, 55),
(63, 126, 70, 55),
(64, 233, 71, 55),
(65, 126, 71, 55),
(66, 120, 71, 55),
(67, 262, 75, 65),
(68, 291, 80, 70),
(69, 227, 64, 60);

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmt` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `gmt`, `name`) VALUES
(1, '5.0', '(GMT +5:00) Ekaterinburg'),
(2, '4.5', '(GMT +4:30) Kabul'),
(3, '4.0', '(GMT +4:00) Abu Dhabi'),
(4, '3.5', '(GMT +3:30) Tehran'),
(5, '3.0', '(GMT +3:00) Baghdad'),
(6, '2.0', '(GMT +2:00) Kaliningrad'),
(7, '1.0', '(GMT +1:00 hour) Brussels'),
(8, '-12.0', '(GMT -12:00) Eniwetok'),
(9, '-11.0', '(GMT -11:00) Midway Island'),
(10, '-10.0', '(GMT -10:00) Hawaii'),
(11, '-9.0', '(GMT -9:00) Alaska'),
(12, '-8.0', '(GMT -8:00) Pacific Time (US and Canada)'),
(13, '-7.0', '(GMT -7:00) Mountain Time (US and Canada)'),
(14, '-6.0', '(GMT -6:00) Central Time (US and Canada)'),
(15, '-5.0', '(GMT -5:00) Eastern Time (US and Canada)'),
(16, '-4.0', '(GMT -4:00) Atlantic Time (Canada)'),
(17, '-3.5', '(GMT -3:30) Newfoundland'),
(18, '-3.0', '(GMT -3:00) Brazil'),
(19, '-2.0', '(GMT -2:00) Mid-Atlantic'),
(20, '-1.0', '(GMT -1:00 hour) Azores'),
(21, '0.0', '(GMT) Western Europe Time'),
(22, '5.5', '(GMT +5:30) Bombay'),
(23, '5.75', '(GMT +5:45) Kathmandu'),
(24, '6.0', '(GMT +6:00) Almaty'),
(25, '7.0', '(GMT +7:00) Bangkok'),
(26, '8.0', '(GMT +8:00) Beijing'),
(27, '9.0', '(GMT +9:00) Tokyo'),
(28, '9.5', '(GMT +9:30) Adelaide'),
(29, '10.0', '(GMT +10:00) Eastern Australia'),
(30, '11.0', '(GMT +11:00) Magadan'),
(31, '12.0', '(GMT +12:00) Auckland');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `addrsline1` text,
  `addrsline2` text,
  `user_type_id` tinyint(5) NOT NULL,
  `totalspace` double NOT NULL DEFAULT '0' COMMENT '//space in Bytes assigned to a user',
  `usedspace` double NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '//IT will be usefull to get all the students who are under the same admin domain',
  `timezone` varchar(200) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `aboutme` text,
  `status` tinyint(5) NOT NULL DEFAULT '0' COMMENT '0 - not validated, 2 suspend account',
  `package_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0' COMMENT '0 = By Registration',
  `created` date DEFAULT NULL,
  `lastmodified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiryofsubscription` date DEFAULT NULL,
  `sitetitle` varchar(255) DEFAULT NULL,
  `profilepic` varchar(255) DEFAULT NULL,
  `logopic` varchar(255) DEFAULT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'when user last logged out',
  `trialpackage` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=310 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `firstname`, `lastname`, `addrsline1`, `addrsline2`, `user_type_id`, `totalspace`, `usedspace`, `admin_id`, `timezone`, `state`, `city`, `country`, `zipcode`, `aboutme`, `status`, `package_id`, `created_by`, `created`, `lastmodified`, `expiryofsubscription`, `sitetitle`, `profilepic`, `logopic`, `lastlogin`, `trialpackage`) VALUES
(1, 'amit.l@idsil.com', 'amit.luthra', '5416d7cd6ef195a0f7622a9c56b55e84', 'Amit', 'Luthra', 'H.No-5043,', '', 1, 53687091230, 15876399, 0, '-8.0', 'AL', 'Chandigarh', 'India', '16001', NULL, 1, 7, 0, '2011-02-24', '2011-09-12 06:37:08', '2011-03-26', 'amitl', 'user_img_1305529369.jpg', NULL, '2011-09-12 06:37:08', 0),
(207, 'kumar12@mailinator.com', 'kumark', '827ccb0eea8a706c4c34a16891f84e7b', 'kumar', 'k', NULL, NULL, 4, 0, 0, 67, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 67, '2011-03-31', '2011-04-06 17:38:31', NULL, '112321asdas', NULL, NULL, '2011-04-06 17:33:32', 0),
(208, 'sham12@mailinator.com', 'sham', '827ccb0eea8a706c4c34a16891f84e7b', 'sdfsdf', 'sdfsdf', NULL, NULL, 4, 0, 0, 67, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 67, '2011-03-31', '2011-04-06 16:53:26', NULL, '123sdfsd', NULL, NULL, '2011-04-06 16:48:27', 0),
(209, 'honey@idisl.comc', 'honey', 'b60eb83bf533eecf1bde65940925a981', 'honey', 'honey', '2222', '', 1, 32212254720, 0, 0, '-8.0', 'AL', '14312543264567457437457', 'United States', '27564', NULL, 3, 7, 0, '2011-04-01', '2011-07-01 10:14:09', '2011-05-01', 'honey', NULL, NULL, '2011-04-01 16:04:03', 0),
(210, 'h@idsil.com', 'honey1', '832c82df2d7a41f0b263bd937a7262a0', 'honey1', 'honey1', '77777', '', 1, 32212254720, 0, 0, '-8.0', 'AL', '777777', 'United States', '77777', NULL, 2, 7, 0, '2011-04-01', '2011-07-01 10:14:09', '2011-05-01', 'honey1', NULL, NULL, '2011-04-01 16:50:04', 0),
(211, 'guardiansss@wer.com', 'guardiansss', '68c79824d56b69105779fba077341c85', 'guardiansss', 'guardiansss', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 7, '2011-04-01', '2011-04-01 22:02:59', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(212, 'guardiansssss@wer.com', 'guardiansssss', 'b79b8c2520509e99e056fd5a280b1e2c', 'guardiansssss', 'guardiansssss', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 7, '2011-04-01', '2011-04-01 22:03:47', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(213, 'dsdsdsdsss@wer.com', 'dsdsdsdsss', 'd6defa19f7920b3d0cfcc7f9831e69aa', 'dsdsdsdsss', 'dsdsdsdsss', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 7, '2011-04-01', '2011-04-19 17:55:13', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(214, 'dsdsdsdsss1@wer.com', 'dsdsdsdsss1', 'd6defa19f7920b3d0cfcc7f9831e69aa', 'dsdsdsdsss', 'dsdsdsdsss', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 7, '2011-04-01', '2011-04-01 22:07:16', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(215, 'dsdsdsdsss12@wer.com', 'dsdsdsdsss12', 'd6defa19f7920b3d0cfcc7f9831e69aa', 'dsdsdsdsss', 'dsdsdsdsss', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 7, '2011-04-01', '2011-04-01 22:09:58', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(216, 'dsdsdsdsss121@wer.com', 'dsdsdsdsss121', 'd6defa19f7920b3d0cfcc7f9831e69aa', 'dsdsdsdsss', 'dsdsdsdsss', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 7, '2011-04-01', '2011-04-19 17:53:17', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(217, 'djdjdjdjjdjjdd@wer.com', 'djdjdjdjjdjjdd', 'a751aa0d02dadf5441d5a620170a0adb', 'djdjdjdjjdjjdd', 'djdjdjdjjdjjdd', NULL, NULL, 6, 0, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, 7, '2011-04-01', '2011-04-19 18:00:07', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(218, 'nsberrow@gmail.com', 'nsbrown', '43ca154c0878dbad8b57cabd33a6b3ed', 'Neil', 'Berrow', NULL, NULL, 2, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 0, 1, '2011-04-01', '2011-05-17 10:22:17', NULL, 'nsbrown', 'user_img_1302893769.jpg', NULL, '2011-04-02 00:40:11', 0),
(219, 'neil.berrow@stminverltd.com', 'mrberrow', '6ed61d4b80bb0f81937b32418e98adca', 'Nigel', 'Brown', NULL, NULL, 7, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-04-01', '2011-09-12 10:54:54', NULL, 'mrberrow', NULL, NULL, '2011-09-12 10:54:54', 0),
(220, 'n_s_brown@yahoo.co.uk', 'StevenBrown', '6ed61d4b80bb0f81937b32418e98adca', 'Steven', 'Brown', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-04-03', '2011-04-04 00:05:53', NULL, 'steven', NULL, NULL, '2011-04-04 00:01:22', 0),
(223, 'student_amit@yopmail.com', 'student_amit', 'e10adc3949ba59abbe56e057f20f883e', 'student', 'amit', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 0, 1, '2011-04-04', '2011-04-19 17:58:17', NULL, 'studentamit', NULL, NULL, '2011-04-18 15:35:24', 0),
(224, 'addNewUser@wer.com', 'addNewUser', '930cfc18d6214e92fd633c015c573d4e', 'addNewUser', 'addNewUser', NULL, NULL, 5, 0, 0, 7, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 6, 7, '2011-04-04', '2011-07-01 10:13:51', NULL, NULL, NULL, NULL, '2011-04-04 22:14:16', 0),
(225, 'addNewUse1r@wer.com', 'addNewUser1', '930cfc18d6214e92fd633c015c573d4e', 'addNewUser', 'addNewUser1', NULL, NULL, 5, 0, 0, 7, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 6, 7, '2011-04-04', '2011-07-01 10:13:51', NULL, NULL, NULL, NULL, '2011-04-04 22:14:48', 0),
(226, 'testuser@wer.com', 'testuser', '5d9c68c6c50ed3d02a2fcf54f63993b6', 'testuser', 'testuser', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-04-04', '2011-04-04 23:25:53', NULL, NULL, NULL, NULL, '2011-04-04 23:21:12', 0),
(227, 'rknaggs@parklands.co.za', 'rknaggs', '5f4dcc3b5aa765d61d8327deb882cf99', 'Richard', 'Knaggs', NULL, NULL, 2, 0, 0, 1, '0.0', NULL, NULL, NULL, NULL, 'I am the IT director at Parklands', 1, 0, 1, '2011-04-04', '2011-04-25 21:02:27', NULL, 'Parklands', 'user_img_1301929325.jpg', NULL, '2011-04-05 01:23:41', 0),
(228, 'neilberrow@hotmail.com', 'sbrown', '4c04b64ffc1897f56e4568a9d8d01959', 'Steven', 'Brown', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 0, 1, '2011-04-04', '2011-05-17 10:24:09', NULL, NULL, NULL, NULL, '2011-04-05 01:24:26', 0),
(232, 'jyoti.g@idsil.com', 'yogesh', '827ccb0eea8a706c4c34a16891f84e7b', 'yogesh', 'kundu', 'sdadas', 'dasdasd', 3, 21474836480, 83794, 0, '-8.0', 'asdasd', 'asdasd', 'Barbados', '12121', NULL, 1, 5, 0, '2011-04-11', '2011-07-01 10:13:19', '2011-06-10', '12vcxc', 'user_img_1302871420.jpg', NULL, '2011-04-18 15:50:39', 0),
(233, 'sandeep.k@idsil.com', 'sandeep', '827ccb0eea8a706c4c34a16891f84e7b', 'sandeep', 'k', NULL, NULL, 2, 0, 0, 67, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 67, '2011-04-11', '2011-04-11 15:40:37', NULL, NULL, NULL, NULL, '2011-04-11 15:34:47', 0),
(234, 'amit.k@idsil.com', 'amit.k', '827ccb0eea8a706c4c34a16891f84e7b', 'amit', 'k', NULL, NULL, 4, 0, 0, 67, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 67, '2011-04-12', '2011-04-12 17:11:19', NULL, NULL, NULL, NULL, '2011-04-12 17:05:18', 0),
(238, 'mainpal@mailinator.com', 'main', '827ccb0eea8a706c4c34a16891f84e7b', 'main', 'pal', NULL, NULL, 4, 0, 0, 232, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 232, '2011-04-15', '2011-04-15 15:38:52', NULL, NULL, NULL, NULL, '2011-04-15 15:32:20', 0),
(240, 'wwwwwwwwww@wer.com', 'wwwwwwwwww', 'd062966d7430a08420ebbc401e98d09c', 'wwwwwwwwww', 'wwwwwwwwww', NULL, NULL, 5, 0, 0, 7, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 6, 7, '2011-04-18', '2011-07-01 10:13:51', NULL, 'wwwwwwwwww', NULL, NULL, '0000-00-00 00:00:00', 0),
(241, 'reeeee@wer.com', 'reeeee', '2bd7bb2fec2195182d458580c07d13b8', 'reeeee', 'reeeee', 'Address Line 1', '', 1, 1395864371200, 0, 0, '-8.0', 'AL', '3232', 'United States', '32323', NULL, 3, 7, 0, '2011-04-18', '2011-07-01 10:14:09', '2011-05-18', 'reeeee', NULL, NULL, '2011-04-18 15:54:16', 0),
(242, 'dsdsdsds@wer.com', 'dsdsdsds', 'e004202ff1930400fd8302cdc49523e3', 'dsdsdsds', 'dsdsdsds', 'Address Line 1', '', 1, 1395864371200, 0, 0, '-8.0', 'AL', 'City', 'United States', '12345', NULL, 3, 7, 0, '2011-04-19', '2011-07-01 10:14:09', '2011-05-19', 'dsdsdsds', NULL, NULL, '2011-04-19 19:57:13', 0),
(243, 'jatinder.k@dfs.com', 'ravan1', '827ccb0eea8a706c4c34a16891f84e7b', 'ravan1', 'k', 'sadsadasas', 'dasdsadasd', 1, 1395864371200, 0, 0, '-8.0', 'AL', 'fdsfsd', 'United States', '12121', NULL, 1, 7, 0, '2011-04-19', '2011-07-01 10:14:09', '2011-05-19', '12432', NULL, NULL, '2011-04-19 20:21:05', 0),
(247, 'indddiii@wer.com', 'indddiii', '2173be7bb4b9d607df9f520f44f27404', 'indddiii', 'indddiii', 'Address Line 1', 'Address Line 2', 5, 210453397504, 192512, 0, '-8.0', 'AL', 'City', 'United States', '43333', NULL, 1, 6, 0, '2011-04-25', '2011-07-01 10:13:51', '2011-06-24', 'indddiii', NULL, NULL, '2011-04-25 17:12:17', 0),
(248, 'manuuueu@wer.com', 'manuuueu', '692a2b4fe4d98e9b1b0c2abd0d7ba219', 'manuuueu', 'manuuueu', NULL, NULL, 5, 1073741824, 0, 247, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 6, 247, '2011-04-25', '2011-07-01 10:13:51', NULL, NULL, NULL, NULL, '2011-04-25 16:27:20', 0),
(249, 'manuuueu222@wer.com', 'manuuueu222', '9a86c1dfd9f7f45e43b089b69af7dcda', 'manuuueu222', 'manuuueu222', NULL, NULL, 5, 1073741824, 0, 247, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 6, 247, '2011-04-25', '2011-07-01 10:13:51', NULL, NULL, NULL, NULL, '2011-04-25 16:27:42', 0),
(250, 'hhhhhhh@wer.com', 'hhhhhhh', 'b5c75e6bbcfcd0e6520b5f1419ded614', 'hhhhhhh', 'hhhhhhh', NULL, NULL, 5, 1073741824, 0, 247, '-8.0', NULL, NULL, NULL, NULL, NULL, 3, 6, 247, '2011-04-25', '2011-07-01 10:13:51', NULL, NULL, NULL, NULL, '2011-04-25 17:37:42', 0),
(252, 'dsdsdsdsds@wer.com', 'dsdsdsdsds', 'd35a276174459bb0581d88c4e4143790', 'dsdsdsdsds', 'dsdsdsdsds', 'Address Line 1', 'Address Line 2', 1, 1395864371200, 0, 0, '-8.0', 'AL', 'City', 'United States', '3232', NULL, 1, 7, 0, '2011-04-25', '2011-07-01 10:14:09', '2011-05-25', 'dsdsdsdsds', NULL, NULL, '2011-04-25 20:38:35', 1),
(253, 'testingg@wer.com', 'testingg', 'ffa9cfc80b0fa37dbc24ad22f275d051', 'testingg', 'testingg', 'Address Line 1', 'Address Line 2', 1, 44023414784, 0, 0, '-8.0', 'AL', 'City', 'United States', '32323', NULL, 1, 7, 0, '2011-04-25', '2011-07-01 10:14:09', '2011-06-24', 'testingg', NULL, NULL, '2011-04-25 21:05:05', 0),
(254, 'freeEducator@wer.com', 'freeEducator', 'f2e346d56efe32fcf94ccdebe528b6dc', 'freeEducator', 'freeEducator', 'Address Line 1', '', 3, 1073741824, 0, 0, '-8.0', 'AL', '34343', 'United States', '4343', NULL, 1, 5, 0, '2011-04-25', '2011-07-01 10:13:19', '2011-06-24', 'freeEducator', NULL, NULL, '2011-04-25 22:49:42', 0),
(255, 'testFree@wer.com', 'testFree', '4368a89516410fb8c99dc0a0f3728073', 'testFree', 'testFree', 'Address Line 1', '', 3, 3221225472, 0, 0, '-8.0', 'AL', 'City', 'United States', '32131', NULL, 1, 5, 0, '2011-04-25', '2011-07-01 10:13:19', '2011-06-24', 'testFree', NULL, NULL, '2011-04-25 23:08:40', 0),
(256, 'vcvcvcvc@wer.com', 'vcvcvcvc', '488009ef111d7cbf9d02e968bd144b90', 'vcvcvcvc', 'vcvcvcvc', 'Address Line 1', 'Address Line 2', 1, 1073741824, 0, 0, '-8.0', 'AL', '34343', 'United States', '43333', NULL, 1, 7, 0, '2011-04-25', '2011-07-01 10:14:09', '2011-05-25', 'vcvcvcvc', NULL, NULL, '2011-04-25 23:22:33', 0),
(257, 'vcvcvcvc@wer.com', 'vcvcvcvc', '488009ef111d7cbf9d02e968bd144b90', 'vcvcvcvc', 'vcvcvcvc', 'Address Line 1', 'Address Line 2', 1, 1073741824, 0, 0, '-8.0', 'AL', '34343', 'United States', '43333', NULL, 1, 7, 0, '2011-04-25', '2011-07-01 10:14:09', '2011-05-25', 'vcvcvcvc', NULL, NULL, '2011-04-25 23:23:08', 0),
(258, 'freeAdminTrial@wer.com', 'freeAdminTrial', '39f9516d0e23343af272fb25f47f4f89', 'freeAdminTrial', 'freeAdminTrial', 'Address Line 1', 'Address Line 2', 3, 3221225472, 0, 0, '-8.0', 'AL', 'City', 'United States', '32132', NULL, 1, 5, 0, '2011-04-26', '2011-07-01 10:13:19', '2011-05-26', 'freeAdminTrial', NULL, NULL, '2011-04-26 15:01:05', 0),
(259, 'freeTrialEducator@wer.com', 'freeTrialEducator', '5416d7cd6ef195a0f7622a9c56b55e84', 'freeTrialEducator', 'freeTrialEducator', 'Address Line 1', 'Address Line 2', 3, 1073741824, 0, 0, '3.5', 'AL', 'City', 'United States', '43333', NULL, 1, 5, 0, '2011-04-26', '2011-07-01 10:13:19', '2011-06-25', 'freeTrialEducator', NULL, NULL, '2011-04-26 15:28:55', 1),
(260, 'manutestaccountss@wer.com', 'manutestaccountss', '5416d7cd6ef195a0f7622a9c56b55e84', 'manutestaccountss', 'manutestaccountss', 'Address Line 1', '', 5, 1073741824, 0, 0, '-8.0', 'AL', 'City', 'United States', '32131', NULL, 1, 6, 0, '2011-04-26', '2011-07-01 10:13:51', '2011-05-26', 'manutestaccountss', NULL, NULL, '2011-04-26 16:02:27', 1),
(261, 'trialpackageuu@yopmail.com', 'trialpackageuu', '7debe8bc6a8b9b8e850c6e078309a779', 'trialpackageuu', 'trialpackageuu', 'Address Line 1', 'Address Line 2', 1, 1073741824, 0, 0, '-8.0', 'AL', 'City', 'United States', '34343', NULL, 1, 7, 0, '2011-05-09', '2011-07-01 10:14:09', '2011-06-08', 'trialpackageuu', NULL, NULL, '2011-05-09 16:26:52', 1),
(262, 'markr@yopmail.com', 'markr', 'e10adc3949ba59abbe56e057f20f883e', 'Mark', 'Robinson', NULL, NULL, 2, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-05-19', '2011-05-19 06:23:16', NULL, 'Mark', NULL, NULL, '2011-05-19 06:23:16', 0),
(263, 'addNewUserss@yopmail.com', 'addNewUserss', 'e8d355885bf9cf7aaecf99ef84c6ecbf', 'addNewUserss', 'addNewUserss', NULL, NULL, 2, 0, 0, 7, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 7, '2011-05-20', '2011-05-20 06:28:59', NULL, NULL, NULL, NULL, '2011-05-20 06:28:59', 0),
(264, 'freetrial@yopmail.com', 'freetrial', '766b70c23f307b1ff461b21365abb9fa', 'freetrial', 'freetrial', 'Address Line 1', '', 1, 1073741824, 0, 0, '-8.0', 'AL', 'City', 'United States', '3222', NULL, 1, 7, 0, '2011-05-20', '2011-07-01 10:14:09', '2011-06-19', 'freetrial', NULL, NULL, '2011-05-20 06:50:35', 1),
(265, 'stpeters@yopmail.com', 'stpeters', '00ba4353564367fb4c04709506de31f5', 'stpeters', 'stpeters', 'ddress Line 1', 'Address Line 2', 1, 1073741824, 0, 0, '-8.0', 'AL', 'City*', 'United States', '1211', NULL, 1, 7, 0, '2011-05-27', '2011-07-01 10:14:09', '2011-06-26', 'stpeters', NULL, NULL, '2011-05-27 14:12:03', 1),
(266, 'cloudstudent03@yahoo.com', 'cloudstudent03', '6ed61d4b80bb0f81937b32418e98adca', 'Jimmy ', 'Tylor', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-05-27', '2011-07-13 12:20:36', NULL, NULL, NULL, NULL, '2011-07-13 12:20:36', 0),
(267, 'testingusers@yopmail.com', 'testingusers', 'cce3ad35929abcae915c04f0d66a5194', 'testingusers', 'testingusers', 'Address Line 1', 'Address Line 2', 3, 5368709120, 0, 0, '-8.0', 'AL', 'City', 'United States', '1211', NULL, 1, 5, 0, '2011-05-30', '2011-07-01 10:13:19', '2011-06-29', 'testingusers', NULL, NULL, '2011-05-30 10:38:06', 1),
(268, 'teststudentuser@yopmail.com', 'teststudentuser', '3e6c7a14818399e569ffd99255341cc2', 'teststudentuser', 'teststudentuser', NULL, NULL, 4, 0, 0, 267, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 267, '2011-05-30', '2011-05-30 10:02:49', NULL, NULL, NULL, NULL, '2011-05-30 10:02:49', 0),
(270, 'iuiuiu@ghg.com', 'jimmy', '6ed61d4b80bb0f81937b32418e98adca', 'jimmyd', 'deli', 'Casares', '', 3, 21474836480, 1152884, 0, '-8.0', 'Malaga', 'Malaga', 'Spain', '29631', 'jhjhghghghjg hjghjgjhghjg jhgjhghjgjhg jgjhghj \n\n\n\nkjhkghghg\n\n\nhhvmbnvmn', 1, 5, 0, '2011-05-31', '2011-07-04 10:34:18', '2011-07-30', 'jimmy', NULL, NULL, '2011-07-04 10:34:18', 1),
(272, 'dddddd@wer.com', 'dddddd', '980ac217c6b51e7dc41040bec1edfec8', 'dddddd', 'dddddd', 'Address Line 1*', 'Address Line 2', 1, 1395864371200, 0, 0, '-8.0', 'AL', '1232', 'United States', '1211', NULL, 1, 7, 0, '2011-06-01', '2011-07-01 10:14:09', '2011-07-01', 'dddddd', NULL, NULL, '2011-06-01 06:38:16', 0),
(274, 'testwithunlimited@yopmail.com', 'testwithunlimited', '3f7abc7e020e33acdbd77c731f3c9fdc', 'testwithunlimited', 'testwithunlimited', 'Address Line 1', '', 1, 1395864371200, 237480, 0, '-8.0', 'AL', 'City', 'United States', '1211', NULL, 1, 7, 0, '2011-06-06', '2011-07-05 10:24:06', '2011-07-06', 'testwithunlimited', NULL, NULL, '2011-06-06 11:34:24', 0),
(278, 'stud@yopmail.com', 'stud', 'e10adc3949ba59abbe56e057f20f883e', 'Stu', 'Stu', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-06-08', '2011-06-08 07:21:18', NULL, NULL, NULL, NULL, '2011-06-08 07:21:18', 0),
(279, 'cloudstudent04@yahoo.com', 'timmy', '6ed61d4b80bb0f81937b32418e98adca', 'Timmy', 'Bell', NULL, NULL, 4, 0, 0, 270, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 270, '2011-06-08', '2011-07-04 10:25:32', NULL, NULL, NULL, NULL, '2011-07-04 10:25:32', 0),
(280, 'cloudstudent05@yahoo.com', 'james', '6ed61d4b80bb0f81937b32418e98adca', 'James', 'Jones', NULL, NULL, 4, 0, 0, 270, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 270, '2011-06-08', '2011-06-08 21:24:10', NULL, NULL, NULL, NULL, '2011-06-08 21:24:10', 0),
(281, 'cloudstudent06@yahoo.com', 'billy', '6ed61d4b80bb0f81937b32418e98adca', 'Billy', 'Jean', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 219, '2011-06-13', '2011-07-01 16:32:59', NULL, NULL, NULL, NULL, '2011-07-01 16:32:59', 0),
(284, 'freestudent@wer.com', 'freestudent', '8653c2176bf0a713cd45ac797783d21a', 'freestudent', 'freestudent', 'Line 1', 'Address Second', 5, 128849018880, 0, 0, '-8.0', 'AL', 'City', 'United States', '1211', NULL, 1, 6, 0, '2011-07-01', '2011-07-01 10:13:51', NULL, 'freestudent', NULL, NULL, '2011-07-01 10:02:56', 0),
(285, 'admintestforstudent@wer.com', 'admintestforstudent', '0254b8d56b36a2ef526e3e74113bdcef', 'admintestforstudent', 'admintestforstudent', NULL, NULL, 5, 128849018880, 0, 0, '-8.0', 'AL', NULL, NULL, NULL, NULL, 1, 6, 0, '2011-07-01', '2011-07-01 10:28:20', NULL, 'admintestforstudent', NULL, NULL, '2011-07-01 10:25:44', 0),
(286, 'cloudstudent08@yahoo.com', 'steviejones', '6ed61d4b80bb0f81937b32418e98adca', 'Steven', 'Jones', NULL, NULL, 5, 53687091200, 101983, 0, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 3, 0, '2011-07-01', '2011-07-04 10:26:18', NULL, 'stevie', NULL, NULL, '2011-07-04 10:26:18', 0),
(291, 'aEducator@wer.com', 'aEducator', 'b7bfb35f1fda1e8fef8d43316740ec7d', 'aEducator', 'l', NULL, NULL, 2, 0, 0, 274, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 274, '2011-07-05', '2011-07-05 10:25:10', NULL, NULL, NULL, NULL, '2011-07-05 10:25:10', 0),
(292, 'aStudent1@wer.com', 'aStudent1', 'dfff57701899bb3b66f7f33d4d5082ec', 'aStudent1', 's', NULL, NULL, 4, 0, 0, 274, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 274, '2011-07-05', '2011-07-05 10:25:34', NULL, NULL, NULL, NULL, '2011-07-05 10:25:34', 0),
(294, 'newtestuser@yopmail.com', 'newtestuser', 'f375a132f84de55f2564b2b355b32840', 'newtestuser', 'newtestuser', NULL, NULL, 5, 53687091200, 0, 0, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 3, 0, '2011-07-05', '2011-07-05 12:54:12', NULL, 'newtestuser', NULL, NULL, '2011-07-05 12:54:12', 0),
(295, 'Jane_Hoskyn@parklands.co.za', 'jhoskyn', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jane', 'Hoskyn', NULL, NULL, 2, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-07-14', '2011-08-26 07:54:01', NULL, NULL, 'user_img_1314352441.png', NULL, '2011-08-26 07:05:44', 0),
(296, 'peterpiper02@gmail.com', 'peterpiper', '859fe982e6d07fd740cc68fb8816afef', 'Peter', 'Piper :)', NULL, NULL, 5, 53687091200, 61358, 0, '-8.0', NULL, NULL, NULL, NULL, 'ghghjghg', 1, 3, 0, '2011-07-19', '2011-07-19 17:25:48', NULL, 'peter', NULL, NULL, '2011-07-19 17:24:16', 0),
(297, 'samberrow@gmail.com', 'samberrow', '6ed61d4b80bb0f81937b32418e98adca', 'Sam', 'Berrow', NULL, NULL, 3, 21474836480, 72633, 0, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 4, 0, '2011-07-19', '2011-07-19 21:22:26', NULL, 'mrsberrow', NULL, NULL, '2011-07-19 21:22:26', 0),
(298, 'cloudstudent07@yahoo.com', 'neilb', '6ed61d4b80bb0f81937b32418e98adca', 'Neil', 'Berown', NULL, NULL, 4, 0, 0, 297, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 297, '2011-07-19', '2011-07-19 17:29:59', NULL, NULL, NULL, NULL, '2011-07-19 17:29:59', 0),
(299, NULL, '', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2011-08-26', '2011-08-26 07:15:17', NULL, NULL, NULL, NULL, '2011-08-26 07:15:17', 0),
(300, 'testerr@wer.com', 'testerr', '84a9de180e0ea617561ae8abb256084f', 'testerr', 'testerr', NULL, NULL, 3, 21474836480, 0, 0, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 4, 0, '2011-08-26', '2011-08-26 07:20:22', NULL, 'testerr', NULL, NULL, '2011-08-26 07:20:22', 0),
(301, 'sandeep@yopmail.com', 'sandeeps', '80189d37a075ed508a99b026d81e75f5', 'Sandeep', 'S', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-09-09', '2011-09-09 06:58:20', NULL, NULL, NULL, NULL, '2011-09-09 06:58:20', 0),
(302, 'manuedutcaor@yopmail.com', 'ManuEdutcaor', 'cbb33a637c1187cbae0d34104faaafff', 'ManuEdutcaor', 'd', NULL, NULL, 2, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 1, '2011-09-09', '2011-09-09 07:10:57', NULL, NULL, NULL, NULL, '2011-09-09 07:10:57', 0),
(303, 'cloudpollen@gmail.com', 'billyphilly', '6ed61d4b80bb0f81937b32418e98adca', 'Billy', 'Philly', NULL, NULL, 4, 0, 0, 1, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 219, '2011-09-09', '2011-09-09 16:32:17', NULL, NULL, 'user_img_1315593137.jpg', NULL, '2011-09-09 16:31:14', 0),
(304, 'samberrowteacher@gmail.com', 'samberrowteacher', '6ed61d4b80bb0f81937b32418e98adca', 'Sam', 'Berrow', NULL, NULL, 3, 21474836480, 1466850, 0, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 4, 0, '2011-09-09', '2011-09-12 08:20:26', NULL, 'samberrowteacher', NULL, NULL, '2011-09-12 08:20:26', 0),
(305, 'aaronberrow@gmail.com', 'aaronberrow', '6ed61d4b80bb0f81937b32418e98adca', 'Aaron', 'Berrow', NULL, NULL, 4, 0, 0, 304, '-8.0', NULL, NULL, NULL, NULL, NULL, 1, 0, 304, '2011-09-09', '2013-02-05 16:45:58', NULL, 'Aaron', NULL, NULL, '2011-09-10 13:47:03', 0),
(306, 'neilberrowparent@hotmail.com', 'neilberrowparent', '6ed61d4b80bb0f81937b32418e98adca', 'Neil', 'Berrow', NULL, NULL, 6, 0, 0, 304, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 304, '2011-09-09', '2011-09-09 16:52:00', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(307, NULL, '', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2011-09-12', '2011-09-12 08:34:10', NULL, NULL, NULL, NULL, '2011-09-12 08:34:10', 0),
(308, 'raul@livemobiletechnology.com', 'raul', '90547a1e8264b831cc9006f9826cdaf1d84be322fff039139104374acd62dddb', 'Raul', 'Tran', NULL, NULL, 1, 0, 0, 0, '8.0', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, '2013-02-05 14:36:18', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0),
(309, 'raul@livemobiletechnology.com', 'raul', '90547a1e8264b831cc9006f9826cdaf1d84be322fff039139104374acd62dddb', 'Raul', 'Tran', 'houston', 'houston', 1, 0, 0, 0, '8.0', 'tx', 'houston', 'US', '17043', NULL, 1, 7, 0, '2013-02-05', '2013-02-05 14:38:56', NULL, 'raul', NULL, NULL, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT '1',
  `cansignup` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `title`, `premium`, `cansignup`, `active`) VALUES
(1, 'Administrator', 1, 1, 1),
(2, 'Standard Educator', 1, 0, 1),
(3, 'Premium Educator', 0, 1, 1),
(4, 'Standard Student', 1, 0, 1),
(5, 'Premium Student', 0, 1, 1),
(6, 'Guardian Account', 0, 0, 1),
(7, 'Co-Administrator', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `whiteboards`
--

CREATE TABLE IF NOT EXISTS `whiteboards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `lastmodified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `whiteboards_dc` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `whiteboards`
--

INSERT INTO `whiteboards` (`id`, `title`, `content`, `created_by`, `created`, `lastmodified`, `parent_id`, `admin_id`) VALUES
(42, 'Test baord', '<p>\r\n	sdfsdf dsfsdfds</p>', 1, '2011-03-20 00:00:00', '2011-03-20 08:54:41', 0, 0),
(106, 'Maths revision', '<p>\r\n	This ijfsdifjs sidjfis fj sjdfiopjsd</p>\r\n<p>\r\n	spdjfsdojfopsdj:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ol>\r\n	<li>\r\n		sfsdfsdfsdfsdf</li>\r\n	<li>\r\n		sdfsdfsdfsdfhfgh</li>\r\n	<li>\r\n		<a href="http://test.com" target="_blank">fghfghfghgjgjh</a></li>\r\n</ol>', 1, '2011-04-04 20:29:17', '2011-04-05 01:33:59', 0, 0),
(107, 'Test', '<p>\r\n	This is my Whiteboard</p>', 227, '2011-04-04 20:37:38', '2011-04-05 01:42:20', 0, 0),
(109, 'Trig', '<p>\r\n	Blah blah blah</p>', 270, '2011-06-05 07:51:00', '2011-06-05 12:51:00', 0, 0),
(111, 'Stuff', '<p>\r\n	kjhjhjkhjhjh jhkjh</p>', 297, '2011-07-19 12:47:37', '2011-07-19 17:47:37', 0, 297),
(112, 'Stuff', '<p>\r\n	kjhjhjkhjhjh jhkjh</p>\r\n<p>\r\n	jhjkhjkh</p>', 297, '2011-07-19 12:47:56', '2011-07-19 17:47:56', 111, 297);

-- --------------------------------------------------------

--
-- Table structure for table `whiteboard_comments`
--

CREATE TABLE IF NOT EXISTS `whiteboard_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `whiteboard_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `received_by` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whiteboard_comments_dc` (`whiteboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement_status`
--
ALTER TABLE `announcement_status`
  ADD CONSTRAINT `announcement_status_dc` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classgroup_students`
--
ALTER TABLE `classgroup_students`
  ADD CONSTRAINT `classgroup_students_dc` FOREIGN KEY (`group_id`) REFERENCES `class_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classgroup_students_user_dc` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classgrp_linkedgrps_dc` FOREIGN KEY (`group_id`) REFERENCES `class_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classgrp_linkedgrps_user_dc` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classgrp_linkedgrps`
--
ALTER TABLE `classgrp_linkedgrps`
  ADD CONSTRAINT `classgrp_linkedgrps_dc1` FOREIGN KEY (`group_id`) REFERENCES `class_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classgrp_linkedgrps_user_dc1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coadmin_gaurdians`
--
ALTER TABLE `coadmin_gaurdians`
  ADD CONSTRAINT `coadmin_gaurdians_dc` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coadmin_gaurdians_dcUser` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coadmin_gaurdians_dcuser1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `department_students`
--
ALTER TABLE `department_students`
  ADD CONSTRAINT `department_students_dc` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_students_user_dc` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `department_teachers`
--
ALTER TABLE `department_teachers`
  ADD CONSTRAINT `department_teachers_dc` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_teachers_user_dc` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_students`
--
ALTER TABLE `project_students`
  ADD CONSTRAINT `project_students_prj_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_students_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_tasks`
--
ALTER TABLE `project_tasks`
  ADD CONSTRAINT `task_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `whiteboards`
--
ALTER TABLE `whiteboards`
  ADD CONSTRAINT `whiteboards_dc` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `whiteboard_comments`
--
ALTER TABLE `whiteboard_comments`
  ADD CONSTRAINT `whiteboard_comments_dc` FOREIGN KEY (`whiteboard_id`) REFERENCES `whiteboards` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE files_categories ADD isdefault tinyint(1) NOT NULL DEFAULT 0;
UPDATE files_categories SET isdefault=`default`;
ALTER TABLE files_categories DROP `default`;