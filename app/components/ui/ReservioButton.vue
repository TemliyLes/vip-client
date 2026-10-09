<template>
  <Button fit arrow v-if="reservioURL" :to="reservioURL">{{
    $t("ui.components.ui.ReservioButton.buttonText1")
  }}</Button>
  <Button :form="false" @click="openModal" fit arrow v-else>{{
    $t("ui.components.ui.ReservioButton.buttonText1")
  }}</Button>
</template>

<script setup>
import Button from "./Button.vue";
const props = defineProps({
  url: {
    type: String,
  },
  item: {
    type: Object,
  },
  serviceId: { type: Number, default: 0 },
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
const { open } = useFeedbackModal();
const openModal = () => {
  open({ ...props.item, service_id: props.serviceId || props.item?.id || 0 });
};
</script>
