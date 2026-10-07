import { defineStore } from "pinia";

export const useServicesStore = defineStore("services", () => {
  const data = ref(null);
  const categories = ref([]);
  const service = ref(null);
  const loading = ref(false);

  const error = ref(null);
  const { locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  const pendingCategories = new Map();

  watch(locale, () => {
    data.value = null;
    categories.value = [];
    service.value = null;
    error.value = null;
  });

  async function getData() {
    const language = locale.value;
    if (pendingCategories.has(language)) return pendingCategories.get(language);

    loading.value = true;

    error.value = null;

    const pending = (async () => {
      try {
        const response = await api.get('service-categories', {
          per_page: 100,
          hide_empty: true,
        }, language);

        if (language !== locale.value) return;
        categories.value = response;
        data.value = response.filter(
          (item) => item?.meta?.service_category_is_primary,
        );
        return data.value;
      } catch (err) {
        if (language === locale.value) {
          error.value = err;
          console.error("Ошибка загрузки категорий услуг:", err);
        }
      } finally {
        pendingCategories.delete(language);
        if (language === locale.value) loading.value = false;
      }
    })();
    pendingCategories.set(language, pending);
    return pending;
  }

  async function getServiceByCategory(id) {
    const language = locale.value;

    loading.value = true;
    error.value = null;
    service.value = null;

    try {
      const response = await api.servicesByCategory(id, language);

      return response;
    } catch (err) {
      if (language === locale.value) {
        error.value = err;
        console.error(err);
      }
    } finally {
      if (language === locale.value) loading.value = false;
    }
  }
  return {
    data,
    categories,
    loading,
    error,
    service,
    getData,
    getServiceByCategory,
  };
});
