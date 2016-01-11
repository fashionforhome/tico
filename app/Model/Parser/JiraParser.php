<?php

namespace App\Model\Parser;

use App\Model\Adapter\JiraAdapter;

/**
 * parses the response of the jira endpoint to a clean uniform data set
 *
 * Class JiraParser
 */
class JiraParser
{
	/**
	 * parses the jira response and returns clean data set
	 *
	 * @param mixed[] $data
	 * @return mixed[]
	 */
	public function parseIssue($data)
	{
		$cleanData = array();

		// extract key
		$cleanData['key'] = $data['key'];
		// extract summary
		$cleanData['summary'] = $data['fields']['summary'];
		// extract issue type by name
		$cleanData['issueType'] = $data['fields']['issuetype']['name'];
		// extract issue type by Id
		$cleanData['issueTypeId'] = $data['fields']['issuetype']['id'];
		// extract PorjectKey
		$cleanData['projectKey'] = $data['fields']['project']['key'];
		// extract devTeam
		$cleanData['devTeam'] = $data['fields']['customfield_10363']['name'];
		// extract Reporter
		$cleanData['reporter'] = $data['fields']['reporter']['displayName'];

		if (isset($data['fields']['customfield_10023'])) {
			// extract storypoints when set
			$cleanData['storyPoints'] = $data['fields']['customfield_10023'];
		}

		// extract epic
		if (isset($data['fields']['customfield_10860'])) {
			$jiraAdapter = new JiraAdapter();

			$cleanData['epicData'] = $jiraAdapter->getEpicTicketData($data['fields']['customfield_10860']);
		}

		if (count($data['fields']['subtasks']) > 0) {
			$cleanData['hasSubTasks'] = 1;
		} else {
			$cleanData['hasSubTasks'] = 0;
		}

		if (isset($data['fields']['parent'])) {
			$cleanData['parent']['key']     = $data['fields']['parent']['key'];
			$cleanData['parent']['summary'] = $data['fields']['parent']['fields']['summary'];
		}

		// extract sprint name
		if (preg_match("/,name=([^,]+),/mi", $data['fields']['customfield_10560'][0], $match)) {
			$cleanData['sprint'] = $match[1];
		} else {
			$cleanData['sprint'] = '';
		}

		return $cleanData;
	}

	/**
	 * @param $data
	 * @return array
	 */
	public function parseEpic($data)
	{
		$cleanData = array();

		// extract key
		$cleanData['key'] = $data['key'];
		// extract summary
		$cleanData['summary'] = $data['fields']['summary'];

		return $cleanData;
	}
}