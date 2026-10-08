<template>
  <div>
    <NuxtLinkLocale
      :to="link"
      class="group flex flex-col h-full"
      @mousedown.left.prevent="focusCard"
    >
      <div class="relative">
        <img
          v-if="image"
          :src="image"
          :alt="title"
          :width="data?.images?.card?.width ?? (category ? 473 : undefined)"
          :height="data?.images?.card?.height ?? (category ? 582 : undefined)"
          class="brightness-80 transition duration-400 group-hover:brightness-100 mb-1 w-full h-auto"
        />

        <div
          v-if="discount"
          class="absolute top-3 right-3 bg-wine text-white px-3 py-2 text-sm"
        >{{ $t('ui.components.cards.Card.divText1') }}{{ discount }}{{ $t('ui.components.cards.Card.divText2') }}</div>
      </div>

      <Header mini class="line-clamp-1 overflow-hidden">
        {{ title }}
      </Header>
      <Paragraph
        v-if="data?.service_fields?.description"
        class="mt-2 line-clamp-2 overflow-hidden min-h-10"
      >
        {{ data?.service_fields?.description }}
      </Paragraph>

      <div v-if="data?.service_fields" class="flex flex-col gap-3 mt-4">
        <div v-if="data.service_fields.time" :class="flexClasses">
          <Clock />
          <Paragraph>
            {{ addClockAffix(data.service_fields.time) }}
          </Paragraph>
        </div>

        <div v-if="data.service_fields.price" :class="flexClasses">
          <Money />

          <Paragraph>
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
          <People />
          <Paragraph>
            {{ data.service_fields.people_count }}
          </Paragraph>
        </div>
      </div>

      <Button v-if="btn" tag="span" class="mt-4" fit arrow>{{ $t('ui.components.cards.Card.buttonText1') }}</Button>
    </NuxtLinkLocale>
  </div>
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
  const value = props.data?.service_fields?.discount;

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
