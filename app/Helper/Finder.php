<?php

namespace App\Helper;

use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Groups;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\TicketStatusType;

/**
 *------------------------------------------------------------------
 *  Class Finder
 *------------------------------------------------------------------
 *  Description: This class is used for defining some common functions
 *  used in the project.
 *
 *  @author <Ladybird Web Solution>
 */
class Finder
{
    /**
     * DEPARTMENT
     * This function is used for returning department name with respect to id.
     *
     * @param $id type int
     * @param $custom type array/null
     *
     * @return type string
     */
    public static function department($id, $custom = null)
    {
        if ($custom == null) {
            $department = Department::whereId($id)->select(['name']);
        } elseif (isset($custom)) {
            $department = Department::whereId($id)->select($custom);
        }

        return $department->first()->name;
    }

    /**
     * GROUP
     * This function is used for returning group name with respect to id.
     *
     * @param $id type int
     * @param $custom type array/null
     *
     * @return type string
     */
    public static function group($id, $custom = null)
    {
        if ($custom == null) {
            $group = Groups::whereId($id)->select(['name']);
        } elseif (isset($custom)) {
            $group = Groups::whereId($id)->select($custom);
        }

        return $group->first()->name;
    }

    /**
     * STATUS TYPE
     * This function is used for returning status type name with respect to id.
     *
     * @param $id type int
     * @param $custom type array/null
     *
     * @return type string
     */
    public static function statusType($id, $custom = null)
    {
        if ($custom == null) {
            $status_type = TicketStatusType::whereId($id)->select(['name']);
        } elseif (isset($custom)) {
            $status_type = TicketStatusType::whereId($id)->select($custom);
        }

        return $status_type->first()->name;
    }

    /**
     * STATUS
     * This function is used for returning status name with respect to id.
     *
     * @param $id type int
     * @param $custom type array/null
     *
     * @return type string
     */
    public static function status($id, $custom = null)
    {
        if ($custom == null) {
            $status = Ticket_Status::whereId($id)->first();
        } elseif (isset($custom)) {
            $status = Ticket_Status::whereId($id)->select($custom);
        }

        return $status;
    }

    /**
     * USER ROLES IN A GROUP FOR STATUS LIST
     * This function is used to return roles of users from a given value.
     * If the value is 1 the response is client
     * If the value is 2 the response is agent
     * If the value is 4 the response is admin
     * If the value is 1+2 = 3 the response is client, agent
     * If the value is 1+4 = 5 the response is client, admin
     * If the value is 2+4 = 6 the response is agent, admin
     * If the value is 1+2+4 = 7 the response is client, agent, admin.
     *
     * @param $id type int
     *
     * @return type string
     */
    public static function rolesGroup($id)
    {
        switch ($id) {
            case null:
                return \Lang::get('lang.none');
            case 1:
                return 'Client';
            case 2:
                return 'Agent';
            case 4:
                return 'Admin';
            case 3:
                return 'Client,Agent';
            case 5:
                return 'Client,Admin';
            case 6:
                return 'Agent,Admin';
            case 7:
                return 'Client,Agent,Admin';
            default:
                return 'Undefined!';
        }
    }

    /**
     * ANY TYPE STATUS
     * This function is used to return the set of status which are of any type passed in the param.
     *
     * @param type $id
     *
     * @return type array
     */
    public static function anyTypeStatus($id)
    {
        $status_group = Ticket_Status::where('purpose_of_status', '=', $id)->select(['id'])->get();
        foreach ($status_group as $status) {
            $status_group2[] = $status->id;
        }

        return $status_group2;
    }

    /**
     * RETURNS ALL STATUS
     * This function is used to return all the status given in the system.
     *
     * @return type array
     */
    public static function getAllStatus()
    {
        $status = Ticket_Status::where('purpose_of_status', '!=', 3)->orwhere('purpose_of_status', '!=', 4)->get();

        return $status;
    }

    /**
     * VARIABLE REPLACEMENT
     * This function is used to replace the replaceable variables form a given content for templates.
     */
    public static function replaceTemplateVariables($variables, $data, $contents)
    {
        foreach ($variables as $key => $variable) {
            $messagebody = str_replace($variables[$key], $data[$key], $contents);
            $contents = $messagebody;
        }

        return $contents;
    }

    /**
     * SPECIAL CHECK FOR STATUS FOR APPROVAL
     * This function is used to special check status for any type of checks.
     *
     * @return type array
     */
    public static function getCustomedStatus()
    {
        $status = Ticket_Status::select('id', 'name', 'icon_class')
                ->whereIn('id', [1, 2, 3, 5])->get();

        return $status;
    }
}
