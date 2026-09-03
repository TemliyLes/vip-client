<template>
  <div class="py-20">
    <Container>
      <div class="flex gap-4 items-stretch">
        <div class="basis-1/2 min-w-0 flex flex-col justify-between">
          <Title> Proč my </Title>

          <Header>
            Když záleží na
            <br />
            každém detailu
          </Header>

          <Paragraph>
            Individuální přístup, moderní technologie a přirozené výsledky.
            Každou proceduru provádíme s důrazem na bezpečnost, preciznost a
            respekt k vaší přirozené kráse.
          </Paragraph>

          <img
            class="h-24 object-contain object-left"
            src="./../../assets/img/styletext.png"
            alt=""
          />

          <Button> Rezervovat Online </Button>
        </div>

        <div class="basis-1/2 min-w-0 flex flex-col gap-3 overflow-hidden">
          <div v-for="item in data" ref="cards" :key="item?.id">
            <MicroCard :data="item" />
          </div>
        </div>
      </div>
    </Container>
  </div>
</template>

<script setup>
import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Button from "../ui/Button.vue";
import MicroCard from "../cards/MicroCard.vue";

import { useMicronewsStore } from "~/store/micronews.js";
const cards = ref([]);
const { revealOnScroll } = useGsap();

const store = useMicronewsStore();

const { data } = storeToRefs(store);

onMounted(async () => {
  await store.getData();

  await nextTick();

  revealOnScroll(cards.value);
});
</script>
