<?php
$filter = new \App\Model\helpdesk\Filters\Filter();
$tags = $filter->getTagsByTicketId($tickets->id);
//dd($tags);
?>
<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/demo/css/jquery-ui-base-1.8.20.css')}}">

<link rel="stylesheet" href="{{asset('lb-faveo/plugins/hailhood-tag/css/tagit-stylish-yellow.css')}}">

<tr>
    <td>
        <b>Tags:</b>
    </td>   
    <td contenteditable='true'>
        <ul id="tag" data-name="nameOfSelect" name="tag">
            @forelse($tags as $tag)
            <li>{!! $tag !!}</li>
            @empty 
            
            @endforelse
        </ul>
    </td>
</tr>

