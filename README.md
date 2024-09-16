# Preview Link

A Statamic addon for generating preview links for your entries. This addon allows you to create shareable links that include a token for previewing unpublished or draft content.

## Features

- Generate unique preview URLs for Statamic entries through a custom fieldtype.
- Configurable token expiration.
- Option to display a configurable preview mode banner at the top of the page.

## Installation

1. Add the repository to your `composer.json` file:

   ```json
   "repositories": [
       {
           "type": "vcs",
           "url": "https://github.com/roxdigital/preview-link"
       }
   ]
   ```

2. Require the package through composer

   ```bash
   composer require roxdigital/preview-link
   ```

3. After installation, publish the configuration file

   ```bash
   php artisan vendor:publish --tag=preview-link-config
   ```

## Usage

To generate a preview URL for an entry, add the custom fieldtype 'Preview link' to your blueprint. Browse to the entry in your /cp and click the button. The generated URL that it will copy will include a token that allows access to the preview through tokens stored in `/storage/statamic/tokens`.
