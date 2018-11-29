<?php

return [
	'module' => 'Project Management Office',
	'dashboard' => 'Project Dashboard',
	'detail' => 'Project Information',
	'summary' => 'Project Summary',
	'action' => 'Action',
	'date' => [
		'report' =>  'Report Date',
		'data' =>  'Data As Dated'
	],
	'info' => [
		'name' => 'Project Name',
		'contract' => [
			'no'=> 'Contract No.',
			'value'=> 'Total Contract Value',
			'scope'=> 'Scope of Contract',
			'date'=> [
				'start' => 'Start Date',
				'end' => 'End Date',
			],
			'gp' => [
				'original' => 'GP - Proposed',
				'latest' => 'GP - Latest Calc.',
			],
			'bond' => 'Performance Bond',
			'eot' => 'Extension of Time',
		]
	],
	'client' => [
		'name' => 'Client Name',
		'tel' => 'Tel / Fax No.',
		'pm' => 'Client Project Mgr',
		'contact' => 'Contact No.',
		'partner' => [
			'name' => 'Partner',
			'tel' => 'Tel / Fax No.',
			'pm' => 'Partner Project Mgr',
			'contact' => 'Contact No.',
		],
	],
	'task' => [
		'task' => 'Tasks',
		'progress' => 'Progress',
		'date' => [
			'start' => 'Date Start',
			'end' => 'Date End',
		],
	],
	'issues' => [
		'name' => 'Issues',
		'status' => 'Status',
		'dateline' => 'Dateline',
		'progress' => 'Progress',
	],
	'progress' => [
		'name' => 'Progress',
		'status' => 'Status',
		'var' => 'Variance',
	],
	'owner' => [
		'prepared' => 'Prepared By',
		'approval' => 'Approved By',
		'validate' => 'Validate By',
		'review' => 'Review By',
		'name' => 'Name',
		'mobile' => 'Mobile No.',
		'position' => 'Position',
	],
	'category' => [
		'schedule' => 'Project Schedule',
		'progress' => [
			'physical' => 'Physical (S-Curve)',
			'finance' => 'Financial (S-Curve) - Amount Claimed',
		],
		'issue' => 'Issues',
		'financial' => 'Financial Tracker',
		'hse' => 'Health & Safety Environment (HSE)',
		'owner' => 'Project Owner'
	],
	'scurve' => [
		'physical' => 'Physical (S-Curve)',
		'financial' => 'Financial (S-Curve) - Amount Claimed',
		'month' => 'Month',
		'plan' => 'Planned',
		'actual' => 'Actual',
	]
];