<?php

return [
	'status' => [
		'color' => [
			1 => 'success',
			2 => 'warning',
			3 => 'danger',
 		],
 		'icon' => [
 			1 => 'fas fa-check-circle',
 			2 => 'fas fa-exclamation-circle',
 			3 => 'fas fa-exclamation-circle'
 		]
	],
	'priority' => [
		'high' => 'danger' , 'medium' => 'warning' , 'low' => 'info'
	],
	'hse' => [
		'total_hours' => 'Total Project Hours',
		'acc_lti' => 'Accumulate Lost Time Injury (LTI)',
		'zero_lti' => 'Zero Lost Time Injuries (LTI)',
		'condition' => 'Unsafe Act / Unsafe Condition',
		'stop' => 'Stop Work Order (To Date)',
		'summon' => 'Summon by authorities (To Date)',
		'complaint' => 'Complaint by communities (To Date)',
	],
	'unit' => [
		'total_hours' => 'Hrs',
		'acc_lti' => 'Hrs',
		'zero_lti' => 'Hrs',
		'condition' => 'Qty',
		'stop' => 'Qty',
		'summon' => 'Qty',
		'complaint' => 'Qty',
	],
	'project' => [
		[ 	'id' => 1,
			'name' => 'Balance of Plant Electrical Works, Transmission Line Interconnection and Other Associated Works for 6 Mv Sg. Slim Mini Hydro',
			'contract' => 'KUB/2018/E/B/001',
			'start' => '01-07-2016',
			'end' => '31-07-2019',
		]
	],
	'portfolio' => [
		'project' => [
			'group' => 18
		],
		'contract' => [
			'group' => 47
		],
		'budget' => [
			'group' => 5
		],
		'issue' => [
			'group' => 3
		],
		'task' => [
			'group' => 2
		],
	],
	'subsidiary' => [
		'tel' => [
			'name' => 'KUB Tel',
			'budget' => [
				'stat' => 'Over Budget',
				'data' => [
					['Month', 'Planned', 'Actual'],
					['Feb',  1000,      1200],
					['Jan',  1170,      1000],
					['March',  660,       1120],
					['Apr',  1030,      1000]
				],
			],
			'issue' => [
				['Issue','number'],
				['Open' , 28],
				['Closed' , 106]
			],
			'gp' => 0.5,
			'task' => 18
		],
		'agro' => [
			'name' => 'KUB Agro',
			'budget' => [
				'stat' => 'Under Budget',
				'data' => [
					['Month', 'Planned', 'Actual'],
					['Feb',  1000,      1000],
					['Jan',  1170,      1000],
					['March',  660,       660],
					['Apr',  1030,      1000]
				]
			],
			'issue' => [
				['Issue','number'],
				['Open' , 18],
				['Closed' , 66]
			],
			'gp' => 10.8,
			'task' => 19
		],
		'gas' => [
			'name' => 'KUB Gaz',
			'budget' => [
				'stat' => 'Under Budget',
				'data' => [
					['Month', 'Planned', 'Actual'],
					['Feb',  1000,      1000],
					['Jan',  1170,      1200],
					['March',  1550,       1000],
					['Apr',  1030,      1100]
				]
			],
			'issue' => [
				['Issue','number'],
				['Open' , 8],
				['Closed' , 16]
			],
			'gp' => 3.1,
			'task' => 10
		],
		'power' => [
			'name' => 'KUB Power',
			'budget' => [
				'stat' => 'Over Budget',
				'data' => [
					['Month', 'Planned', 'Actual'],
					['Feb',  1000,      1200],
					['Jan',  1170,      1000],
					['March',  660,       1120],
					['Apr',  1030,      1000]
				]
			],
			'issue' => [
				['Issue','number'],
				['Open' , 44],
				['Closed' , 127]
			],
			'gp' => 1.5,
			'task' => 23
		]
	],
	'tel' => [
		[ 
			'name' => 'Project A',
			'contract' => 2,
			'planned' => 100,
			'actual' => 95,
			'health' => 1,
			'resource' => [
				'Ali' => 3,
				'Abu' => 1,
				'Karim' => 1,
			],
			'task' => 4,
			'issue' => 2,
			'gp' => 1.2,
		],
		[ 
			'name' => 'Project B',
			'contract' => 0.7,
			'planned' => 150,
			'actual' => 165,
			'health' => 2,
			'resource' => [
				'Ali' => 0,
				'Abu' => 1,
				'Karim' => 1,
			],
			'task' => 3,
			'issue' => 1,
			'gp' => -0.8,
		],
		[ 
			'name' => 'Project C',
			'contract' => 1.2,
			'planned' => 200,
			'actual' => 188,
			'health' => 3,
			'resource' => [
				'Ali' => 0,
				'Abu' => 1,
				'Karim' => 1,
			],
			'task' => 8,
			'issue' => 3,
			'gp' => 0.5,
		],
	],
	'progress' => [
		[ 'task' => 'Letter of Acceptance (LOA)', 
		  'pic' => 'Azhar', 
		  'start' => '1-Jul-16', 
		  'end' => '18-Jul-16', 
		  'progress' => '100'
		],
		[ 'task' => 'Procurement', 
		  'pic' => 'Azhar', 
		  'start' => '27-Oct-16', 
		  'end' => '2-Nov-16', 
		  'progress' => '100'
		],
		[ 'task' => 'Design & Engeenering', 
		  'pic' => 'Azhar', 
		  'start' => '3-Nov-16', 
		  'end' => '27-Mar-17', 
		  'progress' => '81'
		],
		[ 'task' => 'Manufacturing', 
		  'pic' => 'Azhar', 
		  'start' => '13-Feb-17', 
		  'end' => '8-Apr-17', 
		  'progress' => '83'
		],
		[ 'task' => 'Factory Acceptance Test', 
		  'pic' => 'Azhar', 
		  'start' => '13-Feb-17', 
		  'end' => '8-Apr-17', 
		  'progress' => '63'
		],
		[ 'task' => 'Delivery', 
		  'pic' => 'Azhar', 
		  'start' => '16-Feb-17', 
		  'end' => '2-May-17', 
		  'progress' => '36'
		],
		[ 'task' => 'Erection', 
		  'pic' => 'Azhar', 
		  'start' => '3-Apr-17', 
		  'end' => '26-Jul-17', 
		  'progress' => '1'
		],
		[ 'task' => 'Testing and commissioning', 
		  'pic' => 'Azhar', 
		  'start' => '27-Jul-17', 
		  'end' => '31-Jul-17', 
		  'progress' => '0'
		]
	],
	'issues' => [
		[ 'name' => 'Land acquisition from Majlis Daerah Tg Malim & JKR for 33 kV transmission line work', 'priority' => 1 ],
		[ 'name' => "Equipment drawing approval from TNB via client's consultant for FAT to perform prior to delivery", 'priority' => 2 ],
		[ 'name' => 'Equipment delivery to PMU Slim River', 'priority' => 3 ]
	]
];