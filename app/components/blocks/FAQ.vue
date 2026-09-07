<template>
  <div class="mt-24">
    <Container>
      <div class="flex flex-col gap-4 items-center">
        <Title>FAQ</Title>
        <Header class="text-center">Často kladené dotazy</Header>
        <Paragraph class="text-center">
          Zde naleznete odpovědi na nejčastěji kladené otázky.
        </Paragraph>
      </div>
      <Faq :data="store.all"></Faq>
    </Container>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Title from "../ui/Title.vue";
import Paragraph from "../ui/Paragraph.vue";
import Container from "../ui/Container.vue";
import { useFaqStore } from "~/store/faq.js";
import Faq from "../ui/Faq.vue";
const store = useFaqStore();

onMounted(() => {
  store?.getFaq();
});
</script>
