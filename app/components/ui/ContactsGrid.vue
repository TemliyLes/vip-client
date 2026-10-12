<template>
  <div class="flex flex-col gap-6 sm:mt-0 mt-6">
    <ul class="flex flex-col gap-6">
      <!-- Address -->
      <li class="flex items-start gap-4">
        <Marker aria-hidden="true" class="shrink-0 mt-1" />

        <div class="flex flex-col gap-1">
          <Header tag="p" mini>{{ $t('ui.components.ui.ContactsGrid.headerText1') }}</Header>

          <Paragraph tag="address" class="not-italic">{{ $t('ui.components.ui.ContactsGrid.paragraphText1') }}</Paragraph>
        </div>
      </li>

      <!-- Working hours -->
      <li class="flex items-start gap-4">
        <Clock aria-hidden="true" class="shrink-0 mt-1" />

        <Paragraph>{{ $t('ui.components.ui.ContactsGrid.paragraphText2') }}</Paragraph>
      </li>

      <!-- Phone -->
      <li class="flex items-start gap-4">
        <Phone aria-hidden="true" class="shrink-0 mt-1" />

        <Paragraph tag="address" class="not-italic">
          <a :href="`tel:${$t('ui.components.ui.ContactsGrid.paragraphText3').replace(/[^\d+]/g, '')}`">{{ $t('ui.components.ui.ContactsGrid.paragraphText3') }}</a>
        </Paragraph>
      </li>

      <!-- Email -->
      <li class="flex items-start gap-4">
        <Mail aria-hidden="true" class="shrink-0 mt-1" />

        <Paragraph tag="address" class="not-italic">
          <a :href="`mailto:${$t('ui.components.ui.ContactsGrid.paragraphText4').trim()}`">{{ $t('ui.components.ui.ContactsGrid.paragraphText4') }}</a>
        </Paragraph>
      </li>
    </ul>

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
