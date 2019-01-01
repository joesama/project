<?php

return [
	'submit' => 'Submit',
	'project' => [
		'profile_id' => 'Project Manager',
		'client_id' => 'Project Client',
		'name' => 'Project Name',
		'contract' => 'Contract No.',
		'value'=> 'Total Contract Value',
		'scope'=> 'Scope of Contract',
		'start' => 'Start Date',
		'end' => 'End Date',
		'gp_propose' => 'GP - Proposed',
		'gp_latest' => 'GP - Latest Calc.',
		'bond' => 'Performance Bond',
		'eot' => 'Extension of Time',
		'partner_id' => 'Project Partner'

	],
	'task' => [
		'profile_id' => "Task's Assignee", 
		'project_id' => "Project Name", 
		'name' => "Task's Name", 
		'start' => "Start Date", 
		'end' => "End Date", 
		'progress' => "Progress", 
		'task_progress' => "% Progress", 
	],
	'issue' => [
		'profile_id' => "Person In Charge", 
		'project_id' => "Project Name", 
		'progress_id' => "Status", 
		'description' => "Issue Description"
	],
	'risk' => [
		'profile_id' => "Person In Charge", 
		'project_id' => "Project Name", 
		'description' => "Risk Description", 
		'severity_id' => "Status", 
	],
	'project_attribute' => [
		'variable' => "Variable", 
		'data' => "Data" 
	],
	'master' => [
		'description' => 'Category Description'
	],
	'master_data' => [
		'master_id' => 'Category',
		'description' => 'Data Description',
	],
	'client' => [
		'name' => 'Client Name',
		'phone' => 'Tel. Number',
		'manager' => 'Manager',
		'contact' => 'Contact Number',
	],
	'project_incident' => [
		'incident_id' => 'Type Of Incident',
		'incident' => 'Time Lost / Summons or Complaint Quantity',
		'last' => 'Date Last Incident',
		'report' => 'Reported By',
		'date' => 'Date Reported'
	],
	'project_hse' => [
		'project_hour' => 'Total Project Hours',
		'acc_lti' => 'Accumulate Lost Time Injury (LTI)',
		'zero_lti' => 'Zero Lost Time Injuries (LTI)',
		'unsafe' => 'Unsafe Act / Unsafe Condition',
		'stop' => 'Stop Work Order (To Date)',
		'summon' => 'Summon by authorities (To Date)',
		'complaint' => 'Complaint by communities (To Date)',
	],
	'project_payment' => [
		'project_id' => 'Project',
		'claim_date' => 'Claim Date',
		'paid_date' => 'Payment Date',
		'claim_report_by' => 'Claim Report By',
		'paid_report_by' => 'Payment Report By',
		'claim_amount' => 'Claim Amount',
		'paid_amount' => 'Payment Amount',
	],
	'financial' => [
		'record' => 'Payment Record',
		'contract' => 'Contract Info',
		'balance' => 'Balance Contract',
		'duration'=> 'Duration',
		'value'=> 'Value',
		'vo' => 'VO',
		'lad' => 'LAD',
		'revise' => 'Revised Sum',
		'claim' => 'Amount Claim',
		'paid' => 'Amount Paid',
		'retention' => 'Retention'
	]
];