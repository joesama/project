<?php

return [
	'module' => 'Project Management Officer',
	'detail' => 'Project Information',
	'date' => [
		'report' =>  'Report Date'
	],
	'info' => [
		'name' => 'Project Name',
		'contract' => [
			'no'=> 'Contract No.',
			'value'=> 'Total Contract Value',
			'scope'=> 'Scope of Contract',
			'date'=> [
				'start' => 'Start Date',
				'end' => 'End Date (Planned)',
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
	]
];