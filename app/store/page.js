export const usePageStore = defineStore("page", () => {
  const pageSource = ref([]);
  const page = useCmsContent(pageSource, 'pages');
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

      pageSource.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = t('errors.message1');
    } finally {
      loading.value = false;
    }
  }

  return {
    pageSource,
    page,
    loading,
    error,
    fetchPage,
  };
});
