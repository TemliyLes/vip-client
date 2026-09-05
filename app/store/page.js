export const usePageStore = defineStore("page", () => {
  const page = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const config = useRuntimeConfig();

  async function fetchPage(id) {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/pages/${id}`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });
      console.log(response);
      page.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = "Не удалось загрузить статьи";
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
