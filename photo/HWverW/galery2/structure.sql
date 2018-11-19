SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор альбома',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Ссылка на ид альбома, который является группой...',
  `group_title` text NOT NULL COMMENT 'Название группы альбомов... )',
  `title` text NOT NULL COMMENT 'Заголовок альбома',
  `description` text NOT NULL COMMENT 'Описание альбома',
  `preview_url` text NOT NULL COMMENT 'Адрес превьюшки :)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ид фотки',
  `album_id` int(11) NOT NULL COMMENT 'Ссылка на ID альбома',
  `title` text NOT NULL COMMENT 'Название(описание)',
  `preview_url` text NOT NULL COMMENT 'Путь к превьюшке',
  `full_url` text NOT NULL COMMENT 'Путь к полной картинке',
  `upload_time` int(11) NOT NULL COMMENT 'Время загрузки',
  `upload_ip` text NOT NULL COMMENT 'IP, с которого загружено было',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
