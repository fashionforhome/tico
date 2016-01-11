<?php

namespace App\Model;


use App\Model\Converter\FoToPDFTicketConverter;
use App\Model\Converter\XsltToFoTicketConverter;

class TicketPrinter
{
	/**
	 * @var array
	 */
	private $ticketsToPrint;

	/**
	 * @param $ticketArray
	 */
	function __construct($ticketArray = array())
	{
		$this->ticketsToPrint = $ticketArray;
	}

	/**
	 * @param array $ticketArray
	 */
	public function printTickets($ticketArray = array())
	{
		if (empty($this->ticketsToPrint)) {
			$this->ticketsToPrint = $ticketArray;
		}

		foreach ($this->ticketsToPrint as $ticket) {
			$this->parseTicketToFo($ticket);
			$this->parseTicketToPDF();
			$this->sendPrintTask();
		}
	}

	/**
	 * @param $ticketData
	 */
	private function parseTicketToFo($ticketData)
	{
		$xlstToFoConverter = new XsltToFoTicketConverter();
		$xlstToFoConverter->convertTicket($ticketData);
	}

	/**
	 *
	 */
	private function parseTicketToPDF()
	{
		$foToPdfConverter = new FoToPDFTicketConverter();
		$foToPdfConverter->convertTicket();
	}

	/**
	 * 
	 */
	private function sendPrintTask()
	{
		exec('lp -d ' . config('printer.printerName') . ' -o media=A6 -o landscape ' . config('printer.pdfOutputPath'));
	}
} 