<?php

namespace App\Model\helpdesk\Filters;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'filters';

    protected $fillable = ['ticket_id', 'key', 'value'];

    public function getLabelTitle($ticketid)
    {
        $filter = $this->where('ticket_id', $ticketid)->where('key', 'label')->first();
        $output = [];
        if ($filter && $filter->value) {
            $labelids = explode(',', $filter->value);
            $labels = new Label();
            $label = $labels->whereIn('title', $labelids)->get();
            if ($label->count() > 0) {
                foreach ($label as $key => $l) {
                    $output[$key] = $l->titleWithColor();
                }
            }
        }

        return $output;
    }

    public function getTagsByTicketId($ticketid)
    {
        $filter = $this->where('key', 'tag')->where('ticket_id', $ticketid)->pluck('value')->toArray();

        return $filter;
    }
}
