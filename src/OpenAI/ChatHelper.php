<?php

namespace Joomla\Plugin\System\JAAIAsk\OpenAI;

use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Http\HttpFactory;

defined('_JEXEC') or die('Restricted access');


trait OpenAiApiTrait{
	protected static function getApiKey()
    {
		require_once JPATH_ROOT . '/plugins/system/jaaiask/src/config.php';
		$apiKey = OPENAI_API_KEY;
		return $apiKey;
    }
}

class ChatHelper
{
	use OpenAiApiTrait;

    protected static $endpoint = 'https://api.openai.com/v1/chat/completions';

    public static function doTask()
    {
        $input = Factory::getApplication()->input;
        // $task = $input->get('ai_ask', '');
		$content = $input->getString('quest', '');

        $promt = '';
        $promt .= $content;

        $options = new Registry();
        $options->set('userAgent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');

		$res = self::generateRandomSentence();

		return [
			'code' => 200,
			'data' => $res,
		];

        try {
            $data = new Registry();
            $data->set('model', 'gpt-3.5-turbo');
            $data->set('messages', [
                [
                    'role' => 'user',
                    'content' => $promt,
                ]
            ]);

            $apiKey = self::getApiKey();
            $header = [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
            ];

            $response = HttpFactory::getHttp($options)->post(self::$endpoint, $data->toString(), $header);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Unable to access endpoint.', $e->getCode(), $e);
        }

        if ($response->code != 200) {
            $errorRes = new Registry($response->body);
            $errorData = $errorRes->get('error');

            if ($errorData) {
                throw new \RuntimeException($errorData->message, 500);
            } else {
                throw new \RuntimeException("Access API error", 500);
            }
        }

        $result = new Registry($response->body);
        $choices = $result->get('choices', []);

        return [
	        'code' => 200,
	        'type' => 'text',
            'data' => $choices[0]->message->content,
        ];
    }

	public static function generateRandomSentence() {
	    $words = array(
	        'The', 'quick', 'brown', 'fox', 'jumps', 'over', 'the', 'lazy', 'dog',
	        'Jack', 'and', 'Jill', 'went', 'up', 'the', 'hill', 'to', 'fetch', 'a', 'pail', 'of', 'water.',
	        'Mary', 'had', 'a', 'little', 'lamb,', 'its', 'fleece', 'was', 'white', 'as', 'snow.',
	        'Humpty', 'Dumpty', 'sat', 'on', 'a', 'wall,', 'Humpty', 'Dumpty', 'had', 'a', 'great', 'fall.'
	    );

	    $sentence = '';
	    $wordCount = count($words);
	    $targetWordCount = rand(10, 20); // Generate a random number of words for the sentence

	    for ($i = 0; $i < $targetWordCount; $i++) {
	        $randomIndex = rand(0, $wordCount - 1);
	        $sentence .= $words[$randomIndex] . ' ';
	    }

	    // Capitalize the first letter of the sentence and add a period at the end
	    $sentence = ucfirst(trim($sentence)) . '.';

	    return $sentence;
	}


}
