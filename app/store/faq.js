import { defineStore } from "pinia";

export const useFaqStore = defineStore("faq", () => {
  const all = ref([]);
  const byTag = ref({});
  const loading = ref(false);
  const error = ref(null);
  const { locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  const requests = new Map();
  let requestId = 0;

  watch(locale, () => {
    all.value = [];
    byTag.value = {};
    error.value = null;
  });

  async function fetchFaq(id) {
    const language = locale.value;
    const key = id ?? 'all';
    const currentRequest = ++requestId;
    requests.set(key, currentRequest);
    loading.value = true;
    error.value = null;
    try {
      const response = id == null
        ? await api.getList('faq', {}, language)
        : await api.getByTerm('faq', 'faq-tags', id, {}, language);
      if (requests.get(key) === currentRequest && language === locale.value) {
        if (id == null) all.value = response;
        else byTag.value[id] = response;
      }
      return response;
    } catch (err) {
      if (requests.get(key) === currentRequest && language === locale.value) error.value = err;
    } finally {
      if (requests.get(key) === currentRequest) requests.delete(key);
      loading.value = requests.size > 0;
    }
  }

  const getFaq = () => fetchFaq();
  const getFaqByTag = id => fetchFaq(id);
  return { all, byTag, loading, error, getFaq, getFaqByTag };
});
