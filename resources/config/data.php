<?php

return [
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
		'Balance of Plant Electrical Works, Transmission Line Interconnection and Other Associated Works for 6 Mv Sg. Slim Mini Hydro',
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
	]

];