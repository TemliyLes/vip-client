export const usePageStore = defineStore("page", () => {
  const page = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const { t, locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  const pending = new Map();
  let requestId = 0;

  watch(locale, () => {
    page.value = null;
    error.value = null;
  });

  async function fetchPage(id) {
    const language = locale.value;
    const key = `${language}:${id}`;
    if (pending.has(key)) return pending.get(key);
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    page.value = null;

    const task = (async () => {
      try {
        const response = await api.getItem('pages', id, language);
        if (currentRequest === requestId && language === locale.value) page.value = response;
        return response;
      } catch (err) {
        if (currentRequest === requestId && language === locale.value) {
          console.error(err);
          error.value = t('errors.message1');
        }
      } finally {
        pending.delete(key);
        if (currentRequest === requestId) loading.value = false;
      }
    })();
    pending.set(key, task);
    return task;
  }

  return {
    page,
    loading,
    error,
    fetchPage,
  };
});
