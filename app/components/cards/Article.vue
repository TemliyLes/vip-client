<template>
  <article :aria-labelledby="headingId">
    <AlterHero />

    <Container class="mt-6 sm:mt-8">
      <Breadcrumbs :items="[...breadcrumbs, { label: content?.title?.rendered }]" />
    </Container>

    <Container class="py-12 sm:py-24">
      <header>
        <Header tag="h1" :id="headingId" center class="mb-6">
          {{ decodeWpText(content?.title?.rendered) }}
        </Header>

        <Paragraph v-if="!news || description" class="text-center mb-12">
          {{ description }}
        </Paragraph>
      </header>

      <img
        class="object-cover w-full max-h-[520px]"
        :src="content?.images?.original?.url"
        :alt="decodeWpText(content?.title?.rendered)"
      />

      <div class="mt-12">
        <!-- Основной блок -->
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-x-12">
          <!-- Основной текст -->
          <div class="min-w-0 flex-1">
            <RichText :content="content?.content?.rendered" />

            <div
              v-if="
              !content?.service_fields?.tariffs?.length &&
              content?.service_fields
              "
            >
              <ReservioButton
                :item="content"
                :url="content?.meta?.reservio_url"
              />
            </div>
          </div>

          <!-- Sticky блок -->
          <aside
            v-if="hasSidebar"
            class="mt-8 lg:mt-0 w-full lg:w-[320px] xl:w-[400px] shrink-0 relative"
          >
            <div class="lg:sticky lg:top-24 flex flex-col gap-4">
              <Header mini>{{ $t('ui.components.cards.Article.headerText2') }}</Header>

              <dl class="flex flex-col gap-4">
                <div v-if="content?.service_fields?.time" :class="flexClasses">
                  <dt class="shrink-0"><Clock aria-hidden="true" class="w-7 h-7" /><span class="sr-only">{{ $t('accessibility.duration') }}</span></dt>

                  <Paragraph tag="dd">
                    {{ content.service_fields.time }}
                  </Paragraph>
                </div>

                <div v-if="content?.service_fields?.price" :class="flexClasses">
                  <dt class="shrink-0"><Money aria-hidden="true" class="w-7 h-7" /><span class="sr-only">{{ $t('accessibility.price') }}</span></dt>

                  <Paragraph tag="dd">
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
                  v-if="content?.service_fields?.people_count"
                  :class="flexClasses"
                >
                  <dt class="shrink-0"><People aria-hidden="true" class="w-7 h-7" /><span class="sr-only">{{ $t('accessibility.participants') }}</span></dt>

                  <Paragraph tag="dd">
                    {{ content.service_fields.people_count }}
                  </Paragraph>
                </div>
              </dl>

              <Header tag="p" v-if="discount" mini>
                {{ discountPrice }}
              </Header>
            </div>
          </aside>
        </div>

        <!-- Тарифы -->
        <Tariff
          v-if="content?.service_fields?.tariffs"
          class="mt-12"
          :data="content.service_fields.tariffs"
          :service-id="content.id"
        />

        <!-- Видео -->
        <section v-if="content?.videos?.length" class="mt-8 sm:mt-16">
          <Header class="mb-8" center>{{ $t('ui.components.cards.Article.headerText1') }}</Header>

          <ArticleVideos :data="content.videos" />
        </section>
      </div>
    </Container>
  </article>
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import Container from "~/components/ui/Container.vue";
import Breadcrumbs from "~/components/ui/Breadcrumbs.vue";
import Header from "~/components/ui/Header.vue";
import Paragraph from "~/components/ui/Paragraph.vue";
import RichText from "../ui/RichText.vue";
import Tariff from "./Tariff.vue";
import ArticleVideos from "../blocks/ArticleVideos.vue";
import ReservioButton from "../ui/ReservioButton.vue";
import { decodeWpText } from "~/utils/decodeWpText";

import Clock from "../icons/mini/clock.vue";
import Money from "../icons/mini/money.vue";
import People from "../icons/mini/people.vue";
import Button from "../ui/Button.vue";

const props = defineProps({
  breadcrumbs: {
    type: Array,
    default: () => [],
  },
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
const headingId = useId();

const content = computed(() => {
  return props.news ? props.store.data : props.store.article;
});

const description = computed(() => props.news
  ? content.value?.news_fields?.description
  : content.value?.meta?.service_description,
);

const discount = computed(() => {
  // Скидки временно скрыты. Для возврата отображения раскомментируйте строку поля WP.
  // Перед включением завершите расчёт цен с валютой, префиксом «od» и диапазонами.
  const value =
    // content.value?.service_fields?.discount ??
    null;

  return value ? Number(value) : null;
});

const hasSidebar = computed(() => {
  return (
    !content.value?.service_fields?.tariffs?.length &&
    content.value?.service_fields
  );
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
