export const useNewsStore = defineStore("news", () => {
  const data = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const config = useRuntimeConfig();

  async function fetchData(id) {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/news/${id}`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });

      data.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = "Не удалось загрузить статьи";
    } finally {
      loading.value = false;
    }
  }

  return {
    data,
    loading,
    error,
    fetchData,
  };
});
