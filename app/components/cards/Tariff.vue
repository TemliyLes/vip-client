<template>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 sm:mt-16">
    <div v-for="(item, index) in data" :key="index" class="group flex flex-col">
      <div class="border border-gray-200 p-6 transition duration-400">
        <Header mini>
          {{ item.name }}
        </Header>

        <div class="mt-5">
          <Paragraph>
            {{ item.price }}
          </Paragraph>
        </div>

        <div class="flex flex-col gap-3 mt-5">
          <div v-if="item.time" class="flex gap-2">
            <Clock />

            <Paragraph> {{ item.time }} hodiny </Paragraph>
          </div>

          <div v-if="item.people_count" class="flex gap-2">
            <People />

            <Paragraph>
              {{ item.people_count }}
            </Paragraph>
          </div>
        </div>

        <Paragraph class="mt-5" v-html="item.description?.rendered" />

        <Button class="mt-6" fit arrow> Rezervovat kurz </Button>
      </div>
    </div>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Button from "../ui/Button.vue";

import Clock from "../icons/mini/clock.vue";
import People from "../icons/mini/people.vue";

defineProps({
  data: {
    type: Array,
    default: () => [],
  },
});
</script>
