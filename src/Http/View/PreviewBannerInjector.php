<?php

namespace Roxdigital\PreviewLink\Http\View;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class PreviewBannerInjector
{
    /**
     * Inject the preview banner into the response after all checks.
     *
     * @param Response
     * @return void
     */
    public function inject(Response $response): void
    {
        if ($this->shouldInject($response)) {
            $content = $response->getContent();
            $banner = $this->getBannerHtml();
            $content = preg_replace('/<body(.*)>/', "<body$1>\n{$banner}", $content, 1);
            $response->setContent($content);
        }
    }

    /**
     * Check if we should inject
     *
     * @param Response
     * @return bool
     */
    private function shouldInject(Response $response): bool
    {
        return !$response->isRedirection()
            && $response->headers->has('Content-Type')
            && strpos($response->headers->get('Content-Type'), 'text/html') !== false
            && Config::get('statamic.preview_link.preview.show_preview_bar', true);
    }

    /**
     * Generate the HTML for the preview banner.
     *
     * @return string
     */
    private function getBannerHtml(): string
    {
        $text = Config::get('statamic.preview_link.preview.bar_text', 'Preview Mode');
        $bgColor = Config::get('statamic.preview_link.preview.bar_color', '#ff6b6b');
        $textColor = Config::get('statamic.preview_link.preview.text_color', '#ffffff');

        return <<<HTML
            <style>
                body {
                    padding-top: 40px!important;
                }
                #preview-mode-banner {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 40px;
                    background-color: {$bgColor};
                    color: {$textColor};
                    text-align: center;
                    line-height: 40px;
                    font-family: Arial, sans-serif;
                    font-weight: bold;
                    z-index: 9999;
                }
            </style>
            <div id="preview-mode-banner">
                {$text}
            </div>
        HTML;
    }
}
