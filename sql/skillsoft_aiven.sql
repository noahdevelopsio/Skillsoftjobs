-- Aiven-compatible SQL Import for Skillsoft
-- Fixes: inline PRIMARY KEYs, InnoDB engine, includes Phase 2 columns

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Drop existing tables if re-running
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------
-- Table: applications (with Phase 2 columns: job_id, user_id)
-- --------------------------------------------------------
CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driverlicense_path` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `houseaddress` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `bankno` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_job_id` (`job_id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: jobs (with Phase 2 column: employer_id)
-- --------------------------------------------------------
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employer_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_employer_id` (`employer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Role` varchar(20) NOT NULL DEFAULT 'user',
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Seed data: users
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `Firstname`, `Lastname`, `Username`, `Gender`, `Occupation`, `Role`, `Email`, `Password`) VALUES
(1, 'Noah', 'Enemali', 'rovic', 'Male', 'cchchhhg', 'user', 'noahbig001@gmail.com', '2FTQEGRR');

-- --------------------------------------------------------
-- Seed data: jobs (employer_id = 1 for all seeded jobs)
-- --------------------------------------------------------
INSERT INTO `jobs` (`id`, `employer_id`, `type`, `title`, `description`, `salary`, `location`, `company`, `company_description`, `contact_email`, `contact_phone`) VALUES
(1, 1, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions.', 'careers@newteksolutions.com', '123-456-7890'),
(2, 1, 'Full-Time', 'Data Scientist', 'We are looking for a Data Scientist to join our team in San Francisco, CA.', '$120K - $140K / Year', 'San Francisco, CA', 'Data Insights Inc.', 'Data Insights Inc. is a leading data analytics company.', 'careers@datainsights.com', '415-123-4567'),
(3, 1, 'Full-Time', 'UX/UI Designer', 'We are seeking a talented UX/UI Designer to join our team in New York, NY.', '$80K - $100K / Year', 'New York, NY', 'DesignWorks', 'DesignWorks is a creative agency specializing in UX/UI design.', 'info@designworks.com', '212-987-6543'),
(4, 1, 'Remote', 'DevOps Engineer', 'Join our team as a DevOps Engineer and help us build scalable infrastructure.', '$110K - $130K / Year', 'Remote', 'CloudTech Solutions', 'CloudTech Solutions provides cloud infrastructure and DevOps services.', 'careers@cloudtech.com', '800-555-1234'),
(5, 1, 'Full-Time', 'Marketing Manager', 'We are looking for a Marketing Manager to lead our marketing team in Chicago, IL.', '$90K - $110K / Year', 'Chicago, IL', 'MarketMasters', 'MarketMasters is a full-service marketing agency.', 'info@marketmasters.com', '312-555-6789'),
(6, 1, 'Full-Time', 'Backend Developer (Node.js)', 'We are seeking a Backend Developer with expertise in Node.js to join our team in Austin, TX.', '$95K - $115K / Year', 'Austin, TX', 'CodeCrafters', 'CodeCrafters is a software development company.', 'careers@codecrafters.com', '512-555-4321'),
(7, 1, 'Full-Time', 'Product Manager', 'We are looking for a Product Manager to join our team in Seattle, WA.', '$100K - $120K / Year', 'Seattle, WA', 'Productify', 'Productify is a product management consultancy.', 'info@productify.com', '206-555-5678'),
(8, 1, 'Full-Time', 'Cybersecurity Analyst', 'We are seeking a Cybersecurity Analyst to join our team in Washington, DC.', '$85K - $105K / Year', 'Washington, DC', 'SecureTech', 'SecureTech is a cybersecurity firm.', 'careers@securetech.com', '202-555-7890'),
(9, 1, 'Remote', 'Mobile App Developer (Flutter)', 'Join our team as a Mobile App Developer and work on exciting Flutter-based projects.', '$80K - $100K / Year', 'Remote', 'AppMakers', 'AppMakers builds cross-platform apps using Flutter.', 'info@appmakers.com', '888-555-2345'),
(10, 1, 'Part-Time', 'Content Writer', 'We are looking for a Content Writer to join our team in Los Angeles, CA.', '$40 - $50 / Hour', 'Los Angeles, CA', 'Content Creators Co.', 'Content Creators Co. is a content marketing agency.', 'info@contentcreators.com', '213-555-6789'),
(11, 1, 'Full-Time', 'Customer Support Specialist', 'We are seeking a Customer Support Specialist to join our team in Dallas, TX.', '$45K - $55K / Year', 'Dallas, TX', 'SupportSolutions', 'SupportSolutions provides exceptional customer support services.', 'careers@supportsolutions.com', '214-555-3456'),
(12, 1, 'Remote', 'Personal Assistant', 'We are looking for a highly organized Personal Assistant for our executive team.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading technology provider.', 'careers@newteksolutions.com', '123-456-7890'),
(13, 1, 'Full-Time', 'Senior React Developer', 'We are seeking a talented Senior React Developer to join our team in Boston, MA.', '$70 - $80K / Year', 'Boston, MA', 'Tech Innovators', 'Tech Innovators builds cutting-edge web applications.', 'careers@techinnovators.com', '987-654-3210'),
(14, 1, 'Remote', 'Front-End Engineer (React)', 'Join our team as a Front-End Engineer and work on impactful projects.', '$70K - $80K / Year', 'Miami, FL', 'Sunshine Tech', 'Sunshine Tech creates innovative web applications.', 'info@sunshinetech.com', '555-123-4567'),
(15, 1, 'Remote', 'React.js Developer', 'We are looking for a skilled React.js Developer to build and maintain web UIs.', '$70K - $80K / Year', 'Brooklyn, NY', 'Creative Solutions', 'Creative Solutions delivers exceptional digital experiences.', 'hello@creativesolutions.com', '222-333-4444'),
(16, 1, 'Part-Time', 'React Front-End Developer', 'Join our team as a Part-Time Front-End Developer in Phoenix, AZ.', '$60 - $70K / Year', 'Phoenix, AZ', 'Desert Tech', 'Desert Tech provides innovative tech solutions.', 'jobs@deserttech.com', '111-222-3333'),
(17, 1, 'Full-Time', 'Full Stack React Developer', 'Exciting opportunity for a Full Stack React Developer in Atlanta, GA.', '$90K - $100K / Year', 'Atlanta, GA', 'Metro Tech', 'Metro Tech specializes in full-stack development.', 'careers@metrotech.com', '444-555-6666'),
(18, 1, 'Remote', 'React Native Developer', 'Join our team as a React Native Developer for cross-platform mobile apps.', '$100K - $110K / Year', 'Portland, OR', 'Green Tech', 'Green Tech builds sustainable and innovative tech solutions.', 'info@greentech.com', '777-888-9999');

COMMIT;
