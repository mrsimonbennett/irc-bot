<?php
// Namespace
namespace Listener;
use \Library\FunctionCollection as func;

/**
*
* @package IRCBot
* @subpackage Listener
* @author NeXxGeN (https://github.com/NeXxGeN)
*/
class Youtube extends \Library\IRC\Listener\Base {

	private $apiUri = "http://gdata.youtube.com/feeds/api/videos/%s";

	/**
	* Main function to execute when listen even occurs
	*/
	public function execute($data)
	{
		$ytTitle = $this->getYtTitle($data);
		if ($ytTitle)
		{
			$args = $this->getArguments($data);
			$this->say( $ytTitle,$args[2]);
		}
	}

	private function getYtTitle($data)
	{
		
		preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $data, $matches);
		if (!empty($matches) && !empty($matches[0]))
		{
			// We've got a YT URL. Parse it.
			$matches = $matches[0];
            return $this->getTitle($matches) . ' - ' . $matches;

		}
		
		// Sorry pals, non-YouTube URLs ain't going to cut it.
		return false;
	}

    function getTitle($Url){
        $str = file_get_contents($Url);
        if(strlen($str)>0){
            preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
            return $title[1];
        }
    }

	/**
	* Returns keywords that listener is listening to.
	*
	* @return array
	*/
	public function getMessageKeywords() {
		return array('http://','https://');
	}
}
