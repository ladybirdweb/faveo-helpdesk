<?php

$filter = new \App\Model\helpdesk\Filters\Filter();
$types = $filter->getTagsByTicketId($tickets->id);

?>
<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">

<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

<tr>
    <td>
        <b>Type:</b>
    </td>   
    <td contenteditable='true'>
        <ul id="type" data-name="nameOfSelect" name="type">
            @forelse($types as $type)
            <li>{!! $type !!}</li>
            @empty 
            
            @endforelse
        </ul>
    </td>
</tr>

