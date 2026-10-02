export const useVideosStore = defineStore("videos", () => {
  const dataSource = ref([]);
  const data = useCmsContent(dataSource, 'videos');
  const loading = ref(false);
  const error = ref(null);

  const { t } = useI18n({ useScope: 'global' });
  const config = useRuntimeConfig();

  async function fetchData() {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/videos/`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });

      dataSource.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = t('errors.message3');
    } finally {
      loading.value = false;
    }
  }

  return {
    dataSource,
    data,
    loading,
    error,
    fetchData,
  };
});
