import { defineStore } from "pinia";

export const useMicronewsStore = defineStore("micronews", () => {
  const dataSource = ref(null);
  const data = useCmsContent(dataSource, 'news');

  const loading = ref(false);

  const error = ref(null);

  async function getData() {
    const config = useRuntimeConfig();

    loading.value = true;

    error.value = null;

    try {
      const response = await $fetch("/wp-json/wp/v2/news?news-categories=20", {
        baseURL: config.public.apiBase,
      });
      dataSource.value = response;
    } catch (err) {
      error.value = err;

      console.error("Ошибка загрузки категорий услуг:", err);
    } finally {
      loading.value = false;
    }
  }

  return {
    dataSource,
    data,

    loading,

    error,

    getData,
  };
});
