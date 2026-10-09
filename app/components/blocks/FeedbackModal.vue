<template>
  <Modal v-model="visible" :label="$t('ui.components.blocks.FeedbackForm.headerText1')">
    <FeedbackForm :key="session" :item="item" />
  </Modal>
</template>

<script setup>
import Modal from "../ui/Modal.vue";
import FeedbackForm from "./FeedbackForm.vue";

const { visible, item, session, close } = useFeedbackModal();
const route = useRoute();
watch(() => route.fullPath, close);
</script>
