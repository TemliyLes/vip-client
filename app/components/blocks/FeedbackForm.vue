<template>
  <div>
    <Header mini center class="mb-4"
      >{{ $t('ui.components.blocks.FeedbackForm.headerText1') }}<span v-if="item">{{ item?.name }}</span></Header
    >
    <form class="flex flex-col gap-3" @submit.prevent="submit">
      <!-- Text -->
      <Input v-model="form.name" :placeholder="$t('ui.components.blocks.FeedbackForm.placeholder1')" />

      <!-- Phone -->
      <Input phone v-model="form.phone" :placeholder="$t('ui.components.blocks.FeedbackForm.placeholder2')" />

      <!-- Comment -->
      <textarea
        v-model="form.comment"
        class="w-full min-h-[140px] resize-none border border-gray-200 px-4 py-3 outline-none transition duration-300 focus:border-black"
        :placeholder="$t('ui.components.blocks.FeedbackForm.placeholder3')"
      />

      <Button @click="submitForm" fit arrow>{{ $t('ui.components.blocks.FeedbackForm.buttonText1') }}</Button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from "vue";

import Input from "../ui/Input.vue";
import Button from "../ui/Button.vue";
import Header from "../ui/Header.vue";
import { useFeedbackStore } from "~/store/feedback.js";

const props = defineProps({
  item: {
    type: Object,
  },
});

const emit = defineEmits(["submit"]);

const submit = () => {
  emit("submit", {
    ...form,
  });
};

const feedbackStore = useFeedbackStore();

const form = reactive({
  name: "",
  phone: "",
  email: "",
  message: "",
});

const submitForm = async () => {
  try {
    await feedbackStore.sendFeedback(form);

    Object.assign(form, {
      name: "",
      phone: "",
      email: "",
      message: "123123",
      // message: props?.item?.title?.rendered,
    });
  } catch (error) {
    console.error(error);
  }
};
</script>
