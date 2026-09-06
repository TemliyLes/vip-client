export default defineNuxtPlugin((nuxtApp) => {
  const router = useRouter();

  if ("scrollRestoration" in history) {
    history.scrollRestoration = "manual";
  }

  router.beforeEach(() => {
    setTimeout(() => {
      window.scrollTo({
        top: 0,
        left: 0,
        behavior: "instant",
      });
    }, 600);

    return true;
  });
});
