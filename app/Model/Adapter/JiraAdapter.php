<?php

namespace App\Model\Adapter;

use App\Model\Parser\JiraParser;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

/**
 * adapter for fetching issue data from an jira endpoint
 *
 * Class JiraAdapter
 */
class JiraAdapter
{
	/**
	 * @var \Guzzle\Http\Client
	 */
	private $client;

	/**
	 * @var JiraParser
	 */
	private $parser;

	/**
	 *
	 */
	public function __construct()
	{
		// init the client
		$this->client = new Client();
		$this->client->setDefaultOption('auth', [env('JIRA_USERNAME'), env('JIRA_PASSWORD')]);
		$this->client->setDefaultOption('verify', false);

		$this->parser = new JiraParser(config('jira.BaseUrl'));
	}

	/**
	 * builds an api endpoint url
	 *
	 * @param string $ticketIdentifier
	 * @return string
	 */
	private function buildTicketUrl($ticketIdentifier)
	{
		return config('jira.baseUrl') . $ticketIdentifier;
	}

	/**
	 * returns an array of issue and error data
	 *
	 * @param array $ticketList
	 * @return array[]
	 */
	public function getIssuesByKeys($ticketList = array())
	{
		if (empty($ticketList)) {
			return $ticketList;
		}

		$tickets = array();
		$errors  = array();
		$results = array();

		foreach ($ticketList as $ticketIdentifier) {
			$resJson = '';
			$req     = $this->client->get($this->buildTicketUrl($ticketIdentifier), array());
			$req->setHeader('Content-Type', 'application/json');
			try {
				$res     = $req->send($req);
				$resJson = $res->json();
			} catch (ClientErrorResponseException $e) {
				$errors[] = $ticketIdentifier;
			}

			if (!empty($resJson)) {
				$tickets[] = $this->parser->parseIssue($resJson);
			}
		}

		$results['tickets'] = $tickets;
		$results['errors']  = $errors;

		return $results;
	}

	/**
	 * @param $ticketIdentifier
	 * @return array|\mixed[]
	 */
	public function getEpicTicketData($ticketIdentifier)
	{
		$errors = array();
		$result = array();

		$req = $this->client->get($this->buildTicketUrl($ticketIdentifier), array());
		$req->setHeader('Content-Type', 'application/json');
		try {
			$res     = $req->send($req);
			$resJson = $res->json();
		} catch (ClientErrorResponseException $e) {
			$errors[] = $ticketIdentifier;
		}

		if (!empty($resJson)) {
			$result = $this->parser->parseEpic($resJson);
		}

		return $result;
	}
}