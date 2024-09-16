import PreviewLinkField from './fieldtypes/PreviewLink.vue';
 
Statamic.booting(() => {
    Statamic.$components.register('preview_link-fieldtype', PreviewLinkField);
});