export const usePageStore = defineStore("page", () => {
  const page = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const { t } = useI18n({ useScope: 'global' });
  const config = useRuntimeConfig();

  async function fetchPage(id) {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/pages/${id}`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });

      page.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = t('errors.message1');
    } finally {
      loading.value = false;
    }
  }

  return {
    page,
    loading,
    error,
    fetchPage,
  };
});
