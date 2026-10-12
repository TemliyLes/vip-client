<template>
  <section :aria-labelledby="labelledby" class="py-12 sm:py-24">
    <Container>
      <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <li v-for="item in data" :key="item.id" class="flex min-w-0 flex-col">
          <Card btn heading-tag="h2" :data="item" />
        </li>
      </ul>
    </Container>
  </section>
</template>

<script setup>
import Container from "../ui/Container.vue";
import Card from "../cards/Card.vue";
const props = defineProps({
  labelledby: { type: String, default: undefined },
  data: {
    type: Array,
    default: () => [],
  },
});
</script>
