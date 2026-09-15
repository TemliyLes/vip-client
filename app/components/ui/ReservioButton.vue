<template>
  <Button fit arrow v-if="url" :to="reservioURL">Rezrvovat Online</Button>
  <Button @click="openModal" fit arrow v-if="!url">Rezrvovat Online</Button>

  <Modal v-model="modalOpened">
    <FeedbackForm @submit="sendInfo" :item="item" />
  </Modal>
</template>

<script setup>
import Button from "./Button.vue";
import Modal from "./Modal.vue";
import FeedbackForm from "../blocks/FeedbackForm.vue";
const props = defineProps({
  url: {
    type: String,
  },
  item: {
    type: Object,
  },
});
const prefix = "https://paliy-esthetic-clinic.reservio.com/services/";
const reservioURL = computed(() => `${prefix}${props?.url}`);
const modalOpened = ref(false);
const openModal = () => {
  modalOpened.value = true;
};

const sendInfo = (item) => {
  console.log(item);
};
</script>
