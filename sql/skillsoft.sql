-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.infinityfree.com
-- Generation Time: Nov 20, 2025 at 08:25 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40011505_Skillsoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driverlicense_path` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `houseaddress` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `bankno` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `type`, `title`, `description`, `salary`, `location`, `company`, `company_description`, `contact_email`, `contact_phone`) VALUES
(1, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team. The ideal candidate will have excellent communication skills, the ability to multitask, and a strong attention to detail. Responsibilities include managing schedules, coordinating meetings, handling correspondence, and performing administrative tasks. This is a remote position, so reliable internet and a quiet workspace are required.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions. We specialize in helping businesses streamline their operations and achieve their goals through cutting-edge software and services.', 'careers@newteksolutions.com', '123-456-7890'),
(2, 'Full-Time', 'Data Scientist', 'We are looking for a Data Scientist to join our team in San Francisco, CA. The ideal candidate will have strong skills in data analysis, machine learning, and statistical modeling. Responsibilities include analyzing large datasets, building predictive models, and presenting insights to stakeholders.', '$120K - $140K / Year', 'San Francisco, CA', 'Data Insights Inc.', 'Data Insights Inc. is a leading data analytics company that helps businesses make data-driven decisions. We specialize in advanced analytics, machine learning, and AI solutions.', 'careers@datainsights.com', '415-123-4567'),
(3, 'Full-Time', 'UX/UI Designer', 'We are seeking a talented UX/UI Designer to join our team in New York, NY. The ideal candidate will have experience in user-centered design, wireframing, and prototyping. Responsibilities include designing user interfaces, conducting user research, and collaborating with developers to implement designs.', '$80K - $100K / Year', 'New York, NY', 'DesignWorks', 'DesignWorks is a creative agency that specializes in user experience and interface design. We work with clients to create intuitive and visually appealing digital products.', 'info@designworks.com', '212-987-6543'),
(4, 'Remote', 'DevOps Engineer', 'Join our team as a DevOps Engineer and help us build and maintain scalable infrastructure. The ideal candidate will have experience with cloud platforms, CI/CD pipelines, and automation tools. Responsibilities include managing deployment processes, monitoring system performance, and ensuring high availability.', '$110K - $130K / Year', 'Remote', 'CloudTech Solutions', 'CloudTech Solutions provides cloud infrastructure and DevOps services to businesses worldwide. We are committed to delivering reliable and scalable solutions.', 'careers@cloudtech.com', '800-555-1234'),
(5, 'Full-Time', 'Marketing Manager', 'We are looking for a Marketing Manager to lead our marketing team in Chicago, IL. The ideal candidate will have experience in digital marketing, campaign management, and team leadership. Responsibilities include developing marketing strategies, managing budgets, and analyzing campaign performance.', '$90K - $110K / Year', 'Chicago, IL', 'MarketMasters', 'MarketMasters is a full-service marketing agency that helps businesses grow through innovative marketing strategies. We specialize in digital marketing, branding, and advertising.', 'info@marketmasters.com', '312-555-6789'),
(6, 'Full-Time', 'Backend Developer (Node.js)', 'We are seeking a Backend Developer with expertise in Node.js to join our team in Austin, TX. The ideal candidate will have experience in building scalable APIs, working with databases, and optimizing server performance. Responsibilities include developing and maintaining backend services, collaborating with front-end developers, and ensuring system reliability.', '$95K - $115K / Year', 'Austin, TX', 'CodeCrafters', 'CodeCrafters is a software development company that specializes in building scalable and efficient backend systems. We work with startups and enterprises to deliver high-quality solutions.', 'careers@codecrafters.com', '512-555-4321'),
(7, 'Full-Time', 'Product Manager', 'We are looking for a Product Manager to join our team in Seattle, WA. The ideal candidate will have experience in product lifecycle management, stakeholder communication, and agile methodologies. Responsibilities include defining product roadmaps, prioritizing features, and collaborating with cross-functional teams.', '$100K - $120K / Year', 'Seattle, WA', 'Productify', 'Productify is a product management consultancy that helps businesses bring innovative products to market. We specialize in product strategy, development, and launch.', 'info@productify.com', '206-555-5678'),
(8, 'Full-Time', 'Cybersecurity Analyst', 'We are seeking a Cybersecurity Analyst to join our team in Washington, DC. The ideal candidate will have experience in threat detection, vulnerability assessment, and incident response. Responsibilities include monitoring network security, implementing security measures, and conducting risk assessments.', '$85K - $105K / Year', 'Washington, DC', 'SecureTech', 'SecureTech is a cybersecurity firm that provides comprehensive security solutions to businesses and government agencies. We are committed to protecting our clients from cyber threats.', 'careers@securetech.com', '202-555-7890'),
(9, 'Remote', 'Mobile App Developer (Flutter)', 'Join our team as a Mobile App Developer and work on exciting Flutter-based projects. The ideal candidate will have experience in building cross-platform mobile apps using Flutter. Responsibilities include developing and maintaining mobile applications, collaborating with designers, and ensuring high performance and responsiveness.', '$80K - $100K / Year', 'Remote', 'AppMakers', 'AppMakers is a mobile app development company that specializes in building cross-platform apps using Flutter. We work with clients to create innovative and user-friendly mobile solutions.', 'info@appmakers.com', '888-555-2345'),
(10, 'Part-Time', 'Content Writer', 'We are looking for a Content Writer to join our team in Los Angeles, CA. The ideal candidate will have excellent writing skills and experience in creating engaging content for blogs, websites, and social media. Responsibilities include researching topics, writing articles, and editing content for clarity and accuracy.', '$40 - $50 / Hour', 'Los Angeles, CA', 'Content Creators Co.', 'Content Creators Co. is a content marketing agency that helps businesses connect with their audience through high-quality content. We specialize in blog writing, SEO, and social media content.', 'info@contentcreators.com', '213-555-6789'),
(11, 'Full-Time', 'Customer Support Specialist', 'We are seeking a Customer Support Specialist to join our team in Dallas, TX. The ideal candidate will have excellent communication skills and experience in providing customer support. Responsibilities include responding to customer inquiries, resolving issues, and ensuring customer satisfaction.', '$45K - $55K / Year', 'Dallas, TX', 'SupportSolutions', 'SupportSolutions is a customer support company that provides exceptional service to businesses and their customers. We specialize in technical support, account management, and customer success.', 'careers@supportsolutions.com', '214-555-3456'),
(12, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team. The ideal candidate will have excellent communication skills, the ability to multitask, and a strong attention to detail. Responsibilities include managing schedules, coordinating meetings, handling correspondence, and performing administrative tasks. This is a remote position, so reliable internet and a quiet workspace are required.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions. We specialize in helping businesses streamline their operations and achieve their goals through cutting-edge software and services.', 'careers@newteksolutions.com', '123-456-7890'),
(13, 'Full-Time', 'Senior React Developer', 'We are seeking a talented Senior React Developer to join our team in Boston, MA. The ideal candidate will have strong skills in HTML, CSS, and JavaScript, as well as experience with React.js and modern front-end development practices. Responsibilities include developing and maintaining user interfaces, collaborating with back-end developers, and ensuring high performance and responsiveness of applications.', '$70 - $80K / Year', 'Boston, MA', 'Tech Innovators', 'Tech Innovators is a forward-thinking company that specializes in building cutting-edge web applications for global clients. We pride ourselves on delivering high-quality solutions that drive business success.', 'careers@techinnovators.com', '987-654-3210'),
(14, 'Remote', 'Front-End Engineer (React)', 'Join our team as a Front-End Engineer and work on exciting projects that make a difference. We are looking for a motivated individual with a passion for building beautiful and functional user interfaces. Responsibilities include developing and maintaining React-based applications, collaborating with designers and back-end developers, and ensuring a seamless user experience.', '$70K - $80K / Year', 'Miami, FL', 'Sunshine Tech', 'Sunshine Tech is a dynamic company that creates innovative web applications for clients worldwide. We are committed to delivering exceptional digital experiences that drive results.', 'info@sunshinetech.com', '555-123-4567'),
(15, 'Remote', 'React.js Developer', 'Are you passionate about front-end development? Join our team in vibrant Brooklyn, NY, and work on exciting projects that make a difference. We are looking for a skilled React.js Developer to build and maintain user interfaces for our web applications. Responsibilities include writing clean and efficient code, collaborating with cross-functional teams, and ensuring high performance and responsiveness.', '$70K - $80K / Year', 'Brooklyn, NY', 'Creative Solutions', 'Creative Solutions is a creative agency focused on delivering exceptional digital experiences. We work with clients across various industries to create innovative and impactful solutions.', 'hello@creativesolutions.com', '222-333-4444'),
(16, 'Part-Time', 'React Front-End Developer', 'Join our team as a Part-Time Front-End Developer in beautiful Phoenix, AZ. We are looking for a self-motivated individual with a passion for building user-friendly interfaces. Responsibilities include developing and maintaining React-based applications, collaborating with designers and back-end developers, and ensuring a seamless user experience.', '$60 - $70K / Year', 'Phoenix, AZ', 'Desert Tech', 'Desert Tech provides innovative tech solutions to businesses in the desert region. We are dedicated to helping our clients achieve their goals through technology.', 'jobs@deserttech.com', '111-222-3333'),
(17, 'Full-Time', 'Full Stack React Developer', 'Exciting opportunity for a Full Stack React Developer in bustling Atlanta, GA. We are seeking a talented individual with experience in both front-end and back-end development. Responsibilities include building and maintaining web applications, collaborating with cross-functional teams, and ensuring high performance and scalability.', '$90K - $100K / Year', 'Atlanta, GA', 'Metro Tech', 'Metro Tech is a leading tech company in the Atlanta area, specializing in full-stack development. We are committed to delivering high-quality solutions that meet our clients\' needs.', 'careers@metrotech.com', '444-555-6666'),
(18, 'Remote', 'React Native Developer', 'Join our team as a React Native Developer and work on exciting mobile applications. We are looking for a skilled and enthusiastic individual with experience in building cross-platform mobile apps using React Native. Responsibilities include developing and maintaining mobile applications, collaborating with designers and back-end developers, and ensuring high performance and responsiveness.', '$100K - $110K / Year', 'Portland, OR', 'Green Tech', 'Green Tech is committed to building sustainable and innovative tech solutions. We work with clients to create impactful and environmentally friendly applications.', 'info@greentech.com', '777-888-9999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Role` varchar(20) NOT NULL DEFAULT 'user',
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Firstname`, `Lastname`, `Username`, `Gender`, `Occupation`, `Role`, `Email`, `Password`) VALUES
(1, 'Noah', 'Enemali', 'rovic', 'Male', 'cchchhhg', 'user', 'noahbig001@gmail.com', '2FTQEGRR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.infinityfree.com
-- Generation Time: Nov 20, 2025 at 08:25 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40011505_Skillsoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driverlicense_path` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `houseaddress` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `bankno` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `type`, `title`, `description`, `salary`, `location`, `company`, `company_description`, `contact_email`, `contact_phone`) VALUES
(1, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team. The ideal candidate will have excellent communication skills, the ability to multitask, and a strong attention to detail. Responsibilities include managing schedules, coordinating meetings, handling correspondence, and performing administrative tasks. This is a remote position, so reliable internet and a quiet workspace are required.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions. We specialize in helping businesses streamline their operations and achieve their goals through cutting-edge software and services.', 'careers@newteksolutions.com', '123-456-7890'),
(2, 'Full-Time', 'Data Scientist', 'We are looking for a Data Scientist to join our team in San Francisco, CA. The ideal candidate will have strong skills in data analysis, machine learning, and statistical modeling. Responsibilities include analyzing large datasets, building predictive models, and presenting insights to stakeholders.', '$120K - $140K / Year', 'San Francisco, CA', 'Data Insights Inc.', 'Data Insights Inc. is a leading data analytics company that helps businesses make data-driven decisions. We specialize in advanced analytics, machine learning, and AI solutions.', 'careers@datainsights.com', '415-123-4567'),
(3, 'Full-Time', 'UX/UI Designer', 'We are seeking a talented UX/UI Designer to join our team in New York, NY. The ideal candidate will have experience in user-centered design, wireframing, and prototyping. Responsibilities include designing user interfaces, conducting user research, and collaborating with developers to implement designs.', '$80K - $100K / Year', 'New York, NY', 'DesignWorks', 'DesignWorks is a creative agency that specializes in user experience and interface design. We work with clients to create intuitive and visually appealing digital products.', 'info@designworks.com', '212-987-6543'),
(4, 'Remote', 'DevOps Engineer', 'Join our team as a DevOps Engineer and help us build and maintain scalable infrastructure. The ideal candidate will have experience with cloud platforms, CI/CD pipelines, and automation tools. Responsibilities include managing deployment processes, monitoring system performance, and ensuring high availability.', '$110K - $130K / Year', 'Remote', 'CloudTech Solutions', 'CloudTech Solutions provides cloud infrastructure and DevOps services to businesses worldwide. We are committed to delivering reliable and scalable solutions.', 'careers@cloudtech.com', '800-555-1234'),
(5, 'Full-Time', 'Marketing Manager', 'We are looking for a Marketing Manager to lead our marketing team in Chicago, IL. The ideal candidate will have experience in digital marketing, campaign management, and team leadership. Responsibilities include developing marketing strategies, managing budgets, and analyzing campaign performance.', '$90K - $110K / Year', 'Chicago, IL', 'MarketMasters', 'MarketMasters is a full-service marketing agency that helps businesses grow through innovative marketing strategies. We specialize in digital marketing, branding, and advertising.', 'info@marketmasters.com', '312-555-6789'),
(6, 'Full-Time', 'Backend Developer (Node.js)', 'We are seeking a Backend Developer with expertise in Node.js to join our team in Austin, TX. The ideal candidate will have experience in building scalable APIs, working with databases, and optimizing server performance. Responsibilities include developing and maintaining backend services, collaborating with front-end developers, and ensuring system reliability.', '$95K - $115K / Year', 'Austin, TX', 'CodeCrafters', 'CodeCrafters is a software development company that specializes in building scalable and efficient backend systems. We work with startups and enterprises to deliver high-quality solutions.', 'careers@codecrafters.com', '512-555-4321'),
(7, 'Full-Time', 'Product Manager', 'We are looking for a Product Manager to join our team in Seattle, WA. The ideal candidate will have experience in product lifecycle management, stakeholder communication, and agile methodologies. Responsibilities include defining product roadmaps, prioritizing features, and collaborating with cross-functional teams.', '$100K - $120K / Year', 'Seattle, WA', 'Productify', 'Productify is a product management consultancy that helps businesses bring innovative products to market. We specialize in product strategy, development, and launch.', 'info@productify.com', '206-555-5678'),
(8, 'Full-Time', 'Cybersecurity Analyst', 'We are seeking a Cybersecurity Analyst to join our team in Washington, DC. The ideal candidate will have experience in threat detection, vulnerability assessment, and incident response. Responsibilities include monitoring network security, implementing security measures, and conducting risk assessments.', '$85K - $105K / Year', 'Washington, DC', 'SecureTech', 'SecureTech is a cybersecurity firm that provides comprehensive security solutions to businesses and government agencies. We are committed to protecting our clients from cyber threats.', 'careers@securetech.com', '202-555-7890'),
(9, 'Remote', 'Mobile App Developer (Flutter)', 'Join our team as a Mobile App Developer and work on exciting Flutter-based projects. The ideal candidate will have experience in building cross-platform mobile apps using Flutter. Responsibilities include developing and maintaining mobile applications, collaborating with designers, and ensuring high performance and responsiveness.', '$80K - $100K / Year', 'Remote', 'AppMakers', 'AppMakers is a mobile app development company that specializes in building cross-platform apps using Flutter. We work with clients to create innovative and user-friendly mobile solutions.', 'info@appmakers.com', '888-555-2345'),
(10, 'Part-Time', 'Content Writer', 'We are looking for a Content Writer to join our team in Los Angeles, CA. The ideal candidate will have excellent writing skills and experience in creating engaging content for blogs, websites, and social media. Responsibilities include researching topics, writing articles, and editing content for clarity and accuracy.', '$40 - $50 / Hour', 'Los Angeles, CA', 'Content Creators Co.', 'Content Creators Co. is a content marketing agency that helps businesses connect with their audience through high-quality content. We specialize in blog writing, SEO, and social media content.', 'info@contentcreators.com', '213-555-6789'),
(11, 'Full-Time', 'Customer Support Specialist', 'We are seeking a Customer Support Specialist to join our team in Dallas, TX. The ideal candidate will have excellent communication skills and experience in providing customer support. Responsibilities include responding to customer inquiries, resolving issues, and ensuring customer satisfaction.', '$45K - $55K / Year', 'Dallas, TX', 'SupportSolutions', 'SupportSolutions is a customer support company that provides exceptional service to businesses and their customers. We specialize in technical support, account management, and customer success.', 'careers@supportsolutions.com', '214-555-3456'),
(12, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team. The ideal candidate will have excellent communication skills, the ability to multitask, and a strong attention to detail. Responsibilities include managing schedules, coordinating meetings, handling correspondence, and performing administrative tasks. This is a remote position, so reliable internet and a quiet workspace are required.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions. We specialize in helping businesses streamline their operations and achieve their goals through cutting-edge software and services.', 'careers@newteksolutions.com', '123-456-7890'),
(13, 'Full-Time', 'Senior React Developer', 'We are seeking a talented Senior React Developer to join our team in Boston, MA. The ideal candidate will have strong skills in HTML, CSS, and JavaScript, as well as experience with React.js and modern front-end development practices. Responsibilities include developing and maintaining user interfaces, collaborating with back-end developers, and ensuring high performance and responsiveness of applications.', '$70 - $80K / Year', 'Boston, MA', 'Tech Innovators', 'Tech Innovators is a forward-thinking company that specializes in building cutting-edge web applications for global clients. We pride ourselves on delivering high-quality solutions that drive business success.', 'careers@techinnovators.com', '987-654-3210'),
(14, 'Remote', 'Front-End Engineer (React)', 'Join our team as a Front-End Engineer and work on exciting projects that make a difference. We are looking for a motivated individual with a passion for building beautiful and functional user interfaces. Responsibilities include developing and maintaining React-based applications, collaborating with designers and back-end developers, and ensuring a seamless user experience.', '$70K - $80K / Year', 'Miami, FL', 'Sunshine Tech', 'Sunshine Tech is a dynamic company that creates innovative web applications for clients worldwide. We are committed to delivering exceptional digital experiences that drive results.', 'info@sunshinetech.com', '555-123-4567'),
(15, 'Remote', 'React.js Developer', 'Are you passionate about front-end development? Join our team in vibrant Brooklyn, NY, and work on exciting projects that make a difference. We are looking for a skilled React.js Developer to build and maintain user interfaces for our web applications. Responsibilities include writing clean and efficient code, collaborating with cross-functional teams, and ensuring high performance and responsiveness.', '$70K - $80K / Year', 'Brooklyn, NY', 'Creative Solutions', 'Creative Solutions is a creative agency focused on delivering exceptional digital experiences. We work with clients across various industries to create innovative and impactful solutions.', 'hello@creativesolutions.com', '222-333-4444'),
(16, 'Part-Time', 'React Front-End Developer', 'Join our team as a Part-Time Front-End Developer in beautiful Phoenix, AZ. We are looking for a self-motivated individual with a passion for building user-friendly interfaces. Responsibilities include developing and maintaining React-based applications, collaborating with designers and back-end developers, and ensuring a seamless user experience.', '$60 - $70K / Year', 'Phoenix, AZ', 'Desert Tech', 'Desert Tech provides innovative tech solutions to businesses in the desert region. We are dedicated to helping our clients achieve their goals through technology.', 'jobs@deserttech.com', '111-222-3333'),
(17, 'Full-Time', 'Full Stack React Developer', 'Exciting opportunity for a Full Stack React Developer in bustling Atlanta, GA. We are seeking a talented individual with experience in both front-end and back-end development. Responsibilities include building and maintaining web applications, collaborating with cross-functional teams, and ensuring high performance and scalability.', '$90K - $100K / Year', 'Atlanta, GA', 'Metro Tech', 'Metro Tech is a leading tech company in the Atlanta area, specializing in full-stack development. We are committed to delivering high-quality solutions that meet our clients\' needs.', 'careers@metrotech.com', '444-555-6666'),
(18, 'Remote', 'React Native Developer', 'Join our team as a React Native Developer and work on exciting mobile applications. We are looking for a skilled and enthusiastic individual with experience in building cross-platform mobile apps using React Native. Responsibilities include developing and maintaining mobile applications, collaborating with designers and back-end developers, and ensuring high performance and responsiveness.', '$100K - $110K / Year', 'Portland, OR', 'Green Tech', 'Green Tech is committed to building sustainable and innovative tech solutions. We work with clients to create impactful and environmentally friendly applications.', 'info@greentech.com', '777-888-9999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Role` varchar(20) NOT NULL DEFAULT 'user',
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Firstname`, `Lastname`, `Username`, `Gender`, `Occupation`, `Role`, `Email`, `Password`) VALUES
(1, 'Noah', 'Enemali', 'rovic', 'Male', 'cchchhhg', 'user', 'noahbig001@gmail.com', '2FTQEGRR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.infinityfree.com
-- Generation Time: Nov 20, 2025 at 08:25 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40011505_Skillsoft`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driverlicense_path` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `phoneno` varchar(255) NOT NULL,
  `houseaddress` varchar(255) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `bankno` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `type`, `title`, `description`, `salary`, `location`, `company`, `company_description`, `contact_email`, `contact_phone`) VALUES
(1, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team. The ideal candidate will have excellent communication skills, the ability to multitask, and a strong attention to detail. Responsibilities include managing schedules, coordinating meetings, handling correspondence, and performing administrative tasks. This is a remote position, so reliable internet and a quiet workspace are required.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions. We specialize in helping businesses streamline their operations and achieve their goals through cutting-edge software and services.', 'careers@newteksolutions.com', '123-456-7890'),
(2, 'Full-Time', 'Data Scientist', 'We are looking for a Data Scientist to join our team in San Francisco, CA. The ideal candidate will have strong skills in data analysis, machine learning, and statistical modeling. Responsibilities include analyzing large datasets, building predictive models, and presenting insights to stakeholders.', '$120K - $140K / Year', 'San Francisco, CA', 'Data Insights Inc.', 'Data Insights Inc. is a leading data analytics company that helps businesses make data-driven decisions. We specialize in advanced analytics, machine learning, and AI solutions.', 'careers@datainsights.com', '415-123-4567'),
(3, 'Full-Time', 'UX/UI Designer', 'We are seeking a talented UX/UI Designer to join our team in New York, NY. The ideal candidate will have experience in user-centered design, wireframing, and prototyping. Responsibilities include designing user interfaces, conducting user research, and collaborating with developers to implement designs.', '$80K - $100K / Year', 'New York, NY', 'DesignWorks', 'DesignWorks is a creative agency that specializes in user experience and interface design. We work with clients to create intuitive and visually appealing digital products.', 'info@designworks.com', '212-987-6543'),
(4, 'Remote', 'DevOps Engineer', 'Join our team as a DevOps Engineer and help us build and maintain scalable infrastructure. The ideal candidate will have experience with cloud platforms, CI/CD pipelines, and automation tools. Responsibilities include managing deployment processes, monitoring system performance, and ensuring high availability.', '$110K - $130K / Year', 'Remote', 'CloudTech Solutions', 'CloudTech Solutions provides cloud infrastructure and DevOps services to businesses worldwide. We are committed to delivering reliable and scalable solutions.', 'careers@cloudtech.com', '800-555-1234'),
(5, 'Full-Time', 'Marketing Manager', 'We are looking for a Marketing Manager to lead our marketing team in Chicago, IL. The ideal candidate will have experience in digital marketing, campaign management, and team leadership. Responsibilities include developing marketing strategies, managing budgets, and analyzing campaign performance.', '$90K - $110K / Year', 'Chicago, IL', 'MarketMasters', 'MarketMasters is a full-service marketing agency that helps businesses grow through innovative marketing strategies. We specialize in digital marketing, branding, and advertising.', 'info@marketmasters.com', '312-555-6789'),
(6, 'Full-Time', 'Backend Developer (Node.js)', 'We are seeking a Backend Developer with expertise in Node.js to join our team in Austin, TX. The ideal candidate will have experience in building scalable APIs, working with databases, and optimizing server performance. Responsibilities include developing and maintaining backend services, collaborating with front-end developers, and ensuring system reliability.', '$95K - $115K / Year', 'Austin, TX', 'CodeCrafters', 'CodeCrafters is a software development company that specializes in building scalable and efficient backend systems. We work with startups and enterprises to deliver high-quality solutions.', 'careers@codecrafters.com', '512-555-4321'),
(7, 'Full-Time', 'Product Manager', 'We are looking for a Product Manager to join our team in Seattle, WA. The ideal candidate will have experience in product lifecycle management, stakeholder communication, and agile methodologies. Responsibilities include defining product roadmaps, prioritizing features, and collaborating with cross-functional teams.', '$100K - $120K / Year', 'Seattle, WA', 'Productify', 'Productify is a product management consultancy that helps businesses bring innovative products to market. We specialize in product strategy, development, and launch.', 'info@productify.com', '206-555-5678'),
(8, 'Full-Time', 'Cybersecurity Analyst', 'We are seeking a Cybersecurity Analyst to join our team in Washington, DC. The ideal candidate will have experience in threat detection, vulnerability assessment, and incident response. Responsibilities include monitoring network security, implementing security measures, and conducting risk assessments.', '$85K - $105K / Year', 'Washington, DC', 'SecureTech', 'SecureTech is a cybersecurity firm that provides comprehensive security solutions to businesses and government agencies. We are committed to protecting our clients from cyber threats.', 'careers@securetech.com', '202-555-7890'),
(9, 'Remote', 'Mobile App Developer (Flutter)', 'Join our team as a Mobile App Developer and work on exciting Flutter-based projects. The ideal candidate will have experience in building cross-platform mobile apps using Flutter. Responsibilities include developing and maintaining mobile applications, collaborating with designers, and ensuring high performance and responsiveness.', '$80K - $100K / Year', 'Remote', 'AppMakers', 'AppMakers is a mobile app development company that specializes in building cross-platform apps using Flutter. We work with clients to create innovative and user-friendly mobile solutions.', 'info@appmakers.com', '888-555-2345'),
(10, 'Part-Time', 'Content Writer', 'We are looking for a Content Writer to join our team in Los Angeles, CA. The ideal candidate will have excellent writing skills and experience in creating engaging content for blogs, websites, and social media. Responsibilities include researching topics, writing articles, and editing content for clarity and accuracy.', '$40 - $50 / Hour', 'Los Angeles, CA', 'Content Creators Co.', 'Content Creators Co. is a content marketing agency that helps businesses connect with their audience through high-quality content. We specialize in blog writing, SEO, and social media content.', 'info@contentcreators.com', '213-555-6789'),
(11, 'Full-Time', 'Customer Support Specialist', 'We are seeking a Customer Support Specialist to join our team in Dallas, TX. The ideal candidate will have excellent communication skills and experience in providing customer support. Responsibilities include responding to customer inquiries, resolving issues, and ensuring customer satisfaction.', '$45K - $55K / Year', 'Dallas, TX', 'SupportSolutions', 'SupportSolutions is a customer support company that provides exceptional service to businesses and their customers. We specialize in technical support, account management, and customer success.', 'careers@supportsolutions.com', '214-555-3456'),
(12, 'Remote', 'Personal Assistant', 'We are looking for a highly organized and detail-oriented Personal Assistant to support our executive team. The ideal candidate will have excellent communication skills, the ability to multitask, and a strong attention to detail. Responsibilities include managing schedules, coordinating meetings, handling correspondence, and performing administrative tasks. This is a remote position, so reliable internet and a quiet workspace are required.', '$30 - $35 / Hour', 'Nashville, TX', 'NewTek Solutions', 'NewTek Solutions is a leading provider of innovative technology solutions. We specialize in helping businesses streamline their operations and achieve their goals through cutting-edge software and services.', 'careers@newteksolutions.com', '123-456-7890'),
(13, 'Full-Time', 'Senior React Developer', 'We are seeking a talented Senior React Developer to join our team in Boston, MA. The ideal candidate will have strong skills in HTML, CSS, and JavaScript, as well as experience with React.js and modern front-end development practices. Responsibilities include developing and maintaining user interfaces, collaborating with back-end developers, and ensuring high performance and responsiveness of applications.', '$70 - $80K / Year', 'Boston, MA', 'Tech Innovators', 'Tech Innovators is a forward-thinking company that specializes in building cutting-edge web applications for global clients. We pride ourselves on delivering high-quality solutions that drive business success.', 'careers@techinnovators.com', '987-654-3210'),
(14, 'Remote', 'Front-End Engineer (React)', 'Join our team as a Front-End Engineer and work on exciting projects that make a difference. We are looking for a motivated individual with a passion for building beautiful and functional user interfaces. Responsibilities include developing and maintaining React-based applications, collaborating with designers and back-end developers, and ensuring a seamless user experience.', '$70K - $80K / Year', 'Miami, FL', 'Sunshine Tech', 'Sunshine Tech is a dynamic company that creates innovative web applications for clients worldwide. We are committed to delivering exceptional digital experiences that drive results.', 'info@sunshinetech.com', '555-123-4567'),
(15, 'Remote', 'React.js Developer', 'Are you passionate about front-end development? Join our team in vibrant Brooklyn, NY, and work on exciting projects that make a difference. We are looking for a skilled React.js Developer to build and maintain user interfaces for our web applications. Responsibilities include writing clean and efficient code, collaborating with cross-functional teams, and ensuring high performance and responsiveness.', '$70K - $80K / Year', 'Brooklyn, NY', 'Creative Solutions', 'Creative Solutions is a creative agency focused on delivering exceptional digital experiences. We work with clients across various industries to create innovative and impactful solutions.', 'hello@creativesolutions.com', '222-333-4444'),
(16, 'Part-Time', 'React Front-End Developer', 'Join our team as a Part-Time Front-End Developer in beautiful Phoenix, AZ. We are looking for a self-motivated individual with a passion for building user-friendly interfaces. Responsibilities include developing and maintaining React-based applications, collaborating with designers and back-end developers, and ensuring a seamless user experience.', '$60 - $70K / Year', 'Phoenix, AZ', 'Desert Tech', 'Desert Tech provides innovative tech solutions to businesses in the desert region. We are dedicated to helping our clients achieve their goals through technology.', 'jobs@deserttech.com', '111-222-3333'),
(17, 'Full-Time', 'Full Stack React Developer', 'Exciting opportunity for a Full Stack React Developer in bustling Atlanta, GA. We are seeking a talented individual with experience in both front-end and back-end development. Responsibilities include building and maintaining web applications, collaborating with cross-functional teams, and ensuring high performance and scalability.', '$90K - $100K / Year', 'Atlanta, GA', 'Metro Tech', 'Metro Tech is a leading tech company in the Atlanta area, specializing in full-stack development. We are committed to delivering high-quality solutions that meet our clients\' needs.', 'careers@metrotech.com', '444-555-6666'),
(18, 'Remote', 'React Native Developer', 'Join our team as a React Native Developer and work on exciting mobile applications. We are looking for a skilled and enthusiastic individual with experience in building cross-platform mobile apps using React Native. Responsibilities include developing and maintaining mobile applications, collaborating with designers and back-end developers, and ensuring high performance and responsiveness.', '$100K - $110K / Year', 'Portland, OR', 'Green Tech', 'Green Tech is committed to building sustainable and innovative tech solutions. We work with clients to create impactful and environmentally friendly applications.', 'info@greentech.com', '777-888-9999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Role` varchar(20) NOT NULL DEFAULT 'user',
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Firstname`, `Lastname`, `Username`, `Gender`, `Occupation`, `Role`, `Email`, `Password`) VALUES
(1, 'Noah', 'Enemali', 'rovic', 'Male', 'cchchhhg', 'user', 'noahbig001@gmail.com', '2FTQEGRR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
