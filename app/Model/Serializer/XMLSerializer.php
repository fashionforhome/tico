<?php

namespace App\Model\Serializer;

class XMLSerializer
{
	/**
	 * @var \XMLWriter
	 */
	private $buffer;

	/**
	 * @var Array
	 */
	private $ticket;

	/**
	 *
	 */
	function __construct()
	{
		$this->buffer = new \XMLWriter();
		$this->buffer->openMemory();
	}

	/**
	 * @param array $ticket
	 * @return string
	 */
	public function serialize($ticket)
	{
		$this->buffer->writeRaw('<?xml version="1.0" encoding="utf-8"?>');
		$this->buffer->startElement('ticket');
		$this->generateTicket($ticket);
		$this->buffer->endElement();

		return $this->buffer->outputMemory();
	}

	/**
	 * @param $ticket
	 */
	private function generateTicket($ticket)
	{
		$this->ticket = $ticket;
		$this->writeSingleElement('key');
		$this->writeSingleElement('reporter');
		$this->writeSingleElement('issueType');
		$this->writeImagePathElement();
		$this->writeSingleElement('sprint');
		$this->writeSingleElement('summary');
		$this->writeSingleElement('devTeam');
		$this->writeSingleElement('hasSubTasks');
		$this->writeSingleElement('storyPoints');

		if (isset($this->ticket['epicData'])) {
			$this->buffer->startElement('epic');
			$this->buffer->writeElement('key', $this->ticket['epicData']['key']);
			$this->buffer->writeElement('summary', $this->ticket['epicData']['summary']);
			$this->buffer->endElement();
		}

		if (isset($this->ticket['parentData'])) {
			$this->buffer->startElement('parent');
			$this->buffer->writeElement('key', $this->ticket['epicData']['key']);
			$this->buffer->writeElement('summary', $this->ticket['epicData']['summary']);
			$this->buffer->endElement();
		}
	}

	/**
	 * @param String $identifier
	 */
	private function writeSingleElement($identifier)
	{
		if (isset($this->ticket[$identifier])) {
			$this->buffer->writeElement($identifier, $this->ticket[$identifier]);
		}
	}

	/**
	 * 
	 */
	private function writeImagePathElement()
	{
		if (isset($this->ticket['issueType']) && $this->ticket['issueType'] == 'Epic' || $this->ticket['issueType'] == 'Bug') {
			$this->buffer->writeElement('imagePath', config('printer.imagePath')[$this->ticket['issueType']]);
		} else {
			// check for mother ship conditions
			if (isset($this->ticket['hasSubTasks']) &&
				isset($this->ticket['issueType']) &&
				$this->ticket['hasSubTasks'] == 1 &&
				$this->ticket['issueType'] == 'Story'
			) {
				$this->buffer->writeElement('imagePath', config('printer.imagePath')['MotherShip']);
			}
		}
	}
}