<template>
  <div>
    <button
      type="button"
      class="btn w-full"
      @click="copyToClipboard"
      :disabled="!show"
      v-text="translate('preview-link::strings.copy')"
    ></button>
  </div>
</template>

<script>
export default {
  mixins: [Fieldtype],

  computed: {
    entryDate() {
      let dateTime = this.publishForm.values.date;

      if (!dateTime) {
        return null;
      }

      return moment(dateTime.date + "T" + dateTime.time, "YYYY-MM-DDTHH:mm");
    },

    isFuture() {
      return this.entryDate?.isAfter(moment());
    },

    isWorkingCopy() {
      return (
        this.publishForm.revisionsEnabled && this.publishForm.isWorkingCopy
      );
    },

    publishForm() {
      let vm = this;
      while (true) {
        let parent = vm.$parent;

        if (!parent) {
          return false;
        }

        if (parent.$options._componentTag == "entry-publish-form") {
          return parent;
        }
        vm = parent;
      }
    },

    show() {
      if (!this.publishForm) {
        return false;
      }

      if (this.publishForm.isDirty) {
        return false;
      }

      return this.isWorkingCopy || !this.publishForm.published || this.isFuture;
    },
  },
  mounted() {
    const translation = this.translate("preview-link.messages.copied");
    console.log("Translation:", translation);
  },
  methods: {
    copyToClipboard() {
      navigator.clipboard.writeText(this.meta.site_url);
      this.$toast.success(this.translate("preview-link::strings.copied"));
    },
  },
};
</script>
