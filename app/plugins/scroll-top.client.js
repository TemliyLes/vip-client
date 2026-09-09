export default defineNuxtPlugin(() => {
  if ("scrollRestoration" in history) {
    history.scrollRestoration = "manual";
  }
});
