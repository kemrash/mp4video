<?php
namespace kemrash\mp4video\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'kemrash_mp4video_mp3',
		);
	}

	public function kemrash_mp4video_mp3($event)
	{
		$lang_set_ext=$event['lang_set_ext'];
		$lang_set_ext[]=array(
			'ext_name' => 'kemrash/mp4video',
			'lang_set' => 'posting',
		);
		$event['lang_set_ext']=$lang_set_ext;
	}
}