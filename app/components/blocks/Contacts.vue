<template>
  <Container>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-8 my-12 sm:my-24">
      <div class="flex justify-between flex-col">
        <TitleBlock
          :header="$t('ui.components.blocks.Contacts.header1')"
          :title="$t('ui.components.blocks.Contacts.title1')"
          :description="$t('ui.components.blocks.Contacts.description1')"
        ></TitleBlock>

        <ContactsGrid />
      </div>

      <Map :address="$t('ui.components.blocks.Contacts.address1')" />
    </div>
  </Container>
</template>

<script setup>
import Map from "./Map.vue";
import TitleBlock from "../ui/TitleBlock.vue";
import ContactsGrid from "../ui/ContactsGrid.vue";
import Container from "../ui/Container.vue";
</script>
