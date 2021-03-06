<?php

namespace Facebook\Graph;

use Facebook\Exception;

/**
 * Description of Response
 *
 * @author Martin
 */
class Response extends \Facebook\Responses\Response
{

	public function __construct($responseString)
	{
		$decoded = json_decode($responseString);
		if($decoded == null)
		{
			parse_str($responseString, $vars);
			foreach($vars as $property => $value)
			{
				$this->$property = $value;
			}
		}
		else
		{
			if(isset($decoded->error))
			{
				$message = $decoded->error->type . ': ' . $decoded->error->message;
				throw new Exception($message);
			}
			else
			{
				foreach($decoded as $property => $value)
				{
					$this->$property = $value;
				}
			}
		}
		$this->frozen = true;
	}
}