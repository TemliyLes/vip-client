export const usePostsStore = defineStore("posts", () => {
  const postsSource = ref([]);
  const posts = useCmsContent(postsSource, 'posts');
  const loading = ref(false);
  const error = ref(null);

  const { t } = useI18n({ useScope: 'global' });
  const config = useRuntimeConfig();

  async function fetchPosts() {
    loading.value = true;
    error.value = null;

    try {
      postsSource.value = await $fetch("/wp-json/wp/v2/posts", {
        baseURL: config.public.apiBase,
        query: {
          per_page: 10,
        },
      });
    } catch (err) {
      console.error(err);
      error.value = t('errors.message4');
    } finally {
      loading.value = false;
    }
  }

  return {
    postsSource,
    posts,
    loading,
    error,
    fetchPosts,
  };
});
