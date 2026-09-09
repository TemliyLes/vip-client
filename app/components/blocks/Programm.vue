<template>
  <Container class="py-12 sm:py-24">
    <div class="flex justify-between items-center">
      <div class="flex flex-col gap-4">
        <Title>AKADEMIE</Title>
        <Header>
          Zkušenosti, které mají hodnotu,<br />když je můžete prodávat dál
        </Header>
        <Paragraph class="max-w-[650px]">
          PALIY Academy je prostor pro ty, kteří chtějí zahájit svou kariéru v
          permanentním make-upu nebo přesunout své dovednosti na vyšší
          úroveň.<br />Na kurzech se soustředíme nejen na techniku, ale také na
          práci s klientem, správný postup, hygienu, detail a přirozený
          výsledek.
        </Paragraph>
      </div>
      <img
        class="h-36 mr-6 mt-4 hidden sm:block"
        src="../../assets/img/styletext2.png"
        alt=""
      />
    </div>
    <div class="grid sm:grid-cols-3 grid-cols-1 gap-3 mt-6">
      <Card v-for="item in data" :key="item.id" :data="item" />
    </div>
  </Container>
</template>

<script setup>
import { useServicesStore } from "~/store/services";
import Card from "../cards/Card.vue";
import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
const store = useServicesStore();
const data = ref(null);
onMounted(async () => {
  data.value = await store.getServiceByCategory(45);
});
</script>
