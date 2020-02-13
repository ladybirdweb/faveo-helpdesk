<?php

Breadcrumbs::register('storage', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Storage', route('storage'));
});
