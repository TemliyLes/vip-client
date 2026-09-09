<template>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
    <div v-for="video in videos" :key="video.id">
      <div class="relative aspect-[9/16] overflow-hidden rounded-xl bg-black">
        <!-- Загруженное видео -->
        <video
          v-if="video.video?.type === 'upload' && video.video?.url"
          :src="video.video.url"
          class="w-full h-full object-cover"
          muted
          playsinline
          preload="metadata"
          controls
        />

        <!-- Встроенное видео -->
        <iframe
          v-else-if="video.video?.type === 'embed' && video.video?.embed_url"
          :src="video.video.embed_url"
          class="absolute inset-0 w-full h-full"
          frameborder="0"
          allow="autoplay; fullscreen; picture-in-picture"
          allowfullscreen
        />

        <!-- Нет видео -->
        <div
          v-else
          class="absolute inset-0 flex items-center justify-center text-white text-center px-4"
        >
          Видео отсутствует
        </div>
      </div>

      <Paragraph
        v-if="video.title?.rendered"
        class="mt-4"
        v-html="video.title.rendered"
      />
    </div>
  </div>
</template>

<script setup>
import Paragraph from "../ui/Paragraph.vue";

const props = defineProps({
  data: {
    type: Array,
    default: () => [],
  },
});

const videos = computed(() => props.data || []);
</script>
