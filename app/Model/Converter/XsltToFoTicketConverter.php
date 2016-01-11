<?php

namespace App\Model\Converter;

use App\Model\Serializer\XMLSerializer;
use Log;

class XsltToFoTicketConverter
{
	/**
	 * @param array $ticket
	 */
	public function convertTicket($ticket)
	{
		$processor        = new \XSLTProcessor();
		$xmlSerializer    = new XMLSerializer();
		$serializedTicket = $xmlSerializer->serialize($ticket);
		$dom              = new \DOMDocument();

		$dom->loadXML($serializedTicket);
		$processor->registerPHPFunctions('config');

		try {
			$stylesheet = new \DOMDocument();
			$stylesheet->load(config('printer.XSLTemplatePath'));

			$processor->importStylesheet($stylesheet);
			$doc = $processor->transformToDoc($dom);

			$doc->save(config('printer.foOutputPath'));
		} catch (\Exception $e) {
			Log::error($e->getMessage());
		}
	}
}