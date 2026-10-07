<template>
  <div class="flex flex-col gap-6 sm:mt-0 mt-6">
    <!-- Address -->
    <div class="flex items-start gap-4">
      <Marker class="shrink-0 mt-1" />

      <div class="flex flex-col gap-1">
        <Header mini>{{ $t('ui.components.ui.ContactsGrid.headerText1') }}</Header>

        <Paragraph>{{ $t('ui.components.ui.ContactsGrid.paragraphText1') }}</Paragraph>
      </div>
    </div>

    <!-- Working hours -->
    <div class="flex items-start gap-4">
      <Clock class="shrink-0 mt-1" />

      <Paragraph>{{ $t('ui.components.ui.ContactsGrid.paragraphText2') }}</Paragraph>
    </div>

    <!-- Phone -->
    <div class="flex items-start gap-4">
      <Phone class="shrink-0 mt-1" />

      <Paragraph>{{ $t('ui.components.ui.ContactsGrid.paragraphText3') }}</Paragraph>
    </div>

    <!-- Email -->
    <div class="flex items-start gap-4">
      <Mail class="shrink-0 mt-1" />

      <Paragraph>{{ $t('ui.components.ui.ContactsGrid.paragraphText4') }}</Paragraph>
    </div>

    <!-- Button -->
    <Button class="mt-2">{{ $t('ui.components.ui.ContactsGrid.buttonText1') }}</Button>
  </div>
</template>

<script setup>
import Marker from "../icons/mini/marker.vue";
import Clock from "../icons/mini/clock.vue";
import Phone from "../icons/mini/phone.vue";
import Mail from "../icons/mini/mail.vue";

import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Button from "../ui/Button.vue";
</script>
