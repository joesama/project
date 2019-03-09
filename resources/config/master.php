<?php

return [
	'role' => [
		'user' => ['Group Admin', 'Subsidiary Admin', 'Staff'],
		'profile' => ['Admin','Project Manager','Reviewer','Approver','Validator','Viewer','BODs']
	],
	'master' => [
		'status' => [
			'New', 'Approved', 'Validated', 'Reviewed', 'Accepted', 'Updated', 'Active'
		],
		'progress' => ['0-25','26-50','51-75','76-100'],
		'severity' => ['low','medium','critical'],
		'hse' => [	'Lost Time Injuries (LTI)','Unsafe Act / Unsafe Condition',
					'Stop Work Order','Summon By Authorities','Complaint By Communities'],
		'position' => [
			'Asisstant Manager', 'Senior Manager',
			'Asisstant General Manager', 'General Manager', 
			'Vice President', 'COO', 'CEO'
		],
		'active' => ['open','closed','resolved'],
		'indicator' => ['hijau','kuning','merah'],
	],
	'corporate' => [
		'KUB Malaysia' => [
			'agro_jpg' => 'KUB Agro Holdings Sdn Bhd',
			'sepadu_png' => 'KUB Sepadu Sdn Bhd',
			'mill_png' => 'KUB Maju Mill Sdn Bhd',
			'malua_jpg' => 'KUB Malua Plantation Sdn Bhd',
			'tel_png' => 'KUB Telekomunikasi Sdn Bhd',
			'kft_png' => 'KFT International (Malaysia) Sdn Bhd',
			'emp_png' => 'Empirical Systems (M) Sdn Bhd',
			'gaz_png' => 'KUB Gaz Sdn Bhd',
			'pera_png' => 'Peraharta Sdn Bhd',
			'tower_png' => 'KUB Tower Sdn Bhd',
			'power_png' => 'KUB Power Sdn Bhd',
		]
	],
	'status' => [
		'color' => [
			1 => 'success',
			2 => 'warning',
			3 => 'danger',
 		],
 		'icon' => [
 			1 => 'fa fa-check-circle',
 			2 => 'fa fa-exclamation-circle',
 			3 => 'fa fa-exclamation-circle'
 		]
	],
	'process' => [
		'project' => [
			1 => [2],
			5 => [3],
			6 => [2],
			2 => [3]
		],
		'report' => [
			1 => [2],
			2 => [4],
			3 => [5],
			4 => [3],
			5 => [4],
			7 => [7],
		]
	]
];