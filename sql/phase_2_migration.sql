-- Database Migration for Phase 2: Employer Portal & Upload Logic

-- 1. Link jobs to employers
ALTER TABLE `jobs` 
ADD COLUMN `employer_id` INT(11) NULL DEFAULT NULL AFTER `id`;

-- Since there are existing jobs, let's artificially assign them to our test user (id: 1) for now
UPDATE `jobs` SET `employer_id` = 1 WHERE `employer_id` IS NULL;

-- 2. Link applications to jobs and users
ALTER TABLE `applications` 
ADD COLUMN `job_id` INT(11) NOT NULL AFTER `id`,
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `job_id`;

-- 3. Update Foreign Key constraints (Optional in MyISAM, but good practice)
-- MyISAM doesn't enforce foreign keys, but we define the structure semantically
ALTER TABLE `jobs` ADD INDEX(`employer_id`);
ALTER TABLE `applications` ADD INDEX(`job_id`), ADD INDEX(`user_id`);
