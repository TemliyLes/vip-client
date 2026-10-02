<template>
  <div class="w-full h-[500px] overflow-hidden">
    <iframe
      class="w-full h-full border-0"
      loading="lazy"
      allowfullscreen
      src="https://www.google.com/maps?q=Na%20Svihance%201476%2F1%2C%20Praha%2012000&output=embed"
    />
  </div>
</template>
<script setup>
const props = defineProps({
  query: {
    type: String,
    default: "",
  },
});

const { t } = useI18n({ useScope: 'global' });
const mapUrl = computed(() => {
  return `https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=${encodeURIComponent(props.query || t('ui.components.blocks.Map.queryDefault'))}`;
});
</script>
