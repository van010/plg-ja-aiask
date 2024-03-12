<?php

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

class BtnField
{
	public function __construct($form = null)
	{
	}

	public function initButton()
	{
		require_once(JPATH_ROOT . '/plugins/system/jaaiask/layouts/views/aiAskFrame.php');
	}

	public function loadScripts()
	{
		$doc = Factory::getDocument();
		$doc->addStyleSheet(Uri::root(true) . '/plugins/system/jaaiask/admin/assets/css/ja-aiask.css');
		$doc->addScript(Uri::root(true) . '/plugins/system/jaaiask/admin/assets/js/ja_aiask.js');
		// load react built
		$doc->addScript(Uri::root(true) . '/plugins/system/jaaiask/media/aiask/dist/bundle.js');
	}
}
?>