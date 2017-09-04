<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;

class Tickets extends BaseModel
{
    protected $table = 'tickets';
    protected $fillable = ['id', 'ticket_number', 'num_sequence', 'user_id', 'priority_id', 'sla', 'help_topic_id', 'max_open_ticket', 'captcha', 'status', 'lock_by', 'lock_at', 'source', 'isoverdue', 'reopened', 'isanswered', 'is_deleted', 'closed', 'is_transfer', 'transfer_at', 'reopened_at', 'closed_at', 'last_message_at', 'last_response_at', 'created_at', 'updated_at', 'assigned_to'];
    protected $dates = ['duedate'];

//        public function attach(){
//            return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_attachments',);
//
//        }
    public function thread()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Thread', 'ticket_id');
    }

    public function collaborator()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Collaborator', 'ticket_id');
    }

    public function helptopic()
    {
        $related = 'App\Model\helpdesk\Manage\Help_topic';
        $foreignKey = 'help_topic_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function formdata()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Form_Data', 'ticket_id');
    }

    public function extraFields()
    {
        $id = $this->attributes['id'];
        $ticket_form_datas = \App\Model\helpdesk\Ticket\Ticket_Form_Data::where('ticket_id', '=', $id)->get();

        return $ticket_form_datas;
    }

    public function sources()
    {
        return $this->belongsTo('App\Model\helpdesk\Ticket\Ticket_source', 'source');
    }

    public function source()
    {
        $source_id = $this->attributes['source'];
        $sources = new Ticket_source();
        $source = $sources->find($source_id);

        return $source;
    }

    public function sourceCss()
    {
        $css = 'fa fa-comment';
        $source = $this->source();
        if ($source) {
            $css = $source->css_class;
        }

        return $css;
    }

    public function delete()
    {
        $this->thread()->delete();
        $this->collaborator()->delete();
        $this->formdata()->delete();
        parent::delete();
    }

    public function setAssignedToAttribute($value)
    {
        if (!$value) {
            $this->attributes['assigned_to'] = null;
        } else {
            $this->attributes['assigned_to'] = $value;
        }
    }

    public function getAssignedTo()
    {
        $agentid = $this->attributes['assigned_to'];
        if ($agentid) {
            $users = new \App\User();
            $user = $users->where('id', $agentid)->first();
            if ($user) {
                return $user;
            }
        }
    }

    public function user()
    {
        $related = "App\User";
        $foreignKey = 'user_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function assigned()
    {
        $related = 'App\User';
        $foreignKey = 'assigned_to';

        return $this->belongsTo($related, $foreignKey);
    }

    public function departments()
    {
        $related = 'App\Model\helpdesk\Agent\Department';
        $foreignKey = 'dept_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function slaPlan()
    {
        $related = 'App\Model\helpdesk\Manage\Sla\Sla_plan';
        $foreignKey = 'sla';

        return $this->belongsTo($related, $foreignKey);
    }

    public function statuses()
    {
        $related = 'App\Model\helpdesk\Ticket\Ticket_Status';
        $foreignKey = 'status';

        return $this->belongsTo($related, $foreignKey);
    }

    public function priority()
    {
        $related = 'App\Model\helpdesk\Ticket\Ticket_Priority';
        $foreignKey = 'priority_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function save(array $options = [])
    {
        $changed = $this->isDirty() ? $this->getDirty() : false;
        $id = $this->id;
        $model = $this->find($id);
        $save = parent::save($options);
        if ($this->notify) {
            $array = ['changes' => $changed, 'model' => $model, 'system'=>  $this->system, 'send_mail'=>  $this->send];
            \Event::fire('notification-saved', [$array]);
        }

        return $save;
    }
}
