SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '������������� �������',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '������ �� �� �������, ������� �������� �������...',
  `group_title` text NOT NULL COMMENT '�������� ������ ��������... )',
  `title` text NOT NULL COMMENT '��������� �������',
  `description` text NOT NULL COMMENT '�������� �������',
  `preview_url` text NOT NULL COMMENT '����� ��������� :)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '�� �����',
  `album_id` int(11) NOT NULL COMMENT '������ �� ID �������',
  `title` text NOT NULL COMMENT '��������(��������)',
  `preview_url` text NOT NULL COMMENT '���� � ���������',
  `full_url` text NOT NULL COMMENT '���� � ������ ��������',
  `upload_time` int(11) NOT NULL COMMENT '����� ��������',
  `upload_ip` text NOT NULL COMMENT 'IP, � �������� ��������� ����',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
