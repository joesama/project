<?php

// available parameter corporateId, projectId, taskId

return [
	'web' => [
		'manager' => [
			'dashboard' => [
				'overall' => ['corporateId']
			],
			'project' => [
				'list' => ['corporateId'],
				'form' => ['corporateId'],
				'view' => ['corporateId','projectId']
			],
			'task' => [
				'list' => ['corporateId','projectId?','taskId?'],
				'form' => ['corporateId','projectId?','taskId?'],
				'view' => ['corporateId','projectId','taskId']
			],
			'issue' => [
				'list' => ['corporateId','projectId?','issueId?'],
				'form' => ['corporateId','projectId?','issueId?'],
				'view' => ['corporateId','projectId','issueId']
			],
			'risk' => [
				'list' => ['corporateId','projectId?','riskId?'],
				'form' => ['corporateId','projectId?','riskId?'],
				'view' => ['corporateId','projectId','riskId']
			],
			'icon' => 'fa fa-folder'
		]
	],
	'api' => [
		'GET' => [
			'list' => [
				'project' => ['corporateId'], 
				'task' => ['corporateId','projectId?'], 
				'issue' => ['corporateId','projectId?'],
				'risk' => ['corporateId','projectId?'],
			],
		],
		'POST' => [
			'task' => [
				'save' => ['corporateId','projectId','taskId?']
			]
		],
	]
];