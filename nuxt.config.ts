import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt", "@nuxtjs/i18n"],
  nitro: {
    externals: {
      // Bundle this local helper; external dev imports get invalid paths on Windows.
      inline: [/[/\\]i18n[/\\]utils\.js$/],
    },
  },
  i18n: {
    defaultLocale: "cs",
    strategy: "prefix_except_default",
    locales: [
      { code: "cs", language: "cs-CZ", name: "Čeština" },
      { code: "sk", language: "sk-SK", name: "Slovenčina" },
    ],
    vueI18n: "./i18n.config.ts",
    // Keep the public entry in Czech, including visitors with an old SK cookie.
    // Manual switching still works when LanguageSwitcher is uncommented.
    detectBrowserLanguage: false,
  },
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
