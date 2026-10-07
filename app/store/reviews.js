import { defineStore } from "pinia";

export const useReviewsStore = defineStore("reviews", () => {
  const data = ref([]);
  const review = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const { locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  const requests = new Map();
  let requestId = 0;

  watch(locale, () => {
    data.value = [];
    review.value = [];
    error.value = null;
  });

  async function fetchReviews(id) {
    const language = locale.value;
    const key = id ?? 'all';
    const currentRequest = ++requestId;
    requests.set(key, currentRequest);
    loading.value = true;
    error.value = null;
    try {
      const response = id == null
        ? await api.getList('reviews', { per_page: 100 }, language)
        : await api.getByTerm('reviews', 'review-categories', id, {}, language);
      if (requests.get(key) === currentRequest && language === locale.value) {
        if (id == null) data.value = response;
        else review.value = response;
      }
      return response;
    } catch (err) {
      if (requests.get(key) === currentRequest && language === locale.value) {
        error.value = err;
        console.error(err);
      }
    } finally {
      if (requests.get(key) === currentRequest) requests.delete(key);
      loading.value = requests.size > 0;
    }
  }

  const getData = () => fetchReviews();
  const getReviewById = id => fetchReviews(id);
  return { data, review, loading, error, getData, getReviewById };
});
