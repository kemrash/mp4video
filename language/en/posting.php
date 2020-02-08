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
	'MP3_HELPLINE'	=> '[mp3]URL mp3[/mp3]',
	'MP4_HELPLINE'	=> '[mp4video]URL mp4 or webm[/mp4video] or [mp4video=URL poster]URL mp4 or webm[mp4video]',
));
