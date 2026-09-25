import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt"],
  runtimeConfig: {
    public: {
      apiBase: "https://vip-client.duckdns.org",
    },
  },
  css: ["~/assets/css/main.css", "~/assets/css/fonts.css"],
  vite: {
    plugins: [tailwindcss()],
  },
});
