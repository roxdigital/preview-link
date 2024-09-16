<?php

namespace Roxdigital\PreviewLink\Fieldtypes;

use Statamic\Fields\Fieldtype;
use Statamic\Entries\Entry;
use Illuminate\Support\Str;
use Roxdigital\PreviewLink\Services\PreviewUrl;

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
     * @return array
     */
    public function preload()
    {
        $entry = $this->getEntryData();

        if ($entry === null) {
            return [];
        }

        return ['site_url' => PreviewUrl::generate($entry)];
    }

    /**
     * Retrieve the current entry data from the request path.
     *
     * @return \Statamic\Entries\Entry|null
     */
    private function getEntryData()
    {
        $path = request()->path();
        $segments = explode('/', $path);

        // Check if we are in a entry of a collection, and if so, check if we have a valid Uuid
        if (count($segments) >= 5 && $segments[1] === 'collections' && $segments[3] === 'entries') {
            if ($segments[4] !== 'create') {
                $potentialId = $segments[4];
                if (Str::isUuid($potentialId)) {
                    $entry = Entry::find($potentialId);
                    if ($entry) {
                        return $entry;
                    }
                }
            }
        }
        // Return null if this is not an entry
        return null;
    }

}
