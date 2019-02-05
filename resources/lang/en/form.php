<?php

return [
	'submit' => 'Submit',
	'is' => [
		'required' => 'Information Is Required',
		'numeric' => 'Input Data Should Be Numeric',
		'maxnumber' => 'Input Data Should Not Exceed 99999999999999',
		'choose' => 'Please Choose One From The List',
		'multiple' => 'You Can Choose More Than One',
	],
	'action' => [
		'assign' => 'Assignation',
		'approve' => 'Approve',
		'reject' => 'Reject',
	],
	'project' => [
		'manager_id' => 'Project Manager',
		'approver_id' => 'Project Report Approver',
		'validator_id' => 'Project Report Validator',
		'reviewer_id' => 'Project Report Reviewer',
		'acceptance_id' => 'Project Report Acceptance',
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
		'partner_id' => 'Project Partner',
		'actual_progress' => 'Actual Progress',
		'actual_payment' => 'Actual Payment',
		'planned_progress' => 'Planned Progress',
		'planned_payment' => 'Planned Payment',
		'effective_days' => 'Effective Days',
		'current_variance' => 'Current Variance',
		'duration' => 'Project Duration',
		'job_code' => 'Project Job Code',

	],
	'task' => [
		'profile_id' => "Person In Charge", 
		'project_id' => "Project Name", 
		'name' => "Task's Name", 
		'start' => "Start Date", 
		'end' => "End Date", 
		'duration' => "Duration", 
		'progress' => "Progress", 
		'task_progress' => "% Progress", 
		'actual_progress' => "Actual Progress", 
		'planned_progress' => "Weightage", 
		'effective_days' => "Duration In Days", 
		'group' => "Milestone", 
	],
	'issue' => [
		'profile_id' => "Person In Charge", 
		'project_id' => "Project Name", 
		'progress_id' => "Status", 
		'description' => "Issue Description",
		'active' => "Active",
		'effective_days' => "Duration In Days", 
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
	'project_partner' => [
		'partner_id' => "Partner Name"
	],
	'master' => [
		'description' => 'Category Description'
	],
	'master_data' => [
		'master_id' => 'Category',
		'description' => 'Data Description',
		'formula' => 'Formula',
	],
	'client' => [
		'name' => 'Client / Partner Name',
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
		'claim_date' => 'Schedule Date',
		'paid_date' => 'Invoice Date',
		'paid_on' => 'Paid Date',
		'claim_report_by' => 'Schedule  By',
		'paid_report_by' => 'Invoice By',
		'claim_amount' => 'Schedule Amount',
		'paid_amount' => 'Invoice Amount', 
		'group' => "Milestone", 
		'reference' => 'Payment Reference',
	],
	'project_vo' => [
		'date' => 'Date VO',
		'amount' => 'Amount VO',
	],
	'project_retention' => [
		'date' => 'Date Retention',
		'amount' => 'Amount Retention',
	],
	'project_lad' => [
		'date' => 'Date LAD',
		'amount' => 'Amount LAD',
	],
	'financial' => [
		'record' => 'Payment Schedule',
		'reference' => 'Payment Reference',
		'contract' => 'Contract Info',
		'balance' => 'Balance Contract',
		'duration'=> 'Duration',
		'value'=> 'Value',
		'vo' => 'VO',
		'lad' => 'LAD',
		'revise' => 'Revised Sum',
		'claim' => 'Scheduled Amount',
		'paid' => 'Invoiced Amount',
		'retention' => 'Retention'
	],
	'profile' => [
		'name' => 'Name',
		'abbr' => 'ABBR',
		'email' => 'Email',
		'phone' => 'Contact No.',
		'project_id' => 'Project',
		'corporate_id' => 'Company Name',
		'position_id' => 'Position',
		'user_id' => 'User Id',
		'role_id' => 'Project Role',
	],
	'report' => [
		'report_date' => 'Report Date',
		'submit_date' => 'Submit Date',
		'aging' => 'Aging (In Days)',
	],
	'project_milestone_physical' => [
		'label' => 'Milestone Label',
		'weightage' => 'Progress Weightage (%)',
		'group' => 'Milestone Group'
	],
	'project_milestone_finance' => [
		'label' => 'Milestone Label',
		'weightage' => 'Payment Weightage (RM)',
		'group' => 'Milestone Group'
	]
];