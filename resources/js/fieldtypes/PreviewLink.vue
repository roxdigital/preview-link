<template>
  <Button
    :text="__('preview-link::strings.copy')"
    class="w-full"
    :disabled="!show"
    @click="copyToClipboard"
  />
</template>

<script>
import { FieldtypeMixin as Fieldtype } from "@statamic/cms";
import { Button } from "@statamic/cms/ui";

export default {
  components: { Button },

  mixins: [Fieldtype],

  computed: {
    entryDate() {
      const d = this.publishContainer?.values?.date;
      if (!d?.date) return null;
      return new Date(`${d.date}T${d.time ?? "00:00"}`);
    },

    isFuture() {
      return this.entryDate instanceof Date && this.entryDate > new Date();
    },

    show() {
      // PHP preload() only sets site_url when the entry isn't already live,
      // so this is the primary gate for the initial page load.
      if (!this.meta?.site_url) return false;

      // Reactive check using publishContainer.values (a reactive Proxy):
      // if the entry was published during this CP session, hide the button.
      // Even if published, keep it visible for future-dated entries.
      const published = this.publishContainer?.values?.published;
      if (published === true && !this.isFuture) return false;

      return true;
    },
  },

  methods: {
    copyToClipboard() {
      navigator.clipboard.writeText(this.meta.site_url);
      this.$toast.success(__("preview-link::strings.copied"));
    },
  },
};
</script>
