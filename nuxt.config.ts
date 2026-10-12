import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  modules: ["@pinia/nuxt", "@nuxtjs/i18n"],
  app: {
    head: {
      link: [
        { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
        { rel: "icon", type: "image/png", sizes: "32x32", href: "/favicon-32x32.png" },
        { rel: "icon", type: "image/png", sizes: "16x16", href: "/favicon-16x16.png" },
        { rel: "apple-touch-icon", sizes: "180x180", href: "/apple-touch-icon.png" },
        { rel: "manifest", href: "/site.webmanifest" },
      ],
    },
  },
  nitro: {
    externals: {
      // Bundle local helpers shared with the server: external dev imports get invalid paths on Windows.
      inline: [
        /[/\\]i18n[/\\]utils\.js$/,
        /[/\\]app[/\\]utils[/\\]feedback\.js$/,
      ],
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
