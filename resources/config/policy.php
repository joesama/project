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
			'flow' => [
				'list' => ['corporateId'],
				'form' => ['corporateId','masterId?',],
				'view' => ['corporateId','masterId'],
			],
			'step' => [
				'list' => ['corporateId','masterId'],
				'form' => ['corporateId','masterId','stepId?'],
				'view' => ['corporateId','masterId','stepId'],
				'no_menu' => TRUE
			],
			'icon' => 'pli-wrench icon-lg icon-fw'
		],
		'manager' => [
			'dashboard' => [
				'overall' => ['corporateId']
			],
			'project' => [
				'list' => ['corporateId','projectId?'],
				'approval' => ['corporateId','projectId?'],
				'info' => ['corporateId','projectId?','infoId?'],
				'form' => ['corporateId','projectId?'],
				'view' => ['corporateId','projectId','reportId?']
			],
			'task' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId?','dataId?'],
				'view' => ['corporateId','projectId','dataId?']
			],
            'plan' => [
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
				'form' => ['corporateId','projectId','dataId?'],
				'list' => ['corporateId','projectId'],
				'no_menu' => TRUE
			],
			'financial' => [
				'view' => ['corporateId','projectId','dataId?'],
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
			'physical' => [
				'list' => ['corporateId','projectId'],
				'milestone' => ['corporateId','projectId','milestoneId?'],
				'no_menu' => TRUE
			],
			'finance' => [
				'list' => ['corporateId','projectId'],
				'milestone' => ['corporateId','projectId','milestoneId?'],
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
			'notification' => [
				'list' => ['corporateId'],
				'view' => ['corporateId','masterId']
			],
			'icon' => 'psi-business-man-woman icon-lg icon-fw'
		],
		'report' => [
			'monthly' => [
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId','reportId?'],
				'view' => ['corporateId','projectId','reportId?']
			],
			'weekly' => [
				'redirect' => ['reportId'],
				'list' => ['corporateId','projectId?'],
				'form' => ['corporateId','projectId','reportId?'],
				'view' => ['corporateId','projectId','reportId?']
			],
			'icon' => 'psi-notepad icon-lg icon-fw'
		]
	],
	'api' => [
		'GET' => [
			'list' => [
				'project' => ['corporateId'], 
				'task' => ['corporateId','projectId?'], 
				'plan' => ['corporateId','projectId?'], 
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
				'weekly' => ['corporateId?','projectId?'],
				'week' => ['corporateId','projectId?','profileId?'],
				'monthly' => ['corporateId','projectId?'],
				'approval-project' => ['corporateId','projectId?'],
				'approval-dashboard' => ['corporateId','projectId?'],
				'physical' => ['corporateId','projectId'],
				'finance' => ['corporateId','projectId'],
				'upload' => ['corporateId','projectId'],
				'flow' => ['corporateId'],
				'step' => ['corporateId','flowId']
			],
			'profile' => [
				'reassign' => ['masterId','projectId']
			],
			'partner' => [
				'delete' => ['corporateId','projectId','partnerId']
			],
			'attribute' => [
				'delete' => ['corporateId','projectId','attributeId']
			],
			'task' => [
				'delete' => ['corporateId','projectId','taskId']
			],
			'plan' => [
				'delete' => ['corporateId','projectId','taskId']
			],
			'issue' => [
				'delete' => ['corporateId','projectId','issueId']
			],
			'risk' => [
				'delete' => ['corporateId','projectId','issueId']
			],
			'incident' => [
				'delete' => ['corporateId','projectId','hseId']
			],
			'financial' => [
				'delete' => ['corporateId','projectId','financialId'],
				'vodelete' => ['corporateId','projectId','financialId'],
				'retentiondelete' => ['corporateId','projectId','financialId'],
				'laddelete' => ['corporateId','projectId','financialId'],
				'scurve' => ['corporateId','projectId']
			],
			'physical' => [
				'delete' => ['corporateId','projectId','milestoneId']
			],
			'finance' => [
				'delete' => ['corporateId','projectId','milestoneId']
			],
			'upload' => [
				'download' => ['corporateId','projectId','uploadId'],
				'delete' => ['corporateId','projectId','uploadId']
			],
			'flow' => [
				'delete' => ['corporateId','flowId']
			],
			'step' => [
				'delete' => ['corporateId','flowId','stepId']
			],
		],
		'POST' => [
			'project' => [
				'save' => ['corporateId','projectId?']
			],
			'task' => [
				'save' => ['corporateId','projectId?','taskId?']
			],
			'plan' => [
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
				'save' => ['corporateId','projectId','incidentId?']
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
				'approval' => ['corporateId','projectId'],
				'update' => ['corporateId','projectId','infoId?'],
				'week' => ['corporateId','projectId','reportId?'],
				'month' => ['corporateId','projectId','reportId?'],
				'process' => ['corporateId','projectId','reportId?']
			],
			'physical' => [
				'save' => ['corporateId','projectId','milestoneId?']
			],
			'finance' => [
				'save' => ['corporateId','projectId','milestoneId?']
			],
			'upload' => [
				'save' => ['corporateId','projectId?']
			],
			'flow' => [
				'save' => ['corporateId','flowId?']
			],
			'step' => [
				'save' => ['corporateId','flowId','stepId?']
			],
		]
	],
	'dashboard' => [
		'task' => ['read','write'],
		'issue' => ['read','write'],
		'risk' => ['read','write']
	]
];