<template>
  <div class="py-20">
    <Container>
      <div class="grid grid-cols-4 gap-4">
        <div v-for="item in data" :key="item.id" class="min-w-0">
          <!-- <Header center>{{ item.title.rendered }}</Header>
        <Paragraph>{{ item.service_fields.description }}</Paragraph> -->
          <Card btn :data="item" />
        </div>
      </div>
    </Container>
  </div>
</template>

<script setup>
import Container from "../ui/Container.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Card from "../cards/Card.vue";
const props = defineProps({
  data: {
    type: Object,
  },
});
</script>
