export function useWpApi() {
  const config = useRuntimeConfig();
  const { $i18n } = useNuxtApp();

  function request(resource, query, language) {
    return $fetch(`/wp-json/wp/v2/${resource}`, {
      baseURL: config.public.apiBase,
      query: { ...query, ...(language ? { lang: language } : {}) },
    });
  }

  function get(resource, query = {}, language = $i18n.locale.value) {
    return request(resource, query, language);
  }

  async function getList(resource, query = {}, language = $i18n.locale.value) {
    const items = await get(resource, query, language);
    return items.filter(item => item.lang === language);
  }

  async function getItem(resource, id, language = $i18n.locale.value) {
    const item = await get(`${resource}/${id}`, {}, language === 'cs' ? null : language);
    if (item.lang === language) return item;
    const targetId = item.translations?.[language];
    return targetId ? get(`${resource}/${targetId}`, {}, language) : null;
  }

  async function translatedId(resource, id, language = $i18n.locale.value) {
    const item = await get(`${resource}/${id}`, {
      _fields: 'id,lang,translations',
    }, language);

    return item.translations?.[language]
      ?? (item.lang === language ? item.id : null);
  }

  async function servicesByCategory(id, language = $i18n.locale.value) {
    const categoryId = await translatedId('service-categories', id, language);
    if (!categoryId) return [];

    return getList('services', {
      'service-categories': categoryId,
      per_page: 100,
    }, language);
  }

  async function getByTerm(resource, taxonomy, id, query = {}, language = $i18n.locale.value) {
    const termId = language === 'cs' ? id : await translatedId(taxonomy, id, language);
    if (!termId) return [];
    return getList(resource, { ...query, [taxonomy]: termId }, language);
  }

  return { get, getList, getItem, getByTerm, translatedId, servicesByCategory };
}
