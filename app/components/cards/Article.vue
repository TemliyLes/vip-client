<template>
  <div>
    <AlterHero />

    <Container class="py-20">
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
        <!-- <div v-html="content?.content?.rendered"></div> -->
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
