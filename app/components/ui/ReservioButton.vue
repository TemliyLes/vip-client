<template>
  <Button v-if="to" :to="reservioURL">Rezrvovat Online</Button>
  <!-- <Button>Rezrvovat Online</Button> -->
</template>

<script setup>
import Button from "./Button.vue";
defineProps({
  url: {
    type: String,
  },
});
const prefix = "https://paliy-esthetic-clinic.reservio.com/services/";
const reservioURL = computed(() => `${prefix}${url}`);
</script>
