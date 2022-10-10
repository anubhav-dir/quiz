
--
-- Table structure for table `tbl_quiz_level`
--

DROP TABLE IF EXISTS `tbl_quiz_level`;
CREATE TABLE `tbl_quiz_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(64) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `state_id` int(11) DEFAULT 1,
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz_level_created_by_id`
  FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_level_updated_by_id`
  FOREIGN KEY (`updated_by_id`) REFERENCES `tbl_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `tbl_quiz_subject`
--

DROP TABLE IF EXISTS `tbl_quiz_subject`;
CREATE TABLE `tbl_quiz_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(64) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `state_id` int(11) DEFAULT 1,
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz_subject_created_by_id`
  FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_subject_updated_by_id`
  FOREIGN KEY (`updated_by_id`) REFERENCES `tbl_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `tbl_quiz_question`
--

DROP TABLE IF EXISTS `tbl_quiz_question`;
CREATE TABLE `tbl_quiz_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `hint` text DEFAULT NULL,
  `state_id` int(11) DEFAULT 1,
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz_question_created_by_id`
  FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_question_updated_by_id`
  FOREIGN KEY (`updated_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_question_level_id`
  FOREIGN KEY (`level_id`) REFERENCES `tbl_quiz_level`(`id`),
  CONSTRAINT `fk_quiz_question_subject_id`
  FOREIGN KEY (`subject_id`) REFERENCES `tbl_quiz_subject`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `tbl_quiz_option`
--

DROP TABLE IF EXISTS `tbl_quiz_option`;
CREATE TABLE `tbl_quiz_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `option` varchar(255) NOT NULL,
  `state_id` int(11) DEFAULT 1,
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz_option_created_by_id`
  FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_option_updated_by_id`
  FOREIGN KEY (`updated_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_option_question_id`
  FOREIGN KEY (`question_id`) REFERENCES `tbl_quiz_question`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `tbl_quiz_correct_answer`
--

DROP TABLE IF EXISTS `tbl_quiz_correct_answer`;
CREATE TABLE `tbl_quiz_correct_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `state_id` int(11) DEFAULT 1,
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz_correct_answer_created_by_id`
  FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_correct_answer_updated_by_id`
  FOREIGN KEY (`updated_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_correct_answer_question_id`
  FOREIGN KEY (`question_id`) REFERENCES `tbl_quiz_question`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `tbl_quiz_answer`
--

DROP TABLE IF EXISTS `tbl_quiz_answer`;
CREATE TABLE `tbl_quiz_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `time_taken` datetime NOT NULL,
  `state_id` int(11) DEFAULT 1,
  `created_on` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz_answer_created_by_id`
  FOREIGN KEY (`created_by_id`) REFERENCES `tbl_user`(`id`),
  CONSTRAINT `fk_quiz_answer_question_id`
  FOREIGN KEY (`question_id`) REFERENCES `tbl_quiz_question`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

