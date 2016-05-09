-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2016 at 10:44 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum_proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` bigint(20) UNSIGNED NOT NULL,
  `comment_text` varchar(1000) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentID`, `comment_text`, `comment_date`) VALUES
(19, 'This is going to depend very heavily one what you mean by firewall. If you mean simple packet filtering then very little will be stopped. If you move on to what has been coined next generation firewall then a considerable amount more will be caught. Modern enterprise "firewalls" include IPS, antivirus, antibot, and other features. All of these features are signature based so they will only catch known threats that may have already hit other organizations. Most security vendors now include sand boxing technologies that attempt to catch zero day threats.', '2016-05-09 19:24:20'),
(20, 'It can have some benefits, but it''s not designed to do so. What it can do is stop a virus from "phoning home", as it were, and help prevent your computer from becoming part of a zombie botnet. That supposes that the virus doesn''t/can''t disable or reconfigure the firewall.', '2016-05-09 19:33:38'),
(21, 'These are the security focused sites I follow in my RSS reader:\r\nAdam Caudills blog https://adamcaudill.com/\r\nMatthew Greens blog http://blog.cryptographyengineering.com/\r\nBruce Schneiers blog https://www.schneier.com/\r\nQualys blog (the company providing SSL Labs) https://community.qualys.com/blogs/securitylabs', '2016-05-09 19:36:16'),
(22, 'Try hacker news. one stop shop for all tech related stuff.', '2016-05-09 19:36:48'),
(23, 'I''m working on a 5e database in sqlite myself...got all the weapons, armor, and items in ...now I need to make a player character table and linker tables to various gear. It''s pretty fun though. - For the record, there is already a 3.5 MySQL database available on the web...I can point it out for you if you like. It seems like it was just a rip of the tables straight out of the books. I''m thinking I''m going to run into trouble when I get to leveling a character (more specifically, storing a character of level X).. but I''ll cross that bridge when I get to it. Let me know if you want to compare notes :)', '2016-05-09 19:40:02'),
(24, 'Have you ever seen Hero Lab?\r\nhttp://www.wolflair.com/index.php?context=hero_lab\r\nLooking at how they implemented that may give you some clues. They, last I looked, had almost all the different rules for the game implemented. In your case, I would really really think you should limit yourself to implementing just the core rules, or even a subset of the core rules, because this rabbit hole gets very very deep very very fast. Something like Fighter, Wizard, Rogue would probably get you down to a reasonable level.\r\nJust looking at your listed tables...\r\nInstead of GM or Player, I would have expected a parent table just for Users. Maybe they are the GM. Maybe they are the player. Maybe they are just some fan of character optimization or whatever.\r\nI would expect the Player and GM relationship to be optional and one to many. A Campaign table might make more sense.\r\nGender just seems like an open text field on a character sheet to me. I guess you might index it so people can search by a spec', '2016-05-09 19:40:38'),
(25, 'One does not simply become a DBA', '2016-05-09 19:43:15'),
(26, 'A good starting point where you might find more success in the job hunt is business intelligence. You can swim in SQL all day long for a few years and hopefully there''s a DBA around who you can learn from. It''s a harsh truth that there are no entry level DBA positions for the most part, because DBA is a critical role, so no one is willing to take a risk on a candidate with no experience.', '2016-05-09 19:44:24'),
(27, 'Nope', '2016-05-09 19:45:37'),
(28, 'I think a more descriptive name is better at least if it''s going to be used as a foreign key in another table.', '2016-05-09 19:46:32'),
(29, 'Pokemon is the best game ever created. I would be disappointed if you don''t buy ever game that has Poke in the title and/or description and play through the entirety of all of them.', '2016-05-09 19:50:48'),
(30, 'Oh, and it might take you forever. Better quit your job and drop out from school. In this case, just buy Skyrim too.', '2016-05-09 19:51:18'),
(31, 'Yes, but demonslab is going a bit overboard with that.', '2016-05-09 19:52:03'),
(32, 'It literally can''t. Neither are out yet. And I promise you a good chunk of those who disliked the trailer will probably buy it anyway.', '2016-05-09 19:53:11'),
(33, 'Yes, they''re indicating preference for the direction each series is currently going. Historic combat vs. hyper-conjectural future war. There''s been like four future CoD games and people have been speaking the fuck up about it.', '2016-05-09 19:53:28'),
(34, 'you should mention price range/bandwidth expected. Almost everyone does this on the high end, almost nobody does it on the low end. I used to do it on the low end, but not anymore, just due to the effort involved. I don''t accept new customers for my $35/month atom hosting deal anymore either, for the same reason, but if you are paying significant bucks? nearly every co-location provider will be able to help you here.', '2016-05-09 19:55:50'),
(35, 'You realize you''re going to give some poor desk attendant a complex.\r\nObviously bananas don''t keep forever so they''ll need to be replaced from time to time.\r\nSo here comes desk person. They saddled with this weird device that hands out the wifi passwords and for all they know it''s powered by bananas.\r\nSo now their work routine includes making sure the wifi banana is fresh, and making sure there are fresh bananas on hand in case replacements are needed.\r\nCan you imagine the conversations this is going to spark?\r\n"Hey boss. I need to run to the store to get more wifi bananas"\r\n"Shit! I forgot to pick up bananas yesterday. The wifi isn''t going to work!"\r\netc.', '2016-05-09 20:00:01'),
(36, 'I have them.', '2016-05-09 20:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postID` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ups` int(11) NOT NULL DEFAULT '0',
  `downs` int(11) NOT NULL DEFAULT '0',
  `tags` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `title`, `content`, `created_date`, `ups`, `downs`, `tags`) VALUES
(11, '[Question] Does a firewall actually protect against viruses?', 'So I have always been taught that a firewall can protect against viruses, but then we need antiviruses, right? So I did some research to try and find out whether firewalls against protect against viruses including worms, spyware, rootkits etc. but there is so much conflicting information.\r\n\r\nSource: \r\nhttps://www.reddit.com/r/security/comments/4iex4l/question_does_a_firewall_actually_protect_against/', '2016-05-09 19:23:07', 0, 0, ''),
(12, 'Amateur and Professional security enthusiasts of Reddit, share with us your go-to outlets for computer related reading/learning.', 'Will be finished with my degree in Comp Sci this next semester and I feel like I know nothing more than when I started. I stand by the policy of emulating those you want to be more like.\r\nSo share with us your favorite subreddits/websites/forums/learning avenues/veteran reference sources.\r\nBasically, I want to know where people who are SERIOUS about their careers/hobby hangout to learn and grow.\r\n\r\nSource: https://www.reddit.com/r/cybersecurity/comments/3xuc77/amateur_and_professional_security_enthusiasts_of/', '2016-05-09 19:35:36', 0, 0, ''),
(13, 'Building a DB for school. Is anyone familiar with the Pathfinder RPG system? ', 'Hiya all.\r\nI''m pretty new to database design, and I''m taking an introductory course at my local JC. For our final project we build our own DB. I ended up choosing the most complicated project out of my 3 ideas.\r\nIf any of you have played Pathfinder or D&D (3.5), then you''ll be better able to understand what I''m working with here.\r\nMy primary goal is to build a DB than can store player-character information and output complete and accurate character sheets (like this one). I have a few secondary goals. Right now I''m still trying to make sure I organize the design properly.\r\nI think I can fill the 1st page of a character sheet pretty well, but I''m unsure of how to handle inventory. Furthermore, if I wanted to get into adding feats and traits, would anyone have any advice on how to handle that?\r\nAny advice or input would be appreciated.\r\nEdit: I''ve X-posted this to the r/Pathfinder_RPG\r\nEdit 2: Screenshots: Relationship design so far\r\n\r\nSource: https://www.reddit.com/r/Database/comments/4ighvi/building_a_db_for_school_is_anyone_familiar_with/', '2016-05-09 19:38:48', 0, 0, ''),
(14, ' Recent Graduate looking to get into database management ', 'I recently graduated and after taking a few introductory courses at school in database development and system design, and working on a few smaller databases in Access. I think that this is the career path I''d like to pursue. I''m finding it hard to find entry level positions in this field, as most jobs require 3-5 years experience and various programming languages. Currently I know the baiscs of SQL and try to write as many SQL statements as possible when building queries in MS Access, and have begun some VBA coding.\r\nHow did you guys get started in database management? What languages are most useful to learn? What sort of jobs should I be looking at to begin in this field?\r\n\r\nSource: https://www.reddit.com/r/Database/comments/4i0r2t/recent_graduate_looking_to_get_into_database/', '2016-05-09 19:41:28', 0, 0, ''),
(15, 'I always include prefix in my primary key. Is this bad?', 'Instead of my primary key being ID, I have it set to user_id\r\ncomment_id, card_id, etc... There''s never a plain old ID or id field. Is this a matter of preference or is there a reason most DB''s I''ve seen use the plain old id ad a primary key?\r\n\r\nSource: https://www.reddit.com/r/Database/comments/4hd3t2/i_always_include_prefix_in_my_primary_key_is_this/', '2016-05-09 19:45:22', 0, 0, ''),
(17, 'Is Pokemon any good?', 'I''m new to gaming, I have no idea.', '2016-05-09 19:49:47', 0, 0, ''),
(18, 'Battlefield 1 trailer hit 1 million likes on youtube. vs Call of Duty: Infinite Warfare has more than a million dislikes. Does that reflect peoples'' actual opinions of the respective games?', 'My opinion from the trailers is that COD:IW looks like the first COD:Modern Warfare and MW2 - but in space. Many of the same animations, the grabbing someone''s hand and being thrown up on a ledge, the running out of a tunnel and up the side of a crater into battle... and there are plenty of space games out there.\r\nBattlefield 1, however, takes a large scale war that was old tactics meets new tech. A visceral war in which 20,000 troops died in one single 20 minute battle - and that wasn''t even the worst of it. A year of combat before helmets were even put in the field. Chlorine gas and no gas masks. Underground combat in tunnels only wide enough for 1 person. two million artillery shells fired in a single attack. Years spent in the much and fire of the trenches, and if it got to you you might be executed for shell shock / cowardice. And it all happened.\r\nWWII gets a ton of press and pop culture nods but WWI was the bloody crucible that created its sequel. FLying around in space and paradoxically doing the same things we''ve seen in other COD games, but with different outfits, seems boring by comparison.\r\nThoughts?\r\n\r\nSource: https://www.reddit.com/r/gaming/comments/4ijaw4/battlefield_1_trailer_hit_1_million_likes_on/', '2016-05-09 19:52:55', 0, 0, ''),
(19, 'Setting up a second router?', 'Hi there,\r\nRecently a family member of mine began to work at home and our router and modem was moved downstairs. Since then I''ve noticed a huge lag when playing videogames upstairs. My console connects wirelessly to the router. On the weekends I move the router back upstairs then move it back before Monday morning.\r\nI want to setup a second router upstairs to avoid having to move the one router back and forth every weekend.\r\nCrash course anyone?\r\nThanks\r\n\r\nSource: https://www.reddit.com/r/networking/comments/4ild5o/setting_up_a_second_router/', '2016-05-09 19:54:21', 0, 0, ''),
(20, 'Dedicated Servers with BGP?', 'Hello all,\r\nI''ve asked this question before and come up with a few great providers. ISPrime and ARP Networks. I am looking for a few more providers to fill our anycast offering. Anyone able to point me at a hosting company that offers dedicated servers with BGP option? We''ve got our own prefixes and use virtual routers etc. etc.\r\nWe are specifically interested in Europe, Asia and South America - I know all can hard to find, but we are also interested in North American providers with a unique BGP blend as well.\r\n\r\nSource: https://www.reddit.com/r/networking/comments/4iglnm/dedicated_servers_with_bgp/', '2016-05-09 19:54:59', 0, 0, ''),
(22, 'WiFi guest access? You gotta touch the banana...', 'I was tasked with setting up a captive portal, and creating 8 hour vouchers in a spreadsheet.\r\nI don''t do spreadsheets.\r\nSo I put the vouchers in a Raspberry PI, and hooked it up to a banana.\r\nWhen you touch the banana, you get an 8 hour voucher for our guest wifi. (the 3 sec timeout is only for demoing)\r\nThe PI has 5000, 8 hour vouchers. We are open ~200 days a year. If we have 10 guests a day, then this will work unattended for a couple of years easily. No more printing of vouchers. No nagging receptionist.\r\nGIF of the banana in action: http://i.imgur.com/RQiqrfd.gifv\r\nCloseup: http://i.imgur.com/HfqaRAJ.jpg\r\n\r\nSource: https://www.reddit.com/r/networking/comments/41j04h/wifi_guest_access_you_gotta_touch_the_banana/', '2016-05-09 19:59:32', 0, 0, ''),
(23, 'Who uses VR?', 'Nobody uses this topic :(', '2016-05-09 20:01:16', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `postID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`postID`, `commentID`) VALUES
(11, 19),
(11, 20),
(12, 21),
(12, 22),
(13, 23),
(13, 24),
(14, 25),
(14, 26),
(13, 27),
(15, 28),
(17, 29),
(17, 30),
(17, 31),
(18, 32),
(18, 33),
(20, 34),
(22, 35),
(20, 36);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `topicID` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`topicID`, `name`) VALUES
(3, 'Cyber Security'),
(2, 'Databases'),
(1, 'Gaming'),
(5, 'Networking'),
(4, 'Virtual Reality');

-- --------------------------------------------------------

--
-- Table structure for table `topic_post`
--

CREATE TABLE `topic_post` (
  `topicID` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topic_post`
--

INSERT INTO `topic_post` (`topicID`, `postID`) VALUES
(3, 11),
(3, 12),
(2, 13),
(2, 14),
(2, 15),
(1, 17),
(1, 18),
(5, 19),
(5, 20),
(5, 22),
(4, 23);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` bigint(20) UNSIGNED NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '2000-01-01 05:00:00',
  `user_type` enum('MEMBER','MODERATOR') NOT NULL DEFAULT 'MEMBER',
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `nickname` varchar(15) DEFAULT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `last_login`, `user_type`, `date_joined`, `email`, `username`, `nickname`, `password`) VALUES
(1, '2000-01-01 05:00:00', 'MODERATOR', '2016-04-07 04:29:15', 'akbuck667@gmail.com', 'demonslab', 'TheD', 'avarizia'),
(2, '2000-01-01 05:00:00', 'MODERATOR', '2016-04-07 04:29:56', 'steven.leighton@maine.edu', 'steve', NULL, 'serka'),
(10, '0000-00-00 00:00:00', 'MEMBER', '2016-05-09 19:22:35', 'ihtmra@yahoo.com', 'ihtmra', '', 'mramp42'),
(11, '0000-00-00 00:00:00', 'MEMBER', '2016-05-09 19:24:08', 'platy@micro.com', 'Platypus', '', 'plasterman'),
(12, '0000-00-00 00:00:00', 'MEMBER', '2016-05-09 19:33:28', 'sam@aol.com', 'samlev', '', 'sammy'),
(13, '0000-00-00 00:00:00', 'MEMBER', '2016-05-09 19:39:43', 'zef@gmail.com', 'zefyear', '', 'zephyr'),
(14, '0000-00-00 00:00:00', 'MEMBER', '2016-05-09 19:43:04', 'chaw@maine.edu', 'ProfChaw', '', 'DBchawmaster'),
(15, '0000-00-00 00:00:00', 'MEMBER', '2016-05-09 19:55:35', 'Pdickens@yahoo.com', 'PhillyD', '', 'networkingIsLife');

-- --------------------------------------------------------

--
-- Table structure for table `user_comment`
--

CREATE TABLE `user_comment` (
  `userID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_comment`
--

INSERT INTO `user_comment` (`userID`, `commentID`) VALUES
(11, 19),
(12, 20),
(2, 21),
(1, 22),
(13, 23),
(10, 24),
(14, 25),
(12, 26),
(12, 27),
(14, 28),
(1, 29),
(1, 30),
(10, 31),
(10, 32),
(12, 33),
(15, 34),
(1, 35),
(1, 36);

-- --------------------------------------------------------

--
-- Table structure for table `user_dislike`
--

CREATE TABLE `user_dislike` (
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_dislike`
--

INSERT INTO `user_dislike` (`userID`, `postID`) VALUES
(12, 11),
(10, 12),
(12, 18);

-- --------------------------------------------------------

--
-- Table structure for table `user_dislike_comment`
--

CREATE TABLE `user_dislike_comment` (
  `userID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_dislike_comment`
--

INSERT INTO `user_dislike_comment` (`userID`, `commentID`) VALUES
(10, 24),
(10, 22),
(12, 23),
(10, 30),
(12, 32),
(1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `user_like`
--

CREATE TABLE `user_like` (
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_like`
--

INSERT INTO `user_like` (`userID`, `postID`) VALUES
(11, 11),
(12, 12),
(2, 12),
(1, 12),
(1, 13),
(13, 13),
(10, 13),
(1, 14),
(2, 14),
(12, 14),
(12, 13),
(14, 15),
(1, 17),
(10, 17),
(15, 20),
(15, 22),
(1, 22),
(1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `user_like_comment`
--

CREATE TABLE `user_like_comment` (
  `userID` int(11) NOT NULL,
  `commentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_like_comment`
--

INSERT INTO `user_like_comment` (`userID`, `commentID`) VALUES
(11, 19),
(12, 20),
(12, 19),
(1, 21),
(13, 23),
(10, 23),
(10, 21),
(14, 25),
(1, 25),
(2, 25),
(12, 25),
(12, 26),
(12, 24),
(14, 28),
(1, 29),
(1, 30),
(10, 29),
(12, 33),
(15, 34),
(1, 35),
(1, 23),
(1, 34);

-- --------------------------------------------------------

--
-- Table structure for table `user_moderator`
--

CREATE TABLE `user_moderator` (
  `userID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_post`
--

CREATE TABLE `user_post` (
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_post`
--

INSERT INTO `user_post` (`userID`, `postID`) VALUES
(10, 11),
(12, 12),
(1, 13),
(10, 14),
(12, 15),
(2, 17),
(10, 18),
(12, 19),
(2, 20),
(15, 22),
(1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscribe`
--

CREATE TABLE `user_subscribe` (
  `userID` int(11) NOT NULL,
  `postID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_subscribe`
--

INSERT INTO `user_subscribe` (`userID`, `postID`) VALUES
(14, 14),
(2, 14),
(1, 22),
(1, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD UNIQUE KEY `commentID` (`commentID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD UNIQUE KEY `postID` (`postID`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topicID`),
  ADD UNIQUE KEY `topicID` (`topicID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topicID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
