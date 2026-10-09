<template>
  <div>
    <Header mini center class="mb-6 pr-6">
      {{ $t('ui.components.blocks.FeedbackForm.headerText1') }}
      <span v-if="item?.name">{{ item.name }}</span>
    </Header>

    <div v-if="success" ref="confirmation" role="status" tabindex="-1" class="py-8 text-center outline-none">
      <p class="text-wine">{{ $t('feedback.success') }}</p>
    </div>

    <form v-else class="flex flex-col gap-4" novalidate :aria-busy="loading" @submit.prevent="submit">
      <div>
        <label :for="`${id}-name`" class="block mb-2 text-sm">
          {{ $t('ui.components.blocks.FeedbackForm.placeholder1') }} *
        </label>
        <Input :id="`${id}-name`" v-model="form.name" name="name" autocomplete="name" required maxlength="100"
          :disabled="loading" :aria-invalid="Boolean(fieldErrors.name)" :aria-describedby="fieldErrors.name ? `${id}-name-error` : undefined"
          :placeholder="$t('ui.components.blocks.FeedbackForm.placeholder1')" />
        <p v-if="fieldErrors.name" :id="`${id}-name-error`" class="mt-1 text-sm text-wine">{{ $t(fieldErrors.name) }}</p>
      </div>

      <div>
        <label :for="`${id}-phone`" class="block mb-2 text-sm">
          {{ $t('ui.components.blocks.FeedbackForm.placeholder2') }} *
        </label>
        <Input :id="`${id}-phone`" v-model="form.phone" name="phone" type="tel" autocomplete="tel" required maxlength="30"
          :disabled="loading" :aria-invalid="Boolean(fieldErrors.phone)" :aria-describedby="fieldErrors.phone ? `${id}-phone-error` : undefined"
          :placeholder="$t('ui.components.blocks.FeedbackForm.placeholder2')" />
        <p v-if="fieldErrors.phone" :id="`${id}-phone-error`" class="mt-1 text-sm text-wine">{{ $t(fieldErrors.phone) }}</p>
      </div>

      <div>
        <label :for="`${id}-comment`" class="block mb-2 text-sm">
          {{ $t('ui.components.blocks.FeedbackForm.placeholder3') }} *
        </label>
        <textarea :id="`${id}-comment`" v-model="form.comment" name="message" required maxlength="5000"
          :disabled="loading" :aria-invalid="Boolean(fieldErrors.comment)" :aria-describedby="fieldErrors.comment ? `${id}-comment-error` : undefined"
          class="w-full min-h-[140px] resize-y border border-gray-200 px-4 py-3 outline-none transition duration-300 focus:border-black"
          :placeholder="$t('ui.components.blocks.FeedbackForm.placeholder3')" />
        <p v-if="fieldErrors.comment" :id="`${id}-comment-error`" class="mt-1 text-sm text-wine">{{ $t(fieldErrors.comment) }}</p>
      </div>

      <p v-if="error" role="alert" class="text-sm text-wine">{{ $t(error) }}</p>
      <Button type="submit" :form="false" :disabled="loading" fit arrow>
        <template v-if="loading">{{ $t('feedback.sending') }}</template>
        <template v-else>{{ $t('ui.components.blocks.FeedbackForm.buttonText1') }}</template>
      </Button>
    </form>
  </div>
</template>

<script setup>
import { useId } from "vue";
import Input from "../ui/Input.vue";
import Button from "../ui/Button.vue";
import Header from "../ui/Header.vue";
import { useFeedbackStore } from "~/store/feedback.js";
import { feedbackErrors, validateFeedback, limitFeedbackText } from "~/utils/feedback.js";

const props = defineProps({ item: { type: Object, default: null } });
const id = useId();
const { locale } = useI18n({ useScope: "global" });
const feedbackStore = useFeedbackStore();
const form = reactive({ name: "", phone: "", comment: "" });
const attempted = ref(false);
const loading = ref(false);
const success = ref(false);
const error = ref("");
const confirmation = ref(null);
const fieldErrors = computed(() => attempted.value ? validateFeedback({
  name: form.name.trim(), phone: form.phone.trim(), message: form.comment.trim(),
}) : {});

const submit = async () => {
  if (loading.value) return;
  attempted.value = true;
  error.value = "";
  const invalid = Object.keys(fieldErrors.value)[0];
  if (invalid) {
    document.getElementById(`${id}-${invalid}`)?.focus({ preventScroll: true });
    return;
  }

  loading.value = true;
  try {
    await feedbackStore.sendFeedback({
      name: form.name.trim(),
      phone: form.phone.trim(),
      message: form.comment.trim(),
      // Tariffs have no WP ID: their parent service ID is supplied by Article.
      service_id: props.item?.service_id || 0,
      selection: props.item?.name || "",
      language: locale.value,
      page_title: limitFeedbackText(document.title, 200),
      page_url: window.location.href,
    });
    success.value = true;
    Object.assign(form, { name: "", phone: "", comment: "" });
    await nextTick();
    confirmation.value?.focus({ preventScroll: true });
  } catch (err) {
    error.value = feedbackErrors[err?.data?.data?.code || err?.data?.code] || "feedback.failed";
  } finally {
    loading.value = false;
  }
};
</script>
