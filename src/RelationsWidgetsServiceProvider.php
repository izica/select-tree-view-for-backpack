<?php

namespace izica\SelectTreeView;

use Illuminate\Support\ServiceProvider;

class SelectTreeViewServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'backpack');
    }
}