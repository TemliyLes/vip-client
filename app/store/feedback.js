// app/stores/feedback.js
import { defineStore } from "pinia";

export const useFeedbackStore = defineStore("feedback", () => {
  const { t } = useI18n({ useScope: 'global' });
  const loading = ref(false);
  const error = ref(null);
  const success = ref(false);

  const sendFeedback = async (payload) => {
    const config = useRuntimeConfig();

    loading.value = true;
    error.value = null;
    success.value = false;

    try {
      const response = await $fetch("/wp-json/paliy/v1/feedback", {
        method: "POST",
        body: {
          name: "1321",
          phone: "1321",
          comment: "1321",
          service_id: "1321",
          language: "1321",
          page_title: "1321",
          page_url: "1321",
        },
      });

      success.value = true;

      return response;
    } catch (err) {
      error.value =
        err?.data?.message || err?.message || t('errors.message5');

      throw err;
    } finally {
      loading.value = false;
    }
  };

  const reset = () => {
    loading.value = false;
    error.value = null;
    success.value = false;
  };

  return {
    loading,
    error,
    success,
    sendFeedback,
    reset,
  };
});
