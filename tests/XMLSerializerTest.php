<?php

use App\Model\Serializer\XMLSerializer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class XMLSerializerTest extends TestCase
{
	/**
	 * test if serialize returns proper XML
	 */
	public function testSerialize()
	{
		$testInput = array(
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

		$xmlSerializer    = new XMLSerializer();
		$expectedResult   = '<?xml version="1.0" encoding="utf-8"?><ticket><key>testKey</key><reporter>test</reporter><issueType>testIssue</issueType><sprint>W-Sprint 17.11.2015</sprint><summary>testSummary</summary><devTeam>devTeam</devTeam><hasSubTasks>0</hasSubTasks><storyPoints>5</storyPoints></ticket>';
		$unExpectedResult = '<ticket><key>testKey</key><reporter>test</reporter><issueType>testIssue</issueType><sprint>W-Sprint 17.11.2015</sprint><summary>testSummary</summary><devTeam>devTeam</devTeam><hasSubTasks>0</hasSubTasks><storyPoints>5</storyPoints></ticket>';

		$this->assertEquals($expectedResult, $xmlSerializer->serialize($testInput), 'Xml is not build properly');
		$this->assertNotEquals($unExpectedResult, $xmlSerializer->serialize($testInput), 'XML header is missing');
	}
}
