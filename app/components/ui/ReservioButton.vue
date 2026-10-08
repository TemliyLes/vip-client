<template>
  <Button fit arrow v-if="reservioURL" :to="reservioURL">{{
    $t("ui.components.ui.ReservioButton.buttonText1")
  }}</Button>
  <Button @click="openModal" fit arrow v-else>{{
    $t("ui.components.ui.ReservioButton.buttonText1")
  }}</Button>

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
const reservioURL = computed(() => {
  const value = props.url?.trim() || "";
  if (!value) return "";

  // WordPress URL fields store bare Reservio IDs with an http:// prefix.
  const serviceId = value.replace(/^https?:\/\//i, "");
  if (/^[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12}$/i.test(serviceId)) {
    return `${prefix}${serviceId}`;
  }

  return /^https?:\/\//i.test(value) ? value : `${prefix}${value}`;
});
const modalOpened = ref(false);
const openModal = () => {
  modalOpened.value = true;
};

const sendInfo = (item) => {
  console.log(item);
};
</script>
