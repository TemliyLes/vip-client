export const usePostsStore = defineStore("posts", () => {
  const posts = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const config = useRuntimeConfig();

  async function fetchPosts() {
    loading.value = true;
    error.value = null;

    try {
      posts.value = await $fetch("/wp-json/wp/v2/posts", {
        baseURL: config.public.apiBase,
        query: {
          per_page: 10,
        },
      });
    } catch (err) {
      console.error(err);
      error.value = "Не удалось загрузить записи";
    } finally {
      loading.value = false;
    }
  }

  return {
    posts,
    loading,
    error,
    fetchPosts,
  };
});
