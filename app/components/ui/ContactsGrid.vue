<template>
  <div class="flex flex-col gap-6">
    <!-- Address -->
    <div class="flex items-start gap-4">
      <Marker class="shrink-0 mt-1" />

      <div class="flex flex-col gap-1">
        <Header mini> PALIY ESTHETIC CLINIC </Header>

        <Paragraph> NA SVIHANCE 1476/1, PRAHA 12000 </Paragraph>
      </div>
    </div>

    <!-- Working hours -->
    <div class="flex items-start gap-4">
      <Clock class="shrink-0 mt-1" />

      <Paragraph> PO - SO, 09:00 - 20:00 </Paragraph>
    </div>

    <!-- Phone -->
    <div class="flex items-start gap-4">
      <Phone class="shrink-0 mt-1" />

      <Paragraph> +420 608 214 640 </Paragraph>
    </div>

    <!-- Email -->
    <div class="flex items-start gap-4">
      <Mail class="shrink-0 mt-1" />

      <Paragraph> VIPPERMANENT.CZ@GMAIL.COM </Paragraph>
    </div>

    <!-- Button -->
    <Button class="mt-2"> REZERVOVAT ONLINE </Button>
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
