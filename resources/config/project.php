<?php

return [
	'info' => [
		collect([ 	'id' => 1,
			'name' => 'Balance of Plant Electrical Works, Transmission Line Interconnection and Other Associated Works for 6 Mv Sg. Slim Mini Hydro',
			'start' => '01-07-2016',
			'end' => '31-07-2019',
			'pic' => 'Azhar',
			'client' => collect([
				'name' => 'Panzana Enterprise Sdn Bhd',
				'tel' => '03-20950849 (Tel) / 03-20951848 (fax)',
				'pmo' => 'Fadios Abd Rahman',
				'contact' => '012-9912084',
				'partner' => collect([
					'name' => 'China Western Power International Pte Ltd',
					'tel' => '1109017661@qq.com',
					'pmo' => 'Jiang Shuhong',
					'contact' => '65 9068 0208'
				])
			]),
			'contract' => collect([
				'no' => 'KUB/2018/E/B/001',
				'value' => 274000,
				'scope' => 'Construction and Engineering'
			])
		])
	],
	'issues' => [
		[ 'name' => 'Land acquisition from Majlis Daerah Tg Malim & JKR for 33 kV transmission line work', 'priority' => 1, 'dateline' => '20-Apr-2017', 'progress' => 100,'project_id' => 1,'id' => 1,'pic' => 'Azhar' ],
		[ 'name' => "Equipment drawing approval from TNB via client's consultant for FAT to perform prior to delivery", 'priority' => 2, 'dateline' => '28-Apr-2017', 'progress' => 100,'project_id' => 1,'id' => 2,'pic' => 'Azhar' ],
		[ 'name' => 'Equipment delivery to PMU Slim River', 'priority' => 3 , 'dateline' => '30-0ct-2017', 'progress' => 100,'project_id' => 1,'id' => 3, 'pic' => 'Azhar' ]
	],
	'risk' => [
		[ 'name' => 'Land acquisition from Majlis Daerah Tg Malim & JKR for 33 kV transmission line work', 'priority' => 1, 'dateline' => '20-Apr-2017', 'progress' => 100,'project_id' => 1,'id' => 1,'pic' => 'Azhar' ],
		[ 'name' => "Equipment drawing approval from TNB via client's consultant for FAT to perform prior to delivery", 'priority' => 2, 'dateline' => '28-Apr-2017', 'progress' => 100,'project_id' => 1,'id' => 2,'pic' => 'Azhar' ],
		[ 'name' => 'Equipment delivery to PMU Slim River', 'priority' => 3 , 'dateline' => '30-0ct-2017', 'progress' => 100,'project_id' => 1,'id' => 3, 'pic' => 'Azhar' ]
	],
	'report' => [
		[ 'name' => 'WEEK 38', 
		'date' => '21-Sept-2018', 
		'project_id' => 1,
		'id' => 1,
		'pic' => 'Azhar' ]
	],
	'task' => [
		collect([ 'task' => 'Letter of Acceptance (LOA)',
		  'code' => 'LOA',
		  'depend' => null,
		  'pic' => 'Azhar', 
		  'start' => '1-Jul-2016', 
		  'end' => '18-Jul-2016', 
		  'progress' => '100',
		  'project_id' => 1,
		  'id' => 1
		]),
		collect([ 'task' => 'Procurement', 
		  'code' => 'PRO',
		  'depend' => null, 
		  'pic' => 'Azhar', 
		  'start' => '15-Jul-2016', 
		  'end' => '20-Jul-2016', 
		  'progress' => '100',
		  'project_id' => 1,
		  'id' => 2
		]),
		collect([ 'task' => 'Design & Engeenering', 
		  'code' => 'DNE',
		  'depend' => null, 
		  'pic' => 'Azhar', 
		  'start' => '20-Nov-2016', 
		  'end' => '27-Mar-2017', 
		  'progress' => '81',
		  'project_id' => 1,
		  'id' => 3
		]),
		collect([ 'task' => 'Manufacturing',  
		  'code' => 'MAN',
		  'depend' => null, 
		  'pic' => 'Azhar', 
		  'start' => '13-Dec-2016', 
		  'end' => '8-Apr-2017', 
		  'progress' => '83',
		  'project_id' => 1,
		  'id' => 4
		]),
		collect([ 'task' => 'Factory Acceptance Test',   
		  'code' => 'FAT',
		  'depend' => null, 
		  'pic' => 'Azhar', 
		  'start' => '13-Feb-2017', 
		  'end' => '8-Apr-2017', 
		  'progress' => '63',
		  'project_id' => 1,
		  'id' => 5
		]),
		collect([ 'task' => 'Delivery',   
		  'code' => 'DLV',
		  'depend' => 'FAT', 
		  'pic' => 'Azhar', 
		  'start' => '16-Feb-2017', 
		  'end' => '2-May-2017', 
		  'progress' => '36',
		  'project_id' => 1,
		  'id' => 6
		]),
		collect([ 'task' => 'Erection',    
		  'code' => 'ERN',
		  'depend' => null, 
		  'pic' => 'Azhar', 
		  'start' => '3-Apr-2017', 
		  'end' => '31-Jul-2017', 
		  'progress' => '1',
		  'project_id' => 1,
		  'id' => 7
		]),
		collect([ 'task' => 'Testing and commissioning',    
		  'code' => 'COM',
		  'depend' => null, 
		  'pic' => 'Azhar', 
		  'start' => '1-Aug-2017', 
		  'end' => '31-Jul-2019', 
		  'progress' => '0',
		  'project_id' => 1,
		  'id' => 8
		])
	],
	'scurve' => collect([
		collect([ 
		  'id' => 1,
		  'project_id' => 1,
		  'physical_planned' => 0,
		  'physical_actual' => 0,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Jul-2016',
		]),
		collect([ 
		  'id' => 2,
		  'project_id' => 1,
		  'physical_planned' => 0,
		  'physical_actual' => 0,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Aug-2016',
		]),
		collect([ 
		  'id' => 3,
		  'project_id' => 1,
		  'physical_planned' => 0,
		  'physical_actual' => 0,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Sept-2016',
		]),
		collect([ 
		  'id' => 4,
		  'project_id' => 1,
		  'physical_planned' => 4,
		  'physical_actual' => 0,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Oct-2016',
		]),
		collect([ 
		  'id' => 5,
		  'project_id' => 1,
		  'physical_planned' => 9,
		  'physical_actual' => 1,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Nov-2016',
		]),
		collect([ 
		  'id' => 6,
		  'project_id' => 1,
		  'physical_planned' => 12,
		  'physical_actual' => 9,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Dec-2016',
		]),
		collect([ 
		  'id' => 7,
		  'project_id' => 1,
		  'physical_planned' => 38,
		  'physical_actual' => 22,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Jan-2017',
		]),
		collect([ 
		  'id' => 8,
		  'project_id' => 1,
		  'physical_planned' => 59,
		  'physical_actual' => 32,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Feb-2017',
		]),
		collect([ 
		  'id' => 9,
		  'project_id' => 1,
		  'physical_planned' => 67,
		  'physical_actual' => 43,
		  'financial_planned' => 0,
		  'financial_actual' => 0,
		  'month' => 'Mar-2017',
		]),
		collect([ 
		  'id' => 10,
		  'project_id' => 1,
		  'physical_planned' => 72,
		  'physical_actual' => 50,
		  'financial_planned' => 76400,
		  'financial_actual' => 58362,
		  'month' => 'Apr-2017',
		]),
		collect([ 
		  'id' => 11,
		  'project_id' => 1,
		  'physical_planned' => 86,
		  'physical_actual' => 54,
		  'financial_planned' => 214600,
		  'financial_actual' => 101011,
		  'month' => 'May-2017',
		]),
		collect([ 
		  'id' => 12,
		  'project_id' => 1,
		  'physical_planned' => 93,
		  'physical_actual' => 57,
		  'financial_planned' => 256300,
		  'financial_actual' => 146308,
		  'month' => 'Jun-2017',
		]),
		collect([ 
		  'id' => 13,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 57.89,
		  'financial_planned' => 274000,
		  'financial_actual' => 149260,
		  'month' => 'Jul-2017',
		]),
		collect([ 
		  'id' => 14,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 65.99,
		  'financial_planned' => 274000,
		  'financial_actual' => 149260,
		  'month' => 'Aug-2017',
		]),
		collect([ 
		  'id' => 15,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 68.21,
		  'financial_planned' => 274000,
		  'financial_actual' => 162354,
		  'month' => 'Sept-2017',
		]),
		collect([ 
		  'id' => 16,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 69.24,
		  'financial_planned' => 274000,
		  'financial_actual' => 169334,
		  'month' => 'Oct-2017',
		]),
		collect([ 
		  'id' => 17,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 71.24,
		  'financial_planned' => 274000,
		  'financial_actual' => 169334,
		  'month' => 'Nov-2017',
		]),
		collect([ 
		  'id' => 18,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 74.3,
		  'financial_planned' => 274000,
		  'financial_actual' => 175119,
		  'month' => 'Dec-2017',
		]),
		collect([ 
		  'id' => 19,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 80.57,
		  'financial_planned' => 274000,
		  'financial_actual' => 209706,
		  'month' => 'Jan-2018',
		]),
		collect([ 
		  'id' => 20,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 82.22,
		  'financial_planned' => 274000,
		  'financial_actual' => 228841,
		  'month' => 'Feb-2018',
		]),
		collect([ 
		  'id' => 21,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 84.80,
		  'financial_planned' => 274000,
		  'financial_actual' => 216367,
		  'month' => 'Mar-2018',
		]),
		collect([ 
		  'id' => 22,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 86.74,
		  'financial_planned' => 274000,
		  'financial_actual' => 219253,
		  'month' => 'Apr-2018',
		]),
		collect([ 
		  'id' => 23,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 87.05,
		  'financial_planned' => 274000,
		  'financial_actual' => 223878,
		  'month' => 'May-2018',
		]),
		collect([ 
		  'id' => 24,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 87.05,
		  'financial_planned' => 274000,
		  'financial_actual' => 223878,
		  'month' => 'Jun-2018',
		]),
		collect([ 
		  'id' => 25,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 89.22,
		  'financial_planned' => 274000,
		  'financial_actual' => 237911,
		  'month' => 'Jul-2018',
		]),
		collect([ 
		  'id' => 26,
		  'project_id' => 1,
		  'physical_planned' => 100,
		  'physical_actual' => 90.32,
		  'financial_planned' => 274000,
		  'financial_actual' => 237911,
		  'month' => 'Aug-2018',
		])
	])

];