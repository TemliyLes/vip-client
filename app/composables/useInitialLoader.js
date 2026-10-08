export const useInitialLoader = () => {
  const visible = useState("initial-loader:visible", () => true);
  const pageReady = useState("initial-loader:page-ready", () => false);
  const heroPending = useState("initial-loader:hero-pending", () => false);
  const ready = computed(() => pageReady.value && !heroPending.value);

  return { visible, pageReady, heroPending, ready };
};
