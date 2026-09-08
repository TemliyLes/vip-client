<template>
  <div>
    <NuxtLink :to="link" class="group">
      <div class="relative">
        <img
          v-if="image"
          :src="image"
          :alt="title"
          class="brightness-80 transition duration-400 group-hover:brightness-100 mb-1 w-full"
        />

        <div
          v-if="discount"
          class="absolute top-3 right-3 bg-wine text-white px-3 py-2 text-sm"
        >
          -{{ discount }}%
        </div>
      </div>

      <Header mini>
        {{ title }}
      </Header>

      <Paragraph v-if="desc" class="mt-2 h-12">{{
        data?.service_fields?.description
      }}</Paragraph>

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
        <Header mini>
          {{ addPriceAffix(discountPrice) }}
        </Header>
      </div>

      <Button v-if="btn" class="mt-4" fit arrow> program kurzu </Button>
    </NuxtLink>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Clock from "../icons/mini/clock.vue";
import Money from "../icons/mini/money.vue";
import People from "../icons/mini/people.vue";
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
  desc: {
    type: Boolean,
    default: false,
  },
});

const flexClasses = "flex gap-2";

const image = computed(() => {
  return props.data?.image?.url || props.data?.images?.card?.url || "";
});

const title = computed(() => {
  return props.data?.name || props.data?.title?.rendered || "";
});

const discount = computed(() => {
  const value = props.data?.service_fields?.discount;

  return value ? Number(value) : null;
});

const discountPrice = computed(() => {
  const price = Number(props.data?.service_fields?.price?.replace(/\s/g, ""));

  const percent = Number(discount.value);

  if (!price || !percent) {
    return price;
  }

  return Math.round(price - (price * percent) / 100);
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
  return `${value} hodiny`;
};

const addPriceAffix = (value) => {
  return `${value} Kč`;
};
</script>
