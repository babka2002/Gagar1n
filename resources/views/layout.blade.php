{{# layout.blade.php #}}
@php
$currentSite = Statamic\Facades\Site::current()->handle();
$layoutPath = match($currentSite) {
    'Grelka' => 'grelka.layout',
    'Gun1or' => 'gun1or.layout',
    'GFoodcafe' => 'gfoodcafe.layout',
    default => 'default.layout'
};
@endphp

@include($layoutPath)