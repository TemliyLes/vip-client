<template>
  <Button fit arrow v-if="to" :to="reservioURL">Rezrvovat Online</Button>
  <Button @click="openModal" fit arrow v-if="!to">Rezrvovat Online</Button>

  <Modal v-model="modalOpened">
    <FeedbackForm />
  </Modal>
</template>

<script setup>
import Button from "./Button.vue";
import Modal from "./Modal.vue";
import FeedbackForm from "../blocks/FeedbackForm.vue";
defineProps({
  url: {
    type: String,
  },
});
const prefix = "https://paliy-esthetic-clinic.reservio.com/services/";
const reservioURL = computed(() => `${prefix}${url}`);
const modalOpened = ref(false);
const openModal = () => {
  modalOpened.value = true;
};
</script>
