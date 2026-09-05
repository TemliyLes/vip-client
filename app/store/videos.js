export const useVideosStore = defineStore("videos", () => {
  const data = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const config = useRuntimeConfig();

  async function fetchData() {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/videos/`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });

      data.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = "Не удалось загрузить видео";
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
