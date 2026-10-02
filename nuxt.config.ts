import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt", "@nuxtjs/i18n"],
  i18n: {
    defaultLocale: "cs",
    strategy: "prefix_except_default",
    locales: [
      { code: "cs", language: "cs-CZ", name: "Čeština" },
      { code: "sk", language: "sk-SK", name: "Slovenčina" },
    ],
    vueI18n: "./i18n.config.ts",
    detectBrowserLanguage: {
      useCookie: true,
      cookieKey: "vip_locale",
      redirectOn: "root",
      fallbackLocale: "cs",
    },
  },
  runtimeConfig: {
    public: {
      apiBase: "http://srv1943597.hstgr.cloud:8080",
    },
  },
  css: ["~/assets/css/main.css", "~/assets/css/fonts.css"],
  vite: {
    plugins: [tailwindcss()],
  },
});
