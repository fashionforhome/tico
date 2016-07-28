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
        $cleanData['devTeam'] = '';
        if ($this->validateCustomField('jira.customFields.devTeam', $data) === true) {
            $cleanData['devTeam'] = $data['fields'][$this->getConfig('jira.customFields.devTeam')]['name'];
        }

        // extract Reporter
		$cleanData['reporter'] = $data['fields']['reporter']['displayName'];

        // extract storypoints
        $cleanData['storyPoints'] = '';
		if ($this->validateCustomField('jira.customFields.storyPoints', $data) === true) {
			$cleanData['storyPoints'] = $data['fields'][$this->getConfig('jira.customFields.storyPoints')];
		}

		// extract epic
		if ($this->validateCustomField('jira.customFields.epic', $data) === true) {
			$jiraAdapter = new JiraAdapter();

			$cleanData['epicData'] = $jiraAdapter->getEpicTicketData(
			    $data['fields'][$this->getConfig('jira.customFields.epic')]
            );
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
        if ($this->validateCustomField('jira.customFields.sprintName', $data) === true) {
            if (preg_match("/,name=([^,]+),/mi", $data['fields'][$this->getConfig('jira.customFields.sprintName')][0], $match)) {
                $cleanData['sprint'] = $match[1];
            } else {
                $cleanData['sprint'] = '';
            }
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

    /**
     * Validates that a custom field is configured correctly and the Jira response contents data for that custom field.
     *
     * @param string $configKey
     * @param array $ticketData
     * @return bool
     */
	public function validateCustomField($configKey, array $ticketData)
    {
        $config = $this->getConfig($configKey);
        if (empty($config) === true) {
            return false;
        }

        if (isset($ticketData['fields'][$config]) === false) {
            return false;
        }

        return true;
    }

    /**
     * Returns the config to a given key.
     *
     * @codeCoverageIgnore
     * @param string $key The key of the value you want to get.
     * @return mixed|null
     */
    protected function getConfig($key)
    {
        if (is_string($key) === false) {
            return null;
        }

        return config($key);
    }
}