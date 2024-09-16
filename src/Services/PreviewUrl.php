<?php

namespace Roxdigital\PreviewLink\Services;

use Statamic\Entries\Entry;
use Statamic\Facades\Token as TokenFacade;
use Statamic\Tokens\Token;
use Roxdigital\PreviewLink\Http\Middleware\TokenProcessor;
use Illuminate\Support\Facades\Config;

class PreviewUrl
{
    /**
     * Generate a preview URL for the given entry.
     *
     * This method creates or retrieves a token for the entry and appends it to the entry's absolute URL.
     * If a token doesn't exist, it creates a new one with a 6-month expiration.
     *
     * @param Entry
     * @return string
     */
    public static function generate(Entry $entry): string
    {
        if (! $token = TokenFacade::find($entry->id())) {
            $token = TokenFacade::make(token: $entry->id(), handler: TokenProcessor::class);
            // Get the expiration value from the config
            $expirationMonths = Config::get('statamic.preview_link.token.expiration_months', 6);
            $token->expireAt(now()->addMonths($expirationMonths))->save();
        }

        return $entry->absoluteUrl().'?token='.$token->token();
    }
}
