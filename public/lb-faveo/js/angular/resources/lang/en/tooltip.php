<?php

return [
    //Admin Panel tooltips

    /*----------STAFF>AGENTS----------------*/
    'agent-status'             => 'Agent account\'s status will enable/disable the agent to login into the system.',
    'agent-role'               => 'Choose the Role you would like to assign to this agent. Admin can configure all settings through Admin Panel. Agent can only create, view, reply, update and resolve tickets of their department.',
    'agent-department'         => 'Choose the Department to which this Agent belongs.',
    'agent-team'               => 'Choose the Team to which this Agent belongs.',
    'agent-Access Permissions' => 'Choose the Access Permissions for this Agent.',
    'agent-password'           => 'Check this option if you want to send password to agent through email.',

    /*----------STAFF>Department---------------*/
    'department-type'            => 'Select Department as Private if you do not want it to be available in the Client Portal.',
    'department-manager'         => 'Select a manager for this Department.',
    'department-outgoin-mail'    => 'This Email Address is used for sending responses to the Users from Agents when agent replies to Tickets.',
    'default-department'         => 'Assign a Default Department if there is a common/default department.',

    /*-----------STAFF>TEAMS-----------------*/
    'team-status'      => 'Enable this Team status so that it will be available for ticket assignments and to receive Alerts & Notices.',
    'team-lead'        => 'Select a team Lead for this team who can receive Alerts & Notices separate from the members.',
    'team-admin-notes' => 'Add notes about team information that you would like to share with other admins',

    /*----------STAFF>PERMISSION-------------*/
    'permission-status'    => 'Enable the status of this Access Permission to be available for assignment to an Agent.',
];
