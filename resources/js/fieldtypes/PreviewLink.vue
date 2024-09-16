<template>
  <div>
    <button
      type="button"
      class="btn w-full"
      @click="copyToClipboard"
      v-text="__('Kopieer de preview URL')"
    ></button>
  </div>
</template>

<script>
export default {
  mixins: [Fieldtype],

  methods: {
    copyToClipboard() {
      navigator.clipboard.writeText(this.meta.site_url);
      this.$toast.success(__("Preview URL is gekopieerd"));
    },
  },
};
</script>
