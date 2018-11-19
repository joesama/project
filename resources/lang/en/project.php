<?php

return [
	'module' => 'Project Management Officer',
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
	'category' => [
		'schedule' => 'Project Schedule',
		'progress' => [
			'physical' => 'Physical (S-Curve)',
			'finance' => 'Financial (S-Curve)',
		],
		'issue' => 'Issues',
		'financial' => 'Financial Tracker',
		'hse' => 'Health & Safety Environment (HSE)'
	]
];