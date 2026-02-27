<?php

namespace Roxdigital\PreviewLink\Fieldtypes;

use Statamic\Fields\Fieldtype;
use Statamic\Entries\Entry;
use Roxdigital\PreviewLink\Services\PreviewUrl;
use Statamic\Entries\Collection;

class PreviewLink extends Fieldtype
{
    protected $categories = ['special'];

    protected $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#666666"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>';

    /**
     * The blank/default value.
     *
     * @return array
     */
    public function defaultValue()
    {
        return null;
    }

    /**
     * Preload entry data and generate a preview URL.
     *
     * Only returns a URL when the entry actually needs a preview link,
     * i.e. when it is not yet publicly visible. The Vue component simply
     * enables the button when site_url is present and disables it when empty.
     *
     * @return array
     */
    public function preload()
    {
        $entry = $this->getEntryData();

        if ($entry === null) {
            return [];
        }

        // Entry is already publicly accessible — no preview link needed.
        if ($this->isLiveEntry($entry)) {
            return [];
        }

        return ['site_url' => PreviewUrl::generate($entry)];
    }

    /**
     * Determine whether the entry is already publicly visible.
     * Mirrors the same logic in TokenProcessor so behaviour is consistent.
     *
     * @param  Entry  $entry
     * @return bool
     */
    private function isLiveEntry(Entry $entry): bool
    {
        if (! $entry->published()) {
            return false;
        }

        if ($entry->hasWorkingCopy()) {
            return false;
        }

        if ($entry->collection()->dated() && $entry->date()->isFuture()) {
            return false;
        }

        return true;
    }

    /**
     * Retrieve the current entry data from the field's parent.
     *
     * @return \Statamic\Entries\Entry|null
     */
    private function getEntryData()
    {
        if (! $entry = $this->field->parent()) {
            return null;
        }

        // Bail when creating a brand-new entry (no ID yet).
        if ($entry instanceof Collection) {
            return null;
        }

        return $entry;
    }
}
