<?php

use App\Model\Parser\JiraParser;

class JiraParserTest extends TestCase
{
    /**
     * Tests the happy case for parsing an issue.
     *
     * @covers \App\Model\Parser\JiraParser::parseIssue
     */
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

        $mockBuilder = $this->getMockBuilder('\App\Model\Parser\JiraParser');
        $mockBuilder->setMethods([
            'getConfig'
        ]);

        $parser = $mockBuilder->getMock();
        $parser->expects($this->exactly(7))
            ->method('getConfig')
            ->withConsecutive(
                [$this->equalTo('jira.customFields.devTeam')],
                [$this->equalTo('jira.customFields.devTeam')],
                [$this->equalTo('jira.customFields.storyPoints')],
                [$this->equalTo('jira.customFields.storyPoints')],
                [$this->equalTo('jira.customFields.epic')],
                [$this->equalTo('jira.customFields.sprintName')],
                [$this->equalTo('jira.customFields.sprintName')]
            )
            ->will(
                $this->onConsecutiveCalls(
                    'customfield_10363',
                    'customfield_10363',
                    'customfield_10023',
                    'customfield_10023',
                    '',
                    'customfield_10560',
                    'customfield_10560'
                )
            );

		$result = $parser->parseIssue($inputData);

		$this->assertEquals($expectedResult, $result);
	}

    /**
     * Dataprovider providing happy test values for ValidateCustomFields.
     *
     * @return array
     */
	public function dataProviderCustomFieldsHappy()
    {
        $field1 = [
            'fields' => [
                'customfield1' => 'customdata1'
            ]
        ];

        $field2 = [
            'fields' => [
                'ticketNumer' => 'JIRA-123',
                'secondCustomfield' => '',
                'reporter' => 'Klara Fall'
            ]
        ];

        return [
            [
                'jira.Key1',
                'customfield1',
                $field1
            ],
            [
                'jira.Key2',
                'secondCustomfield',
                $field2
            ]
        ];
    }

    /**
     * Test the happy cases for validateCustomField.
     *
     * @param string $configKey Key of the config.
     * @param string $configValue The value relating to the config key.
     * @param array $ticketData The ticket data to test against.
     *
     * @dataProvider dataProviderCustomFieldsHappy
     * @covers \App\Model\Parser\JiraParser::validateCustomField
     */
    public function testValidateCustomFieldsHappy($configKey, $configValue, $ticketData)
    {
        /** @var JiraParser $parser */
        $parser = $this->getJiraParserMockForValidationCustomFields($configKey, $configValue);


        $this->assertTrue(
            $parser->validateCustomField($configKey, $ticketData),
            'Expected that this custom field setting matches.'
        );
    }

    /**
     * Dataprovider providing unhappy test values for ValidateCustomFields.
     *
     * @return array
     */
    public function dataProviderCustomFieldsUnhappy()
    {
        $field1 = [
            'fields' => [
                'customfield1' => null
            ]
        ];

        $field2 = [
            'fields' => [
                'ticketNumer' => 'JIRA-123',
                'reporter' => 'Klara Fall'
            ]
        ];

        return [
            [
                'jira.Key1',
                'customfield1',
                $field1
            ],
            [
                'jira.Key2',
                'customfield2',
                $field2
            ],
            [
                'jira.Key3',
                null,
                ['this is unused in this case']
            ],
            [
                'jira.Key4',
                '',
                ['this is unused in this case']
            ],
            [
                '',
                null,
                ['this is unused in this case']
            ],
            [
                null,
                null,
                ['this is unused in this case']
            ]
        ];
    }

    /**
     * Test the unhappy cases for validateCustomField.
     *
     * @param string $configKey Key of the config.
     * @param string $configValue The value relating to the config key.
     * @param array $ticketData The ticket data to test against.
     *
     * @dataProvider dataProviderCustomFieldsUnhappy
     * @covers \App\Model\Parser\JiraParser::validateCustomField
     */
    public function testValidateCustomFieldsUnhappy($configKey, $configValue, $ticketData)
    {
        /** @var JiraParser $parser */
        $parser = $this->getJiraParserMockForValidationCustomFields($configKey, $configValue);


        $this->assertFalse(
            $parser->validateCustomField($configKey, $ticketData),
            'Expected that this custom field setting does not match.'
        );
    }


    /**
     *
     * Returns a Mock of the JiraParser.
     *
     * @param $configKey
     * @param $configReturnValue
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getJiraParserMockForValidationCustomFields($configKey, $configReturnValue)
    {
        $mockBuilder = $this->getMockBuilder('\App\Model\Parser\JiraParser');
        $mockBuilder->setMethods([
           'getConfig'
        ]);

        $mock = $mockBuilder->getMock();
        $mock->expects($this->once())
            ->method('getConfig')
            ->with($this->equalTo($configKey))
            ->willReturn($configReturnValue);
        return $mock;
    }
}
