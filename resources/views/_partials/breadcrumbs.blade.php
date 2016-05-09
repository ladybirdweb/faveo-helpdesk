@if ($breadcrumbs)
<div class="site-hero clearfix">
    <ol class="breadcrumb breadcrumb-custom">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$breadcrumb->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="text">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
</div>
@endif