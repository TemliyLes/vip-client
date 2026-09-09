<template>
  <div class="mt-12 sm:mt-24">
    <Container>
      <div class="flex flex-col gap-4 items-center">
        <Title>Propagace</Title>
        <Header class="text-center"
          >Je ten správný čas udělat<br />něco dobrého pro sebe</Header
        >
        <Paragraph class="text-center"
          >Objevte aktuální nabídky PALIY ESTHETIC CLINIC.<br />Ponuky jsou
          časově omezeny a mohou se týkat vybraných procedur nebo
          termínů.</Paragraph
        >
      </div>

      <div class="grid sm:grid-cols-4 grid-cols-1 gap-3 mt-6">
        <div v-for="item in data" :key="item.id">
          <Card desc :data="item" />
        </div>
      </div>
    </Container>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Paragraph from "../ui/Paragraph.vue";
import { useServicesStore } from "~/store/services.js";
import Card from "../cards/Card.vue";

const store = useServicesStore();
const data = ref(null);
onMounted(async () => {
  data.value = await store?.getServiceByCategory(47);
});
</script>
