<template>
  <article class="flex h-full w-full flex-1 flex-col">
    <NuxtLinkLocale
      :to="link"
      class="group flex min-w-0 flex-1 flex-col"
      @mousedown.left.prevent="focusCard"
    >
      <div class="relative mb-1 shrink-0">
        <img
          v-if="image"
          :src="image"
          :alt="title"
          :width="data?.images?.card?.width ?? (category ? 473 : undefined)"
          :height="data?.images?.card?.height ?? (category ? 582 : undefined)"
          class="brightness-80 transition duration-400 group-hover:brightness-100 w-full h-auto object-cover"
          :class="imageAspect"
        />
        <div v-else aria-hidden="true" class="w-full bg-milk" :class="imageAspect" />

        <div
          v-if="discount"
          class="absolute top-3 right-3 bg-wine text-white px-3 py-2 text-sm"
        >{{ $t('ui.components.cards.Card.divText1') }}{{ discount }}{{ $t('ui.components.cards.Card.divText2') }}</div>
      </div>

      <Header :tag="headingTag" mini class="line-clamp-1 overflow-hidden">
        {{ title }}
      </Header>
      <Paragraph
        v-if="data?.service_fields?.description"
        class="mt-2 line-clamp-2! overflow-hidden min-h-10"
      >
        {{ data?.service_fields?.description }}
      </Paragraph>

      <div v-if="data?.service_fields || btn" class="mt-auto pt-4">
        <dl v-if="data?.service_fields" class="flex flex-col gap-3">
          <div v-if="data.service_fields.time" :class="flexClasses">
            <dt class="shrink-0"><Clock aria-hidden="true" /><span class="sr-only">{{ $t('accessibility.duration') }}</span></dt>
            <Paragraph tag="dd">
              {{ addClockAffix(data.service_fields.time) }}
            </Paragraph>
          </div>

          <div v-if="data.service_fields.price" :class="flexClasses">
            <dt class="shrink-0"><Money aria-hidden="true" /><span class="sr-only">{{ $t('accessibility.price') }}</span></dt>

            <Paragraph tag="dd">
              <template v-if="discount">
                <span class="line-through opacity-50 mr-2">
                  {{ addPriceAffix(data.service_fields.price) }}
                </span>
              </template>

              <template v-else>
                {{ addPriceAffix(data.service_fields.price) }}
              </template>
            </Paragraph>
          </div>

          <div v-if="data.service_fields.people_count" :class="flexClasses">
            <dt class="shrink-0"><People aria-hidden="true" /><span class="sr-only">{{ $t('accessibility.participants') }}</span></dt>
            <Paragraph tag="dd">
              {{ data.service_fields.people_count }}
            </Paragraph>
          </div>
        </dl>

        <Button v-if="btn" tag="span" :class="{ 'mt-4': data?.service_fields }" fit arrow>{{ $t('ui.components.cards.Card.buttonText1') }}</Button>
      </div>
    </NuxtLinkLocale>
  </article>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Clock from "../icons/mini/clock.vue";
import Money from "../icons/mini/money.vue";
import People from "../icons/mini/people.vue";
import { decodeWpText } from "~/utils/decodeWpText";
import Button from "../ui/Button.vue";

const props = defineProps({
  headingTag: { type: String, default: "h3" },
  data: {
    type: Object,
    required: true,
  },

  category: {
    type: Boolean,
    default: false,
  },

  btn: {
    type: Boolean,
    default: false,
  },
});

const flexClasses = "flex gap-2";
const imageAspect = computed(() => props.category ? 'aspect-[473/582]' : 'aspect-[360/390]');

// Native focus scrolling can move a partially visible card before mouseup.
const focusCard = (event) => {
  event.currentTarget.focus({ preventScroll: true });
};

const image = computed(() => {
  return props.data?.image?.url || props.data?.images?.card?.url || "";
});

const title = computed(() => {
  return decodeWpText(props.data?.name || props.data?.title?.rendered || "");
});

const discount = computed(() => {
  // Скидки временно скрыты. Для возврата отображения раскомментируйте строку поля WP.
  const value =
    // props.data?.service_fields?.discount ??
    null;

  return value ? Number(value) : null;
});

const isService = computed(() => {
  return Array.isArray(props.data?.["service-categories"]);
});

const prefix = computed(() => {
  if (props.category) return "category";
  if (isService.value) return "services";

  return "news";
});

const link = computed(() => {
  return `/${prefix.value}/${props.data?.id}`;
});

const addClockAffix = (value) => {
  return `${value}`;
};

const addPriceAffix = (value) => {
  return `${value}`;
};
</script>
