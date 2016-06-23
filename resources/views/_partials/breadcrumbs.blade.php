@if ($breadcrumbs)
<ol class="breadcrumb breadcrumb-custom">
    <li class="text"> {!! Lang::get('lang.you_are_here') !!} :</li>
    @foreach ($breadcrumbs as $breadcrumb)
    @if (!$breadcrumb->last)
    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
    @else
    <li class="text">{{ $breadcrumb->title }}</li>
    @endif
    @endforeach
</ol>
@endif