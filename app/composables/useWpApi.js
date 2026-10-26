export function useWpApi() {
  const config = useRuntimeConfig();
  const { $i18n } = useNuxtApp();

  function request(resource, query, language, raw = false) {
    const fetch = raw ? $fetch.raw : $fetch;
    return fetch(`/wp-json/wp/v2/${resource}`, {
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

  async function getPage(resource, query = {}, language = $i18n.locale.value) {
    const response = await request(resource, query, language, true);
    return {
      items: response._data.filter(item => item.lang === language),
      page: Number(query.page ?? 1),
      totalPages: Number(response.headers.get('X-WP-TotalPages') ?? 1),
    };
  }

  async function getItem(resource, id, language = $i18n.locale.value, query = {}) {
    const item = await get(`${resource}/${id}`, query, language === 'cs' ? null : language);
    if (item.lang === language) return item;
    const targetId = item.translations?.[language];
    return targetId ? get(`${resource}/${targetId}`, query, language) : null;
  }

  async function getItemBySlug(resource, slug, language = $i18n.locale.value, query = {}) {
    const normalizedSlug = String(slug ?? '').trim();
    if (!normalizedSlug) return null;

    const items = await getList(resource, {
      ...query,
      slug: normalizedSlug,
      per_page: 1,
    }, language);
    return items[0] ?? null;
  }

  async function translatedId(resource, id, language = $i18n.locale.value) {
    const item = await get(`${resource}/${id}`, {
      _fields: 'id,lang,translations',
    }, language);

    return item.translations?.[language]
      ?? (item.lang === language ? item.id : null);
  }

  async function translatedSlug(resource, slug, fromLanguage, toLanguage) {
    const item = await getItemBySlug(resource, slug, fromLanguage, {
      _fields: 'id,slug,lang,translations',
    });
    const targetId = item?.translations?.[toLanguage];
    if (!targetId) return null;

    const translated = await get(`${resource}/${targetId}`, {
      _fields: 'id,slug,lang',
    }, toLanguage);
    return translated.lang === toLanguage ? translated.slug : null;
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

  return {
    get,
    getList,
    getPage,
    getItem,
    getItemBySlug,
    getByTerm,
    translatedId,
    translatedSlug,
    servicesByCategory,
  };
}
