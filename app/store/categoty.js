export const useCategoryStore = defineStore("category", () => {
  const category = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const config = useRuntimeConfig();

  async function fetchCategory(id) {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/services?service-categories=${id}&per_page=100`;

      const responce = await $fetch(url, {
        baseURL: config.public.apiBase,
      });
      category.value = responce;
    } catch (err) {
      console.error(err);
      error.value = "Не удалось загрузить категорию";
    } finally {
      loading.value = false;
    }
  }

  return {
    category,
    loading,
    error,
    fetchCategory,
  };
});
