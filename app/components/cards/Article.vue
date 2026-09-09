<template>
  <div>
    <AlterHero />

    <Container class="py-12 sm:py-24">
      <Header center class="mb-6">
        {{ content?.title?.rendered }}
      </Header>

      <Paragraph class="text-center mb-12">
        {{ content?.meta?.service_description }}
      </Paragraph>

      <img
        class="object-cover w-full max-h-[520px]"
        :src="content?.images?.original?.url"
        alt=""
      />

      <div class="mt-12">
        <RichText :content="content?.content?.rendered" />
        <Tariff
          v-if="content?.service_fields?.tariffs"
          class="mt-12 sm:mt-0"
          :data="content?.service_fields?.tariffs"
        />
        <div class="mt-8 sm:mt-16" v-if="content?.videos?.length">
          <Header class="mb-8" center>Související video</Header>
          <ArticleVideos :data="content?.videos" />
          <!-- <div v-html="content?.content?.rendered"></div> -->
        </div>
      </div>
    </Container>
  </div>
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import Container from "~/components/ui/Container.vue";
import Header from "~/components/ui/Header.vue";
import Paragraph from "~/components/ui/Paragraph.vue";
import RichText from "../ui/RichText.vue";
import Tariff from "./Tariff.vue";
import ArticleVideos from "../blocks/ArticleVideos.vue";

const props = defineProps({
  store: {
    type: Object,
    required: true,
  },

  news: {
    type: Boolean,
    default: false,
  },
});

const content = computed(() => {
  return props.news ? props.store.data : props.store.article;
});
</script>
