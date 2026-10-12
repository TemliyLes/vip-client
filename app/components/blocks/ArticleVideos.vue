<template>
  <ul class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
    <li v-for="video in videos" :key="video.id">
      <figure>
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
            data-exclusive-playback
            @play="pauseOtherVideos"
          />

          <!-- Встроенное видео -->
          <iframe
            :title="decodeWpText(video.title?.rendered) || $t('ui.components.cards.Article.headerText1')"
            v-else-if="video.video?.type === 'embed' && video.video?.embed_url"
            :src="video.video.embed_url"
            class="absolute inset-0 w-full h-full"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen
          />

          <!-- Нет видео -->
          <p
            v-else
            class="absolute inset-0 flex items-center justify-center text-white text-center px-4"
          >{{ $t('ui.components.blocks.ArticleVideos.divText1') }}</p>
        </div>

        <Paragraph tag="figcaption" v-if="video.title?.rendered" class="mt-4">
          {{ decodeWpText(video.title.rendered) }}
        </Paragraph>
      </figure>
    </li>
  </ul>
</template>

<script setup>
import Paragraph from "../ui/Paragraph.vue";
import { decodeWpText } from "~/utils/decodeWpText";
import { pauseOtherVideos } from "~/utils/videoPlayback";

const props = defineProps({
  data: {
    type: Array,
    default: () => [],
  },
});

const videos = computed(() => props.data || []);
</script>
