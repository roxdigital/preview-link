<?php

namespace Roxdigital\PreviewLink;

use Statamic\Providers\AddonServiceProvider;
use Roxdigital\PreviewLink\Fieldtypes\PreviewLink;

class ServiceProvider extends AddonServiceProvider
{
    protected $fieldtypes = [
        PreviewLink::class
    ];

    protected $vite = [
        'input' => ['resources/js/index.js'],
        'publicDirectory' => 'resources/dist',
    ];

    public function boot()
    {
        parent::boot();

        $this->publishes([
            __DIR__.'/../config/preview_link.php' => config_path('statamic/preview_link.php'),
        ], 'preview-link-config');

        $this->mergeConfigFrom(__DIR__.'/../config/preview_link.php', 'statamic.preview_link');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'preview-link');
    }
}
