import { validateFeedback, limitFeedbackText } from "../../app/utils/feedback.js";

// Same-origin endpoint works both in local Nuxt and behind the production proxy.
export default defineEventHandler(async (event) => {
  const body = await readBody(event);
  const text = (value) => typeof value === "string" ? value.trim() : "";
  const payload = {
    name: text(body?.name),
    phone: text(body?.phone),
    message: text(body?.message),
    service_id: Number(body?.service_id) || 0,
    language: text(body?.language),
    page_title: limitFeedbackText(text(body?.page_title), 200),
    page_url: text(body?.page_url),
  };
  if (Object.keys(validateFeedback(payload)).length ||
      !Number.isSafeInteger(payload.service_id) || payload.service_id < 0 ||
      !["cs", "sk"].includes(payload.language) ||
      payload.page_url.length > 2048 || !/^https?:\/\//i.test(payload.page_url)) {
    throw createError({ statusCode: 400, statusMessage: "Invalid feedback fields" });
  }

  // Retain the selected tariff in the message; it is not a separate WP resource.
  const selection = limitFeedbackText(text(body?.selection), 200);
  if (selection) {
    const combined = `${selection}\n\n${payload.message}`;
    // Preserve the user's full message if the combined text would exceed WP's limit.
    if (!validateFeedback({ ...payload, message: combined }).comment) payload.message = combined;
  }

  const config = useRuntimeConfig(event);
  try {
    return await $fetch("/wp-json/paliy/v1/feedback", {
      baseURL: config.public.apiBase,
      method: "POST",
      body: payload,
      retry: 0,
      timeout: 15000,
    });
  } catch (err) {
    throw createError({
      statusCode: err?.response?.status || 502,
      statusMessage: "Feedback request failed",
      data: { code: err?.data?.code || "feedback_unavailable" },
    });
  }
});
