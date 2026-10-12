<template>
  <section>
    <h2 class="sr-only">{{ $t('accessibility.tariffs') }}</h2>
    <ul
      class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 sm:mt-16 items-stretch"
    >
      <li
        v-for="(item, index) in data"
        :key="index"
        class="group flex min-w-0 flex-col h-full"
      >
        <article
          class="border border-gray-200 p-6 transition duration-400 flex flex-1 flex-col h-full"
        >
          <Header tag="h3" mini class="min-h-[36px]">
            {{ item.name }}
          </Header>

          <div class="mt-5">
            <Paragraph>
              {{ item.price }}
            </Paragraph>
          </div>

          <dl class="flex flex-col gap-3 mt-5">
            <div v-if="item?.time" class="flex gap-2">
              <dt class="shrink-0"><Clock aria-hidden="true" /><span class="sr-only">{{ $t('accessibility.duration') }}</span></dt>

              <Paragraph tag="dd"> {{ item?.time }}{{ $t('ui.components.cards.Tariff.paragraphText1') }}</Paragraph>
            </div>

            <div v-if="item?.people_count" class="flex gap-2">
              <dt class="shrink-0"><People aria-hidden="true" /><span class="sr-only">{{ $t('accessibility.participants') }}</span></dt>

              <Paragraph tag="dd">
                {{ item?.people_count }}
              </Paragraph>
            </div>
          </dl>

          <RichText
            class="mt-5 flex-1 rich-text"
            :content="item?.description?.rendered"
          />

          <ReservioButton
            :item="item"
            :url="item?.reservio_url"
            :service-id="serviceId"
            class="mt-6"
          >
          </ReservioButton>
        </article>
      </li>
    </ul>
  </section>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import ReservioButton from "../ui/ReservioButton.vue";
import RichText from "../ui/RichText.vue";

import Clock from "../icons/mini/clock.vue";
import People from "../icons/mini/people.vue";

defineProps({
  serviceId: { type: Number, default: 0 },
  data: {
    type: Array,
    default: () => [],
  },
});

</script>
