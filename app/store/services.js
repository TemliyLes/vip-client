import { defineStore } from "pinia";

export const useServicesStore = defineStore("services", () => {
  const dataSource = ref(null);
  const data = useCmsContent(dataSource, 'service-categories');
  const serviceSource = ref(null);
  const service = useCmsContent(serviceSource, 'services');
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

      dataSource.value = response.filter(
        (item) => item?.meta?.service_category_is_primary,
      );
    } catch (err) {
      error.value = err;

      console.error("Ошибка загрузки категорий услуг:", err);
    } finally {
      loading.value = false;
    }
  }

  async function getServiceByCategory(id) {
    const config = useRuntimeConfig();

    loading.value = true;
    error.value = null;
    serviceSource.value = null;

    try {
      const response = await $fetch(
        `/wp-json/wp/v2/services?service-categories=${id}`,
        {
          baseURL: config.public.apiBase,
        },
      );

      return response;
    } catch (err) {
      error.value = err;
      console.error(err);
    } finally {
      loading.value = false;
    }
  }
  return {
    dataSource,
    data,
    loading,
    error,
    serviceSource,
    service,
    getData,
    getServiceByCategory,
  };
});
