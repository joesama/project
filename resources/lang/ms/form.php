<?php

return [
	'submit' => 'Hantar',
	'is' => [
		'required' => 'Maklumat Ini Diperlukan',
		'numeric' => 'Data Dimasukan Perlu Didalam Format Nombor',
		'maxnumber' => 'Data Dimasukan Tidak Boleh Melebihi 99999999999999',
		'choose' => 'Sila Pilih Satu Dari Senarai',
		'multiple' => 'Anda Boleh Memilih Lebih Dari Satu',
	],
	'action' => [
		'assign' => 'Tugasan'
	],
	'project' => [
		'manager_id' => 'Pengurus Projek',
		'approver_id' => 'Laporan Projek Diluluskan',
		'validator_id' => 'Laporan Projek Disahkan Oleh',
		'reviewer_id' => 'Laporan Projek Disemak Oleh',
		'acceptance_id' => 'Laporan Projek Diterima Oleh',
		'client_id' => 'Klien Projek',
		'name' => 'Nama Projek',
		'contract' => 'No. Kontrak',
		'value'=> 'Jumlah Nilai Projek',
		'scope'=> 'Skop Kontrak',
		'start' => 'Tarikh Mula',
		'end' => 'Tarikh Akhir',
		'gp_propose' => 'GP - Cadangan',
		'gp_latest' => 'GP - Kiraan Terkini',
		'bond' => 'Bon Prestasi',
		'eot' => 'Lanjutan Masa',
		'partner_id' => 'Rakan Kongsi Projek',
		'actual_progress' => 'Perkembangan Sebenar',
		'actual_payment' => 'Bayaran Sebenar',
		'planned_progress' => 'Perkembangan Dirancang',
		'planned_payment' => 'Bayaran Dirancang',
		'effective_days' => 'Hari Kuat Kuasa',
		'current_variance' => 'Varian Terkini',
		'duration' => 'Durasi Projek',

	],
	'task' => [
		'profile_id' => "Lantikan Tugasan", 
		'project_id' => "Nama Projek", 
		'name' => "Nama Tugasan", 
		'start' => "Tarikh Mula", 
		'end' => "Tarikh Akhir", 
		'progress' => "Perkembangan", 
		'task_progress' => "% Perkembangan", 
		'actual_progress' => "Perkembangan Sebenar", 
		'planned_progress' => "Perkembangan Dirancang", 
		'effective_days' => "Jangka Masa (Hari)",  
		'group' => "Milestone", 
                'status_id' => "Status"
	],
	'issue' => [
		'profile_id' => "Kakitangan Bertanggungjawab", 
		'project_id' => "Nama Projek", 
		'progress_id' => "Status", 
		'description' => "Keterangan Isu",
		'active' => "Aktif",
		'effective_days' => "Jangka Masa (Hari)", 
	],
	'risk' => [
		'profile_id' => "Kakitangan Bertanggungjawab", 
		'project_id' => "Nama Projek", 
		'description' => "Keterangan Risiko", 
		'severity_id' => "Status", 
	],
	'project_attribute' => [
		'variable' => "Pembolehubah", 
		'data' => "Data" 
	],
	'project_partner' => [
		'partner_id' => "Nama Rakan Kongsi"
	],
	'master' => [
		'description' => 'Keterangan Kategori'
	],
	'master_data' => [
		'master_id' => 'Kategori',
		'description' => 'Keterangan Data',
		'formula' => 'Formula',
	],
	'client' => [
		'name' => 'Klien / Rakan Kongsi',
		'phone' => 'No. Telefon',
		'manager' => 'Pengurus',
		'contact' => 'No. Dihubungi',
	],
	'project_incident' => [
		'incident_id' => 'Jenis Insiden',
		'incident' => 'Kehilangan Masa / Kuantiti Saman atau Aduan',
		'last' => 'Tarikh Terakhir Insiden',
		'report' => 'Dilaporkan Oleh',
		'date' => 'Dilaporkan Pada'
	],
	'project_hse' => [
		'project_hour' => 'Jumlah Masa Projek (Jam)',
		'acc_lti' => 'Jumlah Terkumpul Kehilangan Masa Kecederaan (LTI)',
		'zero_lti' => 'Sifar Kehilangan Masa Kecederaan (LTI)',
		'unsafe' => 'Tindakan / Keadaan Tidak Selamat',
		'stop' => 'Arahan Henti Kerja (Pada)',
		'summon' => 'Saman oleh Pihak Berkuasa (Pada)',
		'complaint' => 'Komplain oleh Komuniti (Pada)',
	],
	'project_payment' => [
		'project_id' => 'Projek',
		'claim_date' => 'Tarikh Tuntutan',
		'paid_date' => 'Tarikh Bayaran',
		'claim_report_by' => 'Laporan Tuntutan Oleh',
		'paid_report_by' => 'Laporan Bayaran Oleh',
		'claim_amount' => 'Amaun Tuntutan',
		'paid_amount' => 'Amaun Bayaran', 
		'group' => "Receiver", 
	],
	'project_vo' => [
		'date' => 'Tarikh VO',
		'amount' => 'Amaun VO',
	],
	'project_retention' => [
		'date' => 'Tarikh Pengekalan',
		'amount' => 'Amaun Pengekalan',
	],
	'project_lad' => [
		'date' => 'Tarikh LAD',
		'amount' => 'Amaun LAD',
	],
	'financial' => [
		'record' => 'Rekod Bayaran',
		'contract' => 'Info Kontrak',
		'balance' => 'Baki Kontrak',
		'duration'=> 'Tempoh',
		'value'=> 'Nilai',
		'vo' => 'VO',
		'lad' => 'LAD',
		'revise' => 'Jumlah Yang Disemak',
		'claim' => 'Amaun Tuntutan',
		'paid' => 'Amaun Dibayar',
		'retention' => 'Pengekalan'
	],
	'profile' => [
		'name' => 'Nama',
		'abbr' => 'ABBR',
		'email' => 'Emel',
		'phone' => 'No. Telefon',
		'project_id' => 'Projek',
		'corporate_id' => 'Nama Syarikat',
		'position_id' => 'Jawatan',
		'user_id' => 'ID Pengguna',
		'role_id' => 'Peranan Projek',
	],
	'report' => [
		'report_date' => 'Tarikh Laporan'
	],
	'project_milestone_physical' => [
		'label' => 'Milestone Label',
		'group' => 'Milestone Group'
	],
	'project_milestone_finance' => [
		'label' => 'Milestone Label',
		'group' => 'Milestone Group'
	],
	'process_flow' =>[
		'label' => 'Nama',
		'description' => 'Keterangan',
	],
	'process_step' =>[
		'label' => 'Nama',
		'role_id' => 'Peranan',
		'status_id' => 'Status',
		'order' => 'Step Order',
		'description' => 'Keterangan',
		'cross_organisation' => 'Cross Organisation',
	]
];