export const usePostsStore = defineStore("posts", () => {
  const posts = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const { t, locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  let requestId = 0;

  watch(locale, () => {
    posts.value = [];
    error.value = null;
  });

  async function fetchPosts() {
    const language = locale.value;
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    posts.value = [];
    try {
      const response = await api.getList('posts', { per_page: 10 }, language);
      if (currentRequest === requestId && language === locale.value) posts.value = response;
      return response;
    } catch (err) {
      if (currentRequest === requestId && language === locale.value) {
        console.error(err);
        error.value = t('errors.message4');
      }
    } finally {
      if (currentRequest === requestId) loading.value = false;
    }
  }

  return { posts, loading, error, fetchPosts };
});
