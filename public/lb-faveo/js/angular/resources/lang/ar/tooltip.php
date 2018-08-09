<?php

return [
    //Admin Panel tooltips

    /*----------STAFF>AGENTS----------------*/
    'agent-status'             => 'llllllllllll', //Agent account\'s status will enable/disable the agent to login into the system.',
    'agent-role'               => 'llllllllllll', //Choose the Role you would like to assign to this agent. Admin can configure all settings through Admin Panel. Agent can only create, view, reply, update and resolve tickets of their department.',
    'agent-department'         => 'llllllllllll', //Choose the Department to which this Agent belongs.',
    'agent-team'               => 'llllllllllll', //Choose the Team to which this Agent belongs.',
    'agent-Access Permissions' => 'llllllllllll', //Choose the Access Permissions for this Agent.',
    'agent-password'           => 'llllllllllll', //Check this option if you want to send password to agent through email.',

    /*----------STAFF>Department---------------*/
    'department-type'            => 'llllllllllll', //Select Department as Private if you do not want it to be available in the Client Portal.',
    'department-manager'         => 'llllllllllll', //Select a manager for this Department.',
    'department-outgoin-mail'    => 'llllllllllll', //This Email Address is used for sending responses to the Users from Agents when agent replies to Tickets.',
    'default-department'         => 'llllllllllll', //Assign a Default Department if there is a common/default department.',

    /*-----------STAFF>TEAMS-----------------*/
    'team-status'      => 'llllllllllll', //Enable this Team status so that it will be available for ticket assignments and to receive Alerts & Notices.',
    'team-lead'        => 'llllllllllll', //Select a team Lead for this team who can receive Alerts & Notices separate from the members.',
    'team-admin-notes' => 'llllllllllll', //Add notes about team information that you would like to share with other admins',

    /*----------STAFF>PERMISSION-------------*/
    'permission-status'    => 'llllllllllll', //Enable the status of this Access Permission to be available for assignment to an Agent.',
];
