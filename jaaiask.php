<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Plugin\System\JAAIAsk\OpenAI\ChatHelper;

defined('_JEXEC') or die('Restricted Access');

class PlgSystemJaaiask extends CMSPlugin
{
	public $app;
	public $doc;

	public function __construct()
	{
		// todo
		$this->app = Factory::getApplication();
		$this->doc = Factory::getDocument();
		require_once(JPATH_ROOT . '/plugins/system/jaaiask/layouts/fields/btnField.php');
	}

	public function onBeforeRender()
	{
		$btn = new BtnField();
		$btn->loadScripts();
	}

	public function onAfterRender(Event $event)
	{
		if($this->app->isClient('administrator')){
			return ;
		}
		$input = $this->app->input;
		$method = $input->getMethod();
		$option = $input->getCmd('option');
		$plugin = $input->getCmd('plugin');

		// do not render button when plugin send ajax request
		if (in_array($method, ['GET', 'POST']) && $option === 'com_ajax' && $plugin === 'jaaiask'){
			return ;
		}else{
			$btn = new BtnField();
			$btn->initButton();
		}
		/*$form = new Joomla\CMS\Form\Form('aiask');
		$file = JPATH_ROOT . '/plugins/system/jaaiask/layouts/askButton.xml';
		$form->loadFile($file, false);
		Form::addFormPath(JPATH_ROOT . '/plugins/system/jaaiask/layouts');*/
	}

	public function onContentPrepareForm($form, $data)
	{
		$app = Factory::getApplication();
		$file = JPATH_ROOT . '/plugins/system/jaaiask/layouts/askButton.xml';
		$form->loadFile($file, false);
		if (!($form instanceof Form)){
            /*$app->enqueueMessage(Text::_('JA_AI_ASK_ERROR_NOT_A_FORM'), 'error');
            return false;*/
        }
	}

	public function prepareForm()
	{
		
	}

	public function onAjaxJaaiask()
	{
		$input = $this->app->input;
		$task = $input->get('aitask', '');
		$tasks = ['ai_ask'];
		$data = [];
		if (!in_array($task, $tasks)){
			$data['code'] = 201;
			$data['message'] = "This task does not support: $task";
			return $data;
		}
		switch ($task){
			case 'ai_ask':
				return ChatHelper::doTask();
			case '':
			default:
				break;
		}
	}
}
?>