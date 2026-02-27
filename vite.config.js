import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import * as Vue from "vue";

/**
 * Replicate the externals behaviour of @statamic/cms/vite-plugin.
 * Maps `import ... from 'vue'` → window.Vue so Vue isn't bundled.
 * (@statamic/cms/vite-plugin can't be used directly because it tries
 * to load @vitejs/plugin-vue from the host's node_modules, which doesn't
 * have it — instead we use the addon's own packages here.)
 */
function statamicExternals() {
  const VIRTUAL = "\0vue-window-external";
  const vueExports = Object.keys(Vue)
    .filter((k) => k !== "default" && /^[a-zA-Z_$][a-zA-Z0-9_$]*$/.test(k))
    .join(", ");

  return {
    name: "statamic-externals",
    enforce: "pre",
    resolveId: (id) => (id === "vue" ? VIRTUAL : null),
    load: (id) =>
      id === VIRTUAL
        ? `const Vue = window.Vue; export default Vue; export const { ${vueExports} } = Vue;`
        : null,
  };
}

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/js/index.js"],
      refresh: true,
      publicDirectory: "resources/dist",
    }),
    statamicExternals(),
    vue(),
  ],
});
