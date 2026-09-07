<template>
  <Container>
    <div class="grid grid-cols-2 gap-8 mt-24">
      <div class="flex justify-between flex-col">
        <TitleBlock
          header="Najdete nás v centru Prahy"
          title="Kontaktní informace"
          description="Navštivte PALIY ESTHETIC CLINIC a dopřejte si profesionální péči v příjemném a moderním prostředí."
        ></TitleBlock>

        <ContactsGrid />
      </div>

      <Map address="Na Švihance 1476/1, Praha 12000" />
    </div>
  </Container>
</template>

<script setup>
import Map from "./Map.vue";
import TitleBlock from "../ui/TitleBlock.vue";
import ContactsGrid from "../ui/ContactsGrid.vue";
import Container from "../ui/Container.vue";
</script>
