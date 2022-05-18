<?php

namespace Rias\CollectionGroups;

use Statamic\CP\Navigation\NavItem;
use Statamic\Facades\Collection;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->publishes([__DIR__.'/../config/collection-groups.php' => config_path('statamic/collection-groups.php')]);
        $this->mergeConfigFrom(__DIR__.'/../config/collection-groups.php', 'statamic.collection-groups');

        Nav::extend(function (\Statamic\CP\Navigation\Nav $nav) {
            collect(config('statamic.collection-groups'))->each(function ($collections, $label) use ($nav) {
                $collections = collect($collections)->map(function (string $collectionHandle, $label) {
                    $collection = Collection::findByHandle($collectionHandle);

                    $label = !is_numeric($label) ? $label : $collection->title();

                    return (new NavItem())
                        ->name($label)
                        ->url($collection->showUrl());
                });

                /** @var \Statamic\CP\Navigation\NavItem $item */
                $item = $nav->create($label)
                    ->active($collections->pluck('url')->join('|'))
                    ->section('Content')
                    ->icon('content-writing')
                    ->url($collections->first()->url());

                $item->children($collections);
            });

            /** @var NavItem $collectionNavItem */
            $collectionNavItem = $nav->findOrCreate('Content', 'Collections');
            $collectionNavItem->children(($collectionNavItem->children()())->filter(function (NavItem $child) {
                return ! in_array($child->name(), collect(config('statamic.collection-groups'))->flatMap(function ($collections) {
                    return collect($collections)->map(function (string $handle) {
                        return Collection::findByHandle($handle)->title();
                    });
                })->toArray());
            }));

            return $nav;
        });
    }
}
