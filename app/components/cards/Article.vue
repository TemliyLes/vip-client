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

      <div
        class="mt-12 grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_320px] xl:grid-cols-[minmax(0,1fr)_400px] gap-x-8 lg:gap-x-12"
      >
        <!-- Основной текст -->
        <div class="min-w-0 lg:col-start-1 lg:row-start-1">
          <RichText :content="content?.content?.rendered" />
        </div>

        <!-- Sticky блок -->
        <aside
          v-if="content?.service_fields"
          class="mt-8 lg:mt-0 lg:col-start-2 lg:row-start-1 lg:row-end-4 relative"
        >
          <div class="lg:sticky lg:top-24 flex flex-col gap-4">
            <Header mini class="">Servisní informace</Header>
            <div v-if="content.service_fields.time" :class="flexClasses">
              <Clock class="w-7 h-7 shrink-0" />

              <Paragraph>
                {{ content.service_fields.time }}
              </Paragraph>
            </div>

            <div v-if="content?.service_fields?.price" :class="flexClasses">
              <Money class="w-7 h-7 shrink-0" />

              <Paragraph>
                <template v-if="discount">
                  <span class="line-through opacity-50 mr-2">
                    {{ content.service_fields.price }}
                  </span>
                </template>

                <template v-else>
                  {{ content.service_fields.price }}
                </template>
              </Paragraph>
            </div>

            <div
              v-if="content.service_fields.people_count"
              :class="flexClasses"
            >
              <People class="w-7 h-7 shrink-0" />

              <Paragraph>
                {{ content.service_fields.people_count }}
              </Paragraph>
            </div>

            <Header v-if="discount" mini>
              {{ discountPrice }}
            </Header>
          </div>
        </aside>

        <!-- Тарифы на всю ширину -->
        <Tariff
          v-if="content?.service_fields?.tariffs"
          class="mt-12 sm:mt-16 lg:col-start-1 lg:col-end-3 lg:row-start-2"
          :data="content.service_fields.tariffs"
        />

        <!-- Видео на всю ширину -->
        <div
          v-if="content?.videos?.length"
          class="mt-8 sm:mt-16 lg:col-start-1 lg:col-end-3 lg:row-start-3"
        >
          <Header class="mb-8" center> Související video </Header>

          <ArticleVideos :data="content.videos" />
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

import Clock from "../icons/mini/clock.vue";
import Money from "../icons/mini/money.vue";
import People from "../icons/mini/people.vue";

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

const flexClasses = "flex gap-3 items-center";

const content = computed(() => {
  return props.news ? props.store.data : props.store.article;
});

const discount = computed(() => {
  const value = content.value?.service_fields?.discount;

  return value ? Number(value) : null;
});

const discountPrice = computed(() => {
  const price = Number(
    content.value?.service_fields?.price?.replace(/\s/g, ""),
  );

  const percent = Number(discount.value);

  if (!price || !percent) {
    return price;
  }

  return Math.round(price - (price * percent) / 100);
});
</script>
