<template>
  <div>
    <NuxtLink :to="`../${prefix}/${data?.id}`" class="group">
      <img
        :src="data?.image?.url || data?.images?.card?.url"
        :alt="data?.name"
        class="brightness-80 transition duration-400 group-hover:brightness-100 mb-1"
      />
      <Header mini>{{ data?.name || data?.title?.rendered }}</Header>
      <!-- <Paragraph>data</Paragraph> -->
      <div class="flex flex-col gap-3 mt-4">
        <div :class="flexClasses" v-if="data?.service_fields?.time">
          <Clock />
          <Paragraph>{{ addClockAffix(data?.service_fields?.time) }}</Paragraph>
        </div>
        <div :class="flexClasses" v-if="data?.service_fields?.price">
          <Money />
          <Paragraph>{{
            addPriceAffix(data?.service_fields?.price)
          }}</Paragraph>
        </div>
        <div :class="flexClasses" v-if="data?.service_fields?.people_count">
          <People />
          <Paragraph>{{ data?.service_fields?.people_count }}</Paragraph>
        </div>
      </div>
      <Button class="mt-4" v-if="btn" fit arrow>program kurzu</Button>
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
const isService = computed(() => !!props.data["service-categories"]);
const servPrefix = computed(() => (isService.value ? "services" : "news"));
const prefix = computed(() => (props.category ? "category" : servPrefix.value));

const flexClasses = computed(() => "flex gap-2");

const addClockAffix = (str) => {
  return str + " hodiny";
};
const addPriceAffix = (str) => {
  return str + " Kč";
};
</script>
