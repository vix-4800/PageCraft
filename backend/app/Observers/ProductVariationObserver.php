<?php

namespace App\Observers;

use App\Models\ProductVariation;

class ProductVariationObserver
{
    /**
     * Handle the ProductVariation "created" event.
     */
    public function created(ProductVariation $productVariation): void
    {
        $productVariation->price *= 100;
        $productVariation->saveQuietly();
    }

    /**
     * Handle the ProductVariation "updated" event.
     */
    public function updated(ProductVariation $productVariation): void
    {
        //
    }

    /**
     * Handle the ProductVariation "deleted" event.
     */
    public function deleted(ProductVariation $productVariation): void
    {
        //
    }

    /**
     * Handle the ProductVariation "restored" event.
     */
    public function restored(ProductVariation $productVariation): void
    {
        //
    }

    /**
     * Handle the ProductVariation "force deleted" event.
     */
    public function forceDeleted(ProductVariation $productVariation): void
    {
        //
    }
}
