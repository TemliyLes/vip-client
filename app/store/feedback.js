import { defineStore } from "pinia";

export const useFeedbackStore = defineStore("feedback", () => {
  const sendFeedback = async (payload) => {
    const response = await $fetch("/api/feedback", {
      method: "POST",
      body: payload,
      retry: 0,
      timeout: 20000,
    });
    if (response?.success !== true || !response.id) {
      throw new Error("Invalid feedback response");
    }
    return response;
  };

  return { sendFeedback };
});
