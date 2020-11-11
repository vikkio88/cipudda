CREATE TABLE `posts` (
  `slug` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text,
  `publishedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `tags` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `posts`
  ADD PRIMARY KEY (`slug`);
