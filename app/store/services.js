import { defineStore } from "pinia";

export const useServicesStore = defineStore("services", () => {
  const data = ref(null);

  const loading = ref(false);

  const error = ref(null);

  async function getData() {
    const config = useRuntimeConfig();

    loading.value = true;

    error.value = null;

    try {
      const response = await $fetch("/wp-json/wp/v2/service-categories", {
        baseURL: config.public.apiBase,
      });
      console.log(response);
      data.value = response.filter(
        (item) => item?.meta?.service_category_is_primary,
      );
    } catch (err) {
      error.value = err;

      console.error("Ошибка загрузки категорий услуг:", err);
    } finally {
      loading.value = false;
    }
  }

  return {
    data,

    loading,

    error,

    getData,
  };
});
