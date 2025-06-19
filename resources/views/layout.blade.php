{{# layout.blade.php #}}
@php
$currentSite = Statamic\Facades\Site::current()->handle();
$layoutPath = match($currentSite) {
    'Grelka' => 'grelka.layout',
    'Gun1or' => 'gun1or.layout',
    'GFoodcafe' => 'gfoodcafe.layout',
    default => 'default.layout'
};

// Получаем настройки сайта
$siteSettingsGlobal = \Statamic\Facades\GlobalSet::find('site_settings');
$site_settings = [];
if ($siteSettingsGlobal) {
    $siteSettingsData = $siteSettingsGlobal->in($currentSite);
    if ($siteSettingsData) {
        $site_settings = $siteSettingsData->data()->toArray();
    }
}

// Получаем данные футера
$footerGlobal = \Statamic\Facades\GlobalSet::find('footer');
$footer = null;
if ($footerGlobal) {
    $footerData = $footerGlobal->in($currentSite);
    if ($footerData) {
        $footer = $footerData->data();
    }
}
@endphp

@include($layoutPath, compact('site_settings', 'footer'))
