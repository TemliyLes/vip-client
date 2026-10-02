import { defineStore } from "pinia";

export const useFaqStore = defineStore("faq", () => {
  const allSource = ref([]);
  const all = useCmsContent(allSource, 'faq');
  const byTagSource = ref({});
  const byTag = useCmsContent(byTagSource, 'faq');

  const loading = ref(false);
  const error = ref(null);

  async function getFaq() {
    const config = useRuntimeConfig();

    loading.value = true;

    try {
      const response = await $fetch("/wp-json/wp/v2/faq", {
        baseURL: config.public.apiBase,
      });

      allSource.value = response;

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

      byTagSource.value[id] = response;

      return response;
    } catch (err) {
      error.value = err;
    } finally {
      loading.value = false;
    }
  }

  return {
    allSource,
    all,
    byTagSource,
    byTag,
    loading,
    error,
    getFaq,
    getFaqByTag,
  };
});
