<?php

namespace Roxdigital\PreviewLink\Http\Middleware;

use Closure;
use Statamic\Contracts\Tokens\Token;
use Statamic\Entries\Entry;
use Statamic\Facades\Entry as EntryFacade;
use Roxdigital\PreviewLink\Http\View\PreviewBannerInjector;

class TokenProcessor
{
    private $bannerInjector;

    public function __construct(PreviewBannerInjector $bannerInjector)
    {
        $this->bannerInjector = $bannerInjector;
    }

    /**
     * Handle the token processing.
     *
     * @param Token $token The token to process
     * @param mixed $request The incoming request
     * @param Closure $next The next middleware
     * @return mixed
     */
    public function handle(Token $token, $request, Closure $next)
    {
        if (! $entry = EntryFacade::find($token->token())) {
            return $next($request);
        }

        if ($this->isLiveEntry($entry)) {
            return redirect($entry->url());
        }

        $entry->repository()->substitute($this->prepareEntry($entry));

        $response = $next($request);

        $this->bannerInjector->inject($response);

        return $response;
    }

    /**
     * Check if the entry is published and viewable
     *
     * @param Entry
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
     * Prepare the entry for preview, adjusting dates and
     * making a working copy.
     *
     * @param Entry
     * @return Entry
     */
    private function prepareEntry(Entry $entry): Entry
    {
        if ($entry->collection()->dated() && $entry->date()->isFuture()) {
            $entry->date(now());
        }

        $originalSlug = $entry->slug();

        if ($entry->hasWorkingCopy()) {
            $entry = $entry->fromWorkingCopy();
        }

        $entry->slug($originalSlug);

        return $entry->published(true);
    }
}
