<template>
  <AlterHero />
  <Container v-if="title && description" class="-mb-12">
    <Center>
      <Header class="mt-12" v-if="title">{{ title }}</Header>
      <Paragraph class="mt-6" v-if="description">{{ description }}</Paragraph>
    </Center>
  </Container>
  <Category :data="categoryStore.category" />
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import Paragraph from "~/components/ui/Paragraph.vue";
import { useCategoryStore } from "~/store/category";
import Category from "~/components/blocks/Category.vue";
import Header from "~/components/ui/Header.vue";
import Container from "~/components/ui/Container.vue";

const categoryStore = useCategoryStore();
const route = useRoute();

const table = [
  {
    id: 14,
    title: "Kosmetologie",
    description:
      "Objevte profesionální kosmetologickou péči zaměřenou na zdraví, krásu a přirozený vzhled vaší pokožky. Nabízíme moderní kosmetologické procedury přizpůsobené individuálním potřebám klientů, které pomáhají zlepšit stav pleti, podpořit její regeneraci a navrátit jí svěžest a vitalitu.",
  },
  {
    id: 15,
    title: "Školení",
    description:
      "Nabízíme profesionální školení zaměřená na moderní kosmetologické metody a praktické dovednosti v oblasti péče o pleť. Naše kurzy jsou určeny pro začátečníky i zkušené specialisty, kteří chtějí rozšířit své znalosti, osvojit si nové techniky a získat jistotu při práci s klienty pod vedením zkušených odborníků.",
  },
];

const currentCategory = computed(() => {
  return table.find((e) => e.id === Number(route.params.id));
});

const title = computed(() => currentCategory.value?.title);

const description = computed(() => currentCategory.value?.description);

watch(
  () => route.params.id,
  async (id) => {
    await categoryStore.fetchCategory(id);
  },
  {
    immediate: true,
  },
);
</script>
