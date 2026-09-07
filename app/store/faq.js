import { defineStore } from "pinia";

export const useFaqStore = defineStore("faq", () => {
  const all = ref([]);
  const byTag = ref({});

  const loading = ref(false);
  const error = ref(null);

  async function getFaq() {
    const config = useRuntimeConfig();

    loading.value = true;

    try {
      const response = await $fetch("/wp-json/wp/v2/faq", {
        baseURL: config.public.apiBase,
      });

      all.value = response;

      return response;
    } catch (err) {
      error.value = err;
    } finally {
      loading.value = false;
    }
  }

  async function getFaqByTag(id) {
    const config = useRuntimeConfig();

    loading.value = true;

    try {
      const response = await $fetch(`/wp-json/wp/v2/faq?faq-tags=${id}`, {
        baseURL: config.public.apiBase,
      });

      byTag.value[id] = response;

      return response;
    } catch (err) {
      error.value = err;
    } finally {
      loading.value = false;
    }
  }

  return {
    all,
    byTag,
    loading,
    error,
    getFaq,
    getFaqByTag,
  };
});
