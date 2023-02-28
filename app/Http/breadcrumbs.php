<?php

use Illuminate\Support\Facades\Request;

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    //$breadcrumbs->parent('/');
    $breadcrumbs->push(Lang::get('lang.dashboard'), route('dashboard'));
});

Breadcrumbs::register('notification.list', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('All Notifications', route('notification.list'));
});

Breadcrumbs::register('notification.settings', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Notifications Settings', route('notification.settings'));
});

Breadcrumbs::register('groups.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.groups'), route('groups.index'));
});
Breadcrumbs::register('groups.create', function ($breadcrumbs) {
    $breadcrumbs->parent('groups.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('groups.create'));
});
Breadcrumbs::register('groups.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('groups.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('groups/{groups}/edit'));
});

Breadcrumbs::register('departments.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.departments'), route('departments.index'));
});
Breadcrumbs::register('departments.create', function ($breadcrumbs) {
    $breadcrumbs->parent('departments.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('departments.create'));
});
Breadcrumbs::register('departments.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('departments.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('departments/{departments}/edit'));
});

Breadcrumbs::register('teams.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.teams'), route('teams.index'));
});
Breadcrumbs::register('teams.create', function ($breadcrumbs) {
    $breadcrumbs->parent('teams.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('teams.create'));
});
Breadcrumbs::register('teams.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('teams.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('teams/{teams}/edit'));
});

Breadcrumbs::register('agents.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.agents'), route('agents.index'));
});
Breadcrumbs::register('agents.create', function ($breadcrumbs) {
    $breadcrumbs->parent('agents.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('agents.create'));
});
Breadcrumbs::register('agents.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('agents.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('agents/{agents}/edit'));
});

Breadcrumbs::register('emails.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.emails'), route('emails.index'));
});
Breadcrumbs::register('emails.create', function ($breadcrumbs) {
    $breadcrumbs->parent('emails.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('emails.create'));
});
Breadcrumbs::register('emails.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('emails.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('emails/{emails}/edit'));
});

Breadcrumbs::register('banlist.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.ban_lists'), route('banlist.index'));
});
Breadcrumbs::register('banlist.create', function ($breadcrumbs) {
    $breadcrumbs->parent('banlist.index');
    $breadcrumbs->push(Lang::get('lang.add'), route('banlist.create'));
});
Breadcrumbs::register('banlist.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('banlist.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('agents/{agents}/edit'));
});

Breadcrumbs::register('template-sets.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('All Template sets', route('template-sets.index'));
});
Breadcrumbs::register('show.templates', function ($breadcrumbs) {
    $page = App\Model\Common\Template::whereId(1)->first();
    $breadcrumbs->parent('template-sets.index');
    $breadcrumbs->push('All Templates', route('show.templates', $page->id));
});
Breadcrumbs::register('templates.edit', function ($breadcrumbs) {
    $page = App\Model\Common\Template::whereId(1)->first();
    $breadcrumbs->parent('show.templates');
    $breadcrumbs->push('Edit Template', route('templates.edit', $page->id));
});

Breadcrumbs::register('getdiagno', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.email_diagnostic'), route('getdiagno'));
});

Breadcrumbs::register('helptopic.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.help_topics'), route('helptopic.index'));
});
Breadcrumbs::register('helptopic.create', function ($breadcrumbs) {
    $breadcrumbs->parent('helptopic.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('helptopic.create'));
});
Breadcrumbs::register('helptopic.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('helptopic.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('helptopic/{helptopic}/edit'));
});

Breadcrumbs::register('sla.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.sla-plans'), route('sla.index'));
});
Breadcrumbs::register('sla.create', function ($breadcrumbs) {
    $breadcrumbs->parent('sla.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('sla.create'));
});
Breadcrumbs::register('sla.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('sla.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('sla/{sla}/edit'));
});

Breadcrumbs::register('forms.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.forms'), route('forms.index'));
});
Breadcrumbs::register('forms.create', function ($breadcrumbs) {
    $breadcrumbs->parent('forms.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('forms.create'));
});
Breadcrumbs::register('forms.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('forms.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('forms/{forms}/edit'));
});
Breadcrumbs::register('forms.show', function ($breadcrumbs) {
    $breadcrumbs->parent('forms.index');
    $breadcrumbs->push(Lang::get('lang.view'), url('forms/{forms}'));
});
Breadcrumbs::register('forms.add.child', function ($breadcrumbs) {
    $breadcrumbs->parent('forms.index');
    $breadcrumbs->push('Add Child', url('forms/add-child/{forms}'));
});

Breadcrumbs::register('get.job.scheder', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.cron-jobs'), route('get.job.scheder'));
});

Breadcrumbs::register('getcompany', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.company_settings'), route('getcompany'));
});
Breadcrumbs::register('getsystem', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.system-settings'), route('getsystem'));
});
Breadcrumbs::register('getticket', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.ticket-setting'), route('getticket'));
});
Breadcrumbs::register('getemail', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.email-settings'), route('getemail'));
});
Breadcrumbs::register('getresponder', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.auto_responce'), route('getresponder'));
});

Breadcrumbs::register('getalert', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.alert_notices_setitngs'), route('getalert'));
});
Breadcrumbs::register('security.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.security_settings'), route('security.index'));
});
// Templates > Upload Templates
Breadcrumbs::register('security.create', function ($breadcrumbs) {
    $breadcrumbs->parent('security.index');
    $breadcrumbs->push('Upload security', route('security.create'));
});
// Templates > [Templates Name]
Breadcrumbs::register('security.show', function ($breadcrumbs, $photo) {
    $breadcrumbs->parent('security.index');
    $breadcrumbs->push($photo->title, route('security.show', $photo->id));
});
// Templates > [Templates Name] > Edit Templates
Breadcrumbs::register('security.edit', function ($breadcrumbs, $photo) {
    $breadcrumbs->parent('security.show', $photo);
    $breadcrumbs->push('Edit security', route('security.edit', $photo->id));
});

Breadcrumbs::register('close-workflow.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.close_ticket_workflow_settings'), route('close-workflow.index'));
});

Breadcrumbs::register('statuss.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.status_settings'), route('statuss.index'));
});

Breadcrumbs::register('statuss.create', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Create Status', route('statuss.create'));
});

Breadcrumbs::register('status.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Edit Status', url('status/edit/{id}'));
});

Breadcrumbs::register('ratings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.ratings_settings'), route('ratings.index'));
});

Breadcrumbs::register('rating.create', function ($breadcrumbs) {
    $breadcrumbs->parent('ratings.index');
    $breadcrumbs->push('Create Ratings', route('rating.create'));
});

Breadcrumbs::register('rating.edit', function ($breadcrumbs) {
    $page = App\Model\helpdesk\Ratings\Rating::whereId(1)->first();
    $breadcrumbs->parent('ratings.index');
    $breadcrumbs->push('Edit Ratings');
});

Breadcrumbs::register('admin-profile', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.profile'), route('admin-profile'));
});

Breadcrumbs::register('widgets', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.widget-settings'), route('widgets'));
});

Breadcrumbs::register('social.buttons', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.social-widget-settings'), route('social.buttons'));
});

Breadcrumbs::register('setting', function ($breadcrumbs) {
    $breadcrumbs->push(Lang::get('lang.admin_panel'), route('setting'));
});

Breadcrumbs::register('plugins', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.plugins'), route('plugins'));
});

Breadcrumbs::register('LanguageController', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.language-settings'), route('LanguageController'));
});

Breadcrumbs::register('add-language', function ($breadcrumbs) {
    $breadcrumbs->parent('LanguageController');
    $breadcrumbs->push(Lang::get('lang.add'), route('add-language'));
});
Breadcrumbs::register('workflow', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.ticket_workflow'), route('workflow'));
});
Breadcrumbs::register('workflow.create', function ($breadcrumbs) {
    $breadcrumbs->parent('workflow');
    $breadcrumbs->push(Lang::get('lang.create'), route('workflow.create'));
});

Breadcrumbs::register('workflow.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('workflow');
    $breadcrumbs->push(Lang::get('lang.edit'), url('workflow/edit/{id}'));
});
Breadcrumbs::register('api.settings.get', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.api_settings'), route('api.settings.get'));
});

Breadcrumbs::register('err.debug.settings', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.error-debug-settings'), route('err.debug.settings'));
});

Breadcrumbs::register('closed.approvel.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.approvel_ticket_list'), route('closed.approvel.ticket'));
});
Breadcrumbs::register('user.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.user_directory'), route('user.index'));
});
Breadcrumbs::register('user.create', function ($breadcrumbs) {
    $breadcrumbs->parent('user.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('user.create'));
});
Breadcrumbs::register('user.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('user.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('user/{user}/edit'));
});
Breadcrumbs::register('user.show', function ($breadcrumbs) {
    $breadcrumbs->parent('user.index');
    $breadcrumbs->push(Lang::get('lang.view-profile'), url('user/{user}'));
});

Breadcrumbs::register('user.export', function ($breadcrumbs) {
    $breadcrumbs->parent('user.index');
    $breadcrumbs->push('Export', url('user-export'));
});

Breadcrumbs::register('organizations.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.organizations'), route('organizations.index'));
});
Breadcrumbs::register('organizations.create', function ($breadcrumbs) {
    $breadcrumbs->parent('organizations.index');
    $breadcrumbs->push(Lang::get('lang.create'), route('organizations.create'));
});
Breadcrumbs::register('organizations.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('organizations.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('organizations/{organizations}/edit'));
});
Breadcrumbs::register('organizations.show', function ($breadcrumbs) {
    $breadcrumbs->parent('organizations.index');
    $breadcrumbs->push(Lang::get('lang.view_organization_profile'), url('organizations/{organizations}'));
});
Breadcrumbs::register('canned.list', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.canned_response'), route('canned.list'));
});
Breadcrumbs::register('canned.create', function ($breadcrumbs) {
    $breadcrumbs->parent('canned.list');
    $breadcrumbs->push(Lang::get('lang.create'), route('canned.create'));
});

Breadcrumbs::register('canned.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('canned.list');
    $breadcrumbs->push(Lang::get('lang.edit'), url('canned/edit/{id}'));
});

Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.my_profile'), route('profile'));
});
Breadcrumbs::register('agent-profile-edit', function ($breadcrumbs) {
    $breadcrumbs->parent('profile');
    $breadcrumbs->push(Lang::get('lang.edit'), url('profile-edit'));
});
Breadcrumbs::register('inbox.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.inbox'), route('inbox.ticket'));
});
Breadcrumbs::register('open.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.open'), route('open.ticket'));
});
Breadcrumbs::register('answered.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.answered'), route('answered.ticket'));
});
Breadcrumbs::register('myticket.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.my_tickets'), route('myticket.ticket'));
});
Breadcrumbs::register('overdue.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.overdue'), route('overdue.ticket'));
});
Breadcrumbs::register('closed.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.closed'), route('closed.ticket'));
});
Breadcrumbs::register('assigned.ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.assigned'), route('assigned.ticket'));
});
Breadcrumbs::register('newticket', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');

    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.create'), route('newticket'));
});
Breadcrumbs::register('ticket.thread', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('dashboard');
    $ticket_number = App\Model\helpdesk\Ticket\Tickets::where('id', '=', $id)->first();
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.$ticket_number->ticket_number, url('/thread/{id}'));
});
Breadcrumbs::register('get-trash', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.trash'), route('get-trash'));
});
Breadcrumbs::register('unassigned', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.tickets').'&nbsp; > &nbsp;'.Lang::get('lang.unassigned'), route('unassigned'));
});

Breadcrumbs::register('dept.open.ticket', function ($breadcrumbs, $dept) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.department').'&nbsp; > &nbsp;'.$dept.'&nbsp; > &nbsp;'.Lang::get('lang.open_tickets'), url('/{dept}/open'));
});
Breadcrumbs::register('dept.closed.ticket', function ($breadcrumbs, $dept) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.department').'&nbsp; > &nbsp;'.$dept.'&nbsp; > &nbsp;'.Lang::get('lang.closed_tickets'), url('/{dept}/closed'));
});
Breadcrumbs::register('report.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.dashboard'), route('dashboard'));
});
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(Lang::get('lang.home'), route('home'));
});
Breadcrumbs::register('/', function ($breadcrumbs) {
    $breadcrumbs->push(Lang::get('lang.home'), route('/'));
});
Breadcrumbs::register('form', function ($breadcrumbs) {
    $breadcrumbs->push('Create Ticket', route('form'));
});
Breadcrumbs::register('check_ticket', function ($breadcrumbs, $id) {
    $page = \App\Model\helpdesk\Ticket\Tickets::whereId(1)->first();
    $breadcrumbs->parent('ticket2');
    $breadcrumbs->push('Check Ticket');
});
Breadcrumbs::register('show.ticket', function ($breadcrumbs) {
    $breadcrumbs->push('Ticket', route('form'));
});
Breadcrumbs::register('client.profile', function ($breadcrumbs) {
    $breadcrumbs->push('My Profile');
});
Breadcrumbs::register('ticket2', function ($breadcrumbs) {
    $breadcrumbs->push('My Tickets', route('ticket2'));
});

Breadcrumbs::register('client-verify-number', function ($breadcrumbs) {
    $breadcrumbs->push('Profile', route('client-verify-number'));
});
Breadcrumbs::register('post-client-verify-number', function ($breadcrumbs) {
    $breadcrumbs->push('My Profile', route('post-client-verify-number'));
});
Breadcrumbs::register('error500', function ($breadcrumbs) {
    $breadcrumbs->push('500');
});
Breadcrumbs::register('error404', function ($breadcrumbs) {
    $breadcrumbs->push('404');
});
Breadcrumbs::register('errordb', function ($breadcrumbs) {
    $breadcrumbs->push('Error establishing connection to database');
});
Breadcrumbs::register('unauth', function ($breadcrumbs) {
    $breadcrumbs->push('Unauthorized Access');
});
Breadcrumbs::register('board.offline', function ($breadcrumbs) {
    $breadcrumbs->push('Board Offline');
});
Breadcrumbs::register('category.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.category'), route('category.index'));
});
Breadcrumbs::register('category.create', function ($breadcrumbs) {
    $breadcrumbs->parent('category.index');
    $breadcrumbs->push(Lang::get('lang.add'), route('category.create'));
});
Breadcrumbs::register('category.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('category.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('category/{category}/edit'));
});
Breadcrumbs::register('category.show', function ($breadcrumbs) {
    $breadcrumbs->parent('category.index');
    $breadcrumbs->push(Lang::get('lang.view'), url('category/{category}'));
});

Breadcrumbs::register('article.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.article'), route('article.index'));
});
Breadcrumbs::register('article.create', function ($breadcrumbs) {
    $breadcrumbs->parent('article.index');
    $breadcrumbs->push(Lang::get('lang.add'), route('article.create'));
});
Breadcrumbs::register('article.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('article.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('article/{article}/edit'));
});
Breadcrumbs::register('article.show', function ($breadcrumbs) {
    $breadcrumbs->parent('article.index');
    $breadcrumbs->push(Lang::get('lang.view'), url('article/{article}'));
});

Breadcrumbs::register('settings', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.settings'), route('settings'));
});
Breadcrumbs::register('comment', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.comments'), route('comment'));
});
Breadcrumbs::register('page.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.pages'), route('page.index'));
});
Breadcrumbs::register('page.create', function ($breadcrumbs) {
    $breadcrumbs->parent('page.index');
    $breadcrumbs->push(Lang::get('lang.add'), route('page.create'));
});
Breadcrumbs::register('page.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('page.index');
    $breadcrumbs->push(Lang::get('lang.edit'), url('page/{page}/edit'));
});
Breadcrumbs::register('page.show', function ($breadcrumbs) {
    $breadcrumbs->parent('page.index');
    $breadcrumbs->push(Lang::get('lang.view'), url('page/{page}'));
});
Breadcrumbs::register('article-list', function ($breadcrumbs) {
    $breadcrumbs->push('Article List', route('article-list'));
});

Breadcrumbs::register('search', function ($breadcrumbs) {
    $breadcrumbs->push('Knowledge-base', route('home'));
    $breadcrumbs->push('Search Result');
});

Breadcrumbs::register('show', function ($breadcrumbs) {
    $breadcrumbs->push('Knowledge-base', route('home'));
    $breadcrumbs->push('Article List', route('article-list'));
    $breadcrumbs->push('Article');
});
Breadcrumbs::register('category-list', function ($breadcrumbs) {
    $breadcrumbs->push('Category List', route('category-list'));
});
Breadcrumbs::register('categorylist', function ($breadcrumbs) {
    $breadcrumbs->push('Category List', route('category-list'));
    $breadcrumbs->push('Category');
});
Breadcrumbs::register('contact', function ($breadcrumbs) {
    $breadcrumbs->parent('/');
    $breadcrumbs->push(Lang::get('lang.contact'), route('contact'));
});
Breadcrumbs::register('pages', function ($breadcrumbs) {
    $breadcrumbs->push('Pages');
});
Breadcrumbs::register('queue', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.queues'), route('queue'));
});
Breadcrumbs::register('queue.edit', function ($breadcrumbs) {
    $id = Request::segment(2);
    $breadcrumbs->parent('queue');
    $breadcrumbs->push(Lang::get('lang.edit'), route('queue.edit', $id));
});

Breadcrumbs::register('url.settings', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.url'), route('url.settings'));
});

Breadcrumbs::register('social', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.social-media'), route('social'));
});
Breadcrumbs::register('social.media', function ($breadcrumbs) {
    $id = Request::segment(2);
    $breadcrumbs->parent('social');
    $breadcrumbs->push(Lang::get('lang.settings'), route('social.media', $id));
});
Breadcrumbs::register('priority.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('Ticket Priority'), route('priority.index'));
});
Breadcrumbs::register('priority.create', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('Ticket Priority'), route('priority.index'));
    $breadcrumbs->push(Lang::get('lang.create'), route('priority.create'));
});
Breadcrumbs::register('priority.edit', function ($breadcrumbs) {
    $breadcrumbs->push(Lang::get('Ticket Priority'), route('priority.index'));
    $breadcrumbs->push(Lang::get('Edit'), route('priority.index'));
});

Breadcrumbs::register('dept.inprogress.ticket', function ($breadcrumbs, $dept) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('lang.department').'&nbsp; > &nbsp;'.$dept.'&nbsp; > &nbsp;'.Lang::get('lang.assigned_tickets'), url('/{dept}/inprogress'));
});

Breadcrumbs::register('labels.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push(Lang::get('lang.label'), 'labels.index');
});

Breadcrumbs::register('labels.create', function ($breadcrumbs) {
    $breadcrumbs->parent('labels.index');
    $breadcrumbs->push(Lang::get('lang.create'), 'labels.create');
});

Breadcrumbs::register('labels.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('labels.index');
    $breadcrumbs->push(Lang::get('lang.edit'), 'labels.edit');
});

Breadcrumbs::register('readmails', function ($breadcrumbs) {
    $breadcrumbs->push('readmails', 'readmails');
});
