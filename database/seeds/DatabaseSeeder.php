<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Access;
use App\Agents;
use App\Company;
use App\Department;
use App\Emails;
use App\Help_topic;
use App\Sla_plan;
use App\Teams;
use App\Groups;
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Access::create(array('password_expire' => '1 Months' , 'reg_method' => 'disable'));
		Access::create(array('password_expire' => '2 Months' , 'reg_method' => 'private'));
		Access::create(array('password_expire' => '6 Months' , 'reg_method' => 'public'));
		Access::create(array('password_expire' => '10 Months' , 'reg_method' => ''));
		Access::create(array('password_expire' => '12 Months' , 'reg_method' => ''));

		Agents::create(array('user_name' => 'user 1','assign_group' => 'group A' , 'primary_dpt' => 'support' , 'assign_team' => 'developer'));
		Agents::create(array('user_name' => 'user 2','assign_group' => 'group B' , 'primary_dpt' => 'sale' , 'assign_team' => 'level 1 support'));
		Agents::create(array('user_name' => 'user 3','assign_group' => 'group C' , 'primary_dpt' => 'maintanance' , 'assign_team' => 'level 2 support'));

		Department::create(array('name' => 'opration'));
		Department::create(array('name' => 'sale'));
		Department::create(array('name' => 'support'));

		Company::create(array('company_name' => 'D company' , 'website' => 'dcompany.org', 'phone' => '8606574126'));

		Emails::create(array('email_address' => 'maintanance@dcompany.com', 'email_name' => 'maintain', 'department' => 'maintanance', 'priority' => 'low', 'help_topic' => 'maintanance query', 'user_name' => 'maintanance'));
		Emails::create(array('email_address' => 'support@dcompany.com', 'email_name' => 'support', 'department' => 'support', 'priority' => 'low', 'help_topic' => 'support query', 'user_name' => 'support'));
		Emails::create(array('email_address' => 'sale@dcompany.com', 'email_name' => 'sale', 'department' => 'sales', 'priority' => 'low', 'help_topic' => 'sales query', 'user_name' => 'sale'));

		Groups::create(array('name' => 'group A'));
		Groups::create(array('name' => 'group B'));
		Groups::create(array('name' => 'group C'));

		help_topic::create(array('topic' => 'support query', 'department' => 'support', 'priority' =>'low', 'sla_plan' => '12 hours'));
		help_topic::create(array('topic' => 'sale query', 'department' => 'sale', 'priority' =>'high', 'sla_plan' => '6 hours'));

		Sla_plan::create(array('name' => 'sla 1', 'grace_period' => '12 Hours'));
		Sla_plan::create(array('name' => 'sla 2', 'grace_period' => '6 Hours'));

		Teams::create(array('name' => 'developer', 'team_lead' => 'Code Name 47'));
		Teams::create(array('name' => 'Level 1 Support', 'team_lead' => 'Code Name 007'));
		Teams::create(array('name' => 'Level 2 Support', 'team_lead' => 'Code Name'));

	}
}
