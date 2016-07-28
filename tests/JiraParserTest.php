<?php

use App\Model\Parser\JiraParser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JiraParserTest extends TestCase
{
	public function testParseJiraIssue()
	{
		$inputData = array(
			'key' => 'testKey',
			'fields' => array(
				'summary' => 'testSummary',
				'issuetype' => array(
					'name' => 'testIssue',
					'id' => 1
				),
				'project' => array(
					'key' => 'testKey'
				),
				'customfield_10363' => array(
					'name' => 'devTeam'
				),
				'reporter' => array(
					'displayName' => 'test'
				),
				'customfield_10023' => 5,
				'parent' => array(
					'key' => 'testKey',
					'fields' => array(
						'summary' => 'testSummary'
					),
				),
				'customfield_10560' => array(
					'[,name=W-Sprint 17.11.2015,]'
				),
				'subtasks' => array()
			)
		);

		$expectedResult = array(
			'key' => 'testKey',
			'summary' => 'testSummary',
			'issueType' => 'testIssue',
			'issueTypeId' => 1,
			'projectKey' => 'testKey',
			'devTeam' => 'devTeam',
			'reporter' => 'test',
			'storyPoints' => 5,
			'hasSubTasks' => 0,
			'parent' => array(
				'key' => 'testKey',
				'summary' => 'testSummary',
			),
			'sprint' => 'W-Sprint 17.11.2015',
		);

		$parser = new JiraParser();
		$result = $parser->parseIssue($inputData);

		$this->assertEquals($expectedResult, $result);
	}
}
