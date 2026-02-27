# Changelog

## [3.0.0] - 27-02-2026

### Changed

- **Statamic 6 / Vue 3 compatibility.**
- Vue component migrated to Vue 3: imports `FieldtypeMixin` and `Button` from `@statamic/cms`, replaces `moment.js` with native `Date`, replaces `$parent` traversal with `publishContainer`.
- Publish-state logic moved to PHP `preload()` — button is only shown when the entry needs a preview (draft, working copy, or future-dated).
- `publishContainer.values.published` used for live reactive disable state.
- Vite config updated: uses `@vitejs/plugin-vue` + a virtual-module plugin to map `vue` → `window.Vue`, resolves `@statamic/cms` from the host project via `vendor/` symlink.
- Minimum PHP `^8.3`, minimum Statamic `^6.0`.

## [2.0.3] - 17-10-2025

### Changed

- Updated dependencies and added license & credits.

## [2.0.2] - 04-04-2025

### Changed

- Added translations

## [2.0.1] - 04-04-2025

### Changed

- [Bump vite to 4.4.5](https://github.com/roxdigital/preview-link/commit/10c70caa9854ffe419f98434a7edc20c1f979df8)
- [Bump rollup to 3.29.5](https://github.com/roxdigital/preview-link/commit/2135d6b25882e89a9d74b41d64351cd5aeac7f20)
- [Bump nanoid to 3.3.8](https://github.com/roxdigital/preview-link/pull/5)
- [Other dependabot updates](https://github.com/roxdigital/preview-link/pull/7)

## [2.0.0] - 20-09-2024

### Changed

- Updated the Preview Link addon to be compatible with Statamic 5.
- Simplified the process by using $this->field->parent() to get the Entry instead of using the URL.

## [1.0.0] - 17-09-2024

### Added

- Initial release of the Preview Link addon.
- Features include generating unique preview URLs through custom fieldtype for Statamic entries.
- Configurable token expiration settings.
- Option to display a preview mode banner at the top of the page.
