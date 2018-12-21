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
				'view' => ['projectId']
			],
			'task' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?'],
				'view' => ['taskId']
			],
			'issue' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?'],
				'view' => ['issueId']
			],
			'risk' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?'],
				'view' => ['riskId']
			],
			'icon' => 'fa fa-folder'
		]
	],
	'api' => [
		'list' => [
			'project' => ['corporateId'], 
			'task' => ['corporateId','projectId?'], 
			'issue' => ['corporateId','projectId?'],
			'risk' => ['corporateId','projectId?'],
		]
	]
];