import { defineStore } from "pinia";

export const useReviewsStore = defineStore("reviews", () => {
  const dataSource = ref(null);
  const data = useCmsContent(dataSource, 'reviews');
  const reviewSource = ref(null);
  const review = useCmsContent(reviewSource, 'reviews');
  const loading = ref(false);
  const error = ref(null);

  async function getData() {
    const config = useRuntimeConfig();

    loading.value = true;
    error.value = null;

    try {
      const response = await $fetch("/wp-json/wp/v2/reviews?per_page=100", {
        baseURL: config.public.apiBase,
      });

      dataSource.value = response;
    } catch (err) {
      error.value = err;
      console.error("Ошибка загрузки отзывов:", err);
    } finally {
      loading.value = false;
    }
  }

  async function getReviewById(id) {
    const config = useRuntimeConfig();

    loading.value = true;
    error.value = null;

    try {
      const response = await $fetch(
        `/wp-json/wp/v2/reviews?review-categories=${id}`,
        {
          baseURL: config.public.apiBase,
        },
      );

      reviewSource.value = response;
    } catch (err) {
      error.value = err;
      console.error("Ошибка загрузки отзыва:", err);
    } finally {
      loading.value = false;
    }
  }

  return {
    dataSource,
    data,
    reviewSource,
    review,
    loading,
    error,
    getData,
    getReviewById,
  };
});
