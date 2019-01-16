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
				'form' => ['corporateId','projectId?','dataId?'],
				'view' => ['corporateId','projectId','dataId?']
			],
			'issue' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?','dataId?'],
				'view' => ['corporateId','projectId','dataId?']
			],
			'risk' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?','dataId?'],
				'view' => ['corporateId','projectId','dataId?']
			],
			'partner' => [
				'list' => ['corporateId','projectId'],
				'form' => ['corporateId','projectId?','dataId?'],
				'no_menu' => TRUE
			],
			'attribute' => [
				'list' => ['corporateId','projectId'],
				'form' => ['corporateId','projectId','dataId?'],
				'no_menu' => TRUE
			],
			'hse' => [
				'form' => ['corporateId','projectId'],
				'list' => ['corporateId','projectId'],
				'no_menu' => TRUE
			],
			'financial' => [
				'list' => ['corporateId','projectId','dataId?'],
				'vo' => ['corporateId','projectId'],
				'voform' => ['corporateId','projectId','dataId?'],
				'retention' => ['corporateId','projectId'],
				'retentionform' => ['corporateId','projectId','dataId?'],
				'lad' => ['corporateId','projectId'],
				'ladform' => ['corporateId','projectId','dataId?'],
				'revise' => ['corporateId','projectId','dataId?'],
				'claim' => ['corporateId','projectId'],
				'payment' => ['corporateId','projectId','dataId?'],
				'no_menu' => TRUE
			],
			'icon' => 'psi-folder-archive icon-lg icon-fw'
		],
		'dashboard' => [
			'portfolio' => [
				'master' => ['corporateId'],
				'group' => ['corporateId'],
				'subsidiaries' => ['corporateId'],
			],
			'icon' => 'psi-dashboard icon-lg icon-fw'
		],
		'corporate' => [
			'profile' => [
				'list' => ['corporateId','masterId?'],
				'form' => ['corporateId','masterId?'],
				'view' => ['corporateId','masterId'],
				'assign' => ['corporateId','masterId'],
			],
			'client' => [
				'list' => ['corporateId'],
				'form' => ['corporateId','masterId?'],
				'view' => ['corporateId','masterId']
			],
			'icon' => 'psi-business-man-woman icon-lg icon-fw'
		],
		'report' => [
			'monthly' => [
				'list' => ['corporateId','projectId'],
				'form' => ['corporateId','projectId'],
				'view' => ['corporateId','projectId']
			],
			'weekly' => [
				'list' => ['corporateId','projectId'],
				'form' => ['corporateId','projectId'],
				'view' => ['corporateId','projectId']
			],
			'icon' => 'psi-notepad icon-lg icon-fw'
		]
	],
	'api' => [
		'GET' => [
			'list' => [
				'project' => ['corporateId'], 
				'task' => ['corporateId','projectId?'], 
				'issue' => ['corporateId','projectId?'],
				'risk' => ['corporateId','projectId?'],
				'master' => ['corporateId','masterId?'],
				'data' => ['corporateId','masterId?'],
				'client' => ['corporateId','projectId?'],
				'incident' => ['corporateId','projectId'],
				'payment' => ['corporateId','projectId'],
				'vo' => ['corporateId','projectId'],
				'retention' => ['corporateId','projectId'],
				'lad' => ['corporateId','projectId'],
				'partner' => ['corporateId','projectId'],
				'attribute' => ['corporateId','projectId'],
				'profile' => ['corporateId','masterId?'],
				'weekly' => ['corporateId','projectId'],
				'monthly' => ['corporateId','projectId'],
			],
			'profile' => [
				'reassign' => ['masterId','projectId']
			]
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
			],
			'profile' => [
				'save' => ['corporateId','masterId?'],
				'assign' => ['corporateId','masterId']
			],
			'financial' => [
				'claim' => ['corporateId','projectId'],
				'payment' => ['corporateId','projectId','paymentId?'],
				'vo' => ['corporateId','projectId','voId?'],
				'retention' => ['corporateId','projectId','retentionId?'],
				'lad' => ['corporateId','projectId','ladId?']
			],
			'workflow' => [
				'process' => ['corporateId','projectId']
			]
		],
	],
	'dashboard' => [
		'task' => ['read','write'],
		'issue' => ['read','write'],
		'risk' => ['read','write']
	]
];