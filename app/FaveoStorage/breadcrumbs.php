<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::register('storage', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Storage', route('storage'));
});
