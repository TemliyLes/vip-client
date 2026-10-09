import { defineStore } from "pinia";
import { decodeWpText } from "~/utils/decodeWpText";

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

  async function fetchFaq(id, language = locale.value) {
    const key = `${language}:${id ?? 'all'}`;
    const currentRequest = ++requestId;
    requests.set(key, currentRequest);
    loading.value = true;
    error.value = null;
    try {
      const response = id == null
        ? await api.getList('faq', { per_page: 100 }, language)
        : await api.getByTerm('faq', 'faq-tags', id, { per_page: 100 }, language);
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

  const getFaq = async (language = locale.value) => await fetchFaq(undefined, language) ?? [];
  const getFaqByTag = async (id, language = locale.value) => await fetchFaq(id, language) ?? [];

  function normalizeName(value) {
    return decodeWpText(value).normalize('NFC').trim().replace(/\s+/g, ' ').toLowerCase();
  }

  async function getFaqForCategory(category, language = locale.value) {
    try {
      // Match the Czech source names, then follow Polylang links for the chosen language.
      // Category and FAQ-tag IDs belong to separate taxonomies and must not be equated.
      const sourceId = category?.translations?.cs;
      const source = language !== 'cs' && sourceId
        ? await api.getItem('service-categories', sourceId, 'cs')
        : category;

      if (source?.name) {
        const tags = await api.getList('faq-tags', {
          search: decodeWpText(source.name).trim(),
          per_page: 100,
        }, source.lang || language);
        const tag = tags.find(item => normalizeName(item.name) === normalizeName(source.name));

        if (tag) {
          const questions = await getFaqByTag(tag.id, language);
          if (questions.length) return questions;
        }
      }
    } catch (err) {
      if (language === locale.value) error.value = err;
    }

    // The shared pool is the same published FAQ list shown on the home page.
    return getFaq(language);
  }

  return { all, byTag, loading, error, getFaq, getFaqByTag, getFaqForCategory };
});
