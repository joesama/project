<?php

// available parameter corporateId, projectId, taskId

return [
	'web' => [
		'setup' => [
			'master' => [
				'list' => ['corporateId'],
				'form' => ['corporateId','masterId?'],
				'view' => ['corporateId','masterId']
			],
			'client' => [
				'list' => ['corporateId'],
				'form' => ['corporateId','masterId?'],
				'view' => ['corporateId','masterId']
			],
			'data' => [
				'list' => ['corporateId','masterId'],
				'form' => ['corporateId','masterId','dataId?'],
				'view' => ['corporateId','masterId','dataId'],
				'no_menu' => TRUE
			],
			'icon' => 'pli-wrench icon-lg icon-fw'
		],
		'manager' => [
			'dashboard' => [
				'overall' => ['corporateId']
			],
			'project' => [
				'list' => ['corporateId'],
				'form' => ['corporateId','projectId?'],
				'view' => ['corporateId','projectId']
			],
			'task' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?','taskId?'],
				'view' => ['corporateId','projectId','taskId?']
			],
			'issue' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?','issueId?'],
				'view' => ['corporateId','projectId','issueId?']
			],
			'risk' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?','riskId?'],
				'view' => ['corporateId','projectId','riskId?']
			],
			'partner' => [
				'form' => ['corporateId','projectId?','partnerId?'],
				'no_menu' => TRUE
			],
			'attribute' => [
				'form' => ['corporateId','projectId','attrId?'],
				'no_menu' => TRUE
			],
			'hse' => [
				'form' => ['corporateId','projectId'],
				'list' => ['corporateId','projectId'],
				'no_menu' => TRUE
			],
			'icon' => 'psi-folder-archive icon-lg icon-fw'
		]
	],
	'api' => [
		'GET' => [
			'list' => [
				'project' => ['corporateId'], 
				'task' => ['corporateId','projectId?'], 
				'issue' => ['corporateId','projectId?'],
				'risk' => ['corporateId','projectId?'],
				'master' => ['corporateId','projectId?'],
				'data' => ['corporateId','projectId?'],
				'client' => ['corporateId','projectId?'],
				'incident' => ['corporateId','projectId'],
			],
		],
		'POST' => [
			'project' => [
				'save' => ['corporateId','projectId?']
			],
			'task' => [
				'save' => ['corporateId','projectId?','taskId?']
			],
			'issue' => [
				'save' => ['corporateId','projectId?','issueId?']
			],
			'risk' => [
				'save' => ['corporateId','projectId?','issueId?']
			],
			'partner' => [
				'save' => ['corporateId','projectId?','partnerId?']
			],
			'attribute' => [
				'save' => ['corporateId','projectId?','attrId?']
			],
			'master' => [
				'save' => ['corporateId','masterId?']
			],
			'data' => [
				'save' => ['corporateId','masterId','dataId?']
			],
			'client' => [
				'save' => ['corporateId','masterId?']
			],
			'incident' => [
				'save' => ['corporateId','masterId?']
			]
		],
	],
	'dashboard' => [
		'task' => ['read','write'],
		'issue' => ['read','write'],
		'risk' => ['read','write']
	]
];