<?php

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'MP3_HELPLINE'	=> '[mp3]ссылка mp3[/mp3]',
	'MP4_HELPLINE'	=> '[mp4video]урл видео mp4 или webm[/mp4video] или [mp4video=адрес картинки]урл видео mp4 или webm[mp4video]',
));
