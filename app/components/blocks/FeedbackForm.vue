<template>
  <div>
    <Header center class="mb-4">Odeslat požadavek</Header>
    <form class="flex flex-col gap-3" @submit.prevent="submit">
      <!-- Text -->
      <Input v-model="form.name" placeholder="Jméno" />

      <!-- Phone -->
      <Input phone v-model="form.phone" placeholder="Telefon" />

      <!-- Comment -->
      <textarea
        v-model="form.comment"
        class="w-full min-h-[140px] resize-none border border-gray-200 px-4 py-3 outline-none transition duration-300 focus:border-black"
        placeholder="Poznámka"
      />

      <Button type="submit" fit arrow> Odeslat </Button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from "vue";

import Input from "../ui/Input.vue";
import Button from "../ui/Button.vue";
import Header from "../ui/Header.vue";

const emit = defineEmits(["submit"]);

const form = reactive({
  name: "",
  phone: "",
  comment: "",
});

const submit = () => {
  emit("submit", {
    ...form,
  });
};
</script>
