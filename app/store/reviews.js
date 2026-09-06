import { defineStore } from "pinia";

export const useReviewsStore = defineStore("reviews", () => {
  const data = ref(null);
  const review = ref(null);
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

      data.value = response;
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

      review.value = response;
    } catch (err) {
      error.value = err;
      console.error("Ошибка загрузки отзыва:", err);
    } finally {
      loading.value = false;
    }
  }

  return {
    data,
    review,
    loading,
    error,
    getData,
    getReviewById,
  };
});
