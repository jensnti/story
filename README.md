Startfiler för Soloäventyr på temat La Traviata

https://sv.wikipedia.org/wiki/La_traviata

https://drive.google.com/file/d/1NdX7AWau7AH53N65B7n4ZReAK8qdcgqb/view?usp=sharing

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_bin NOT NULL,
  `place` varchar(32) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
