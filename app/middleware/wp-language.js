export default defineNuxtRouteMiddleware(async (to) => {
  const getRouteBaseName = useRouteBaseName();
  const localePath = useLocalePath();
  const api = useWpApi();
  const name = getRouteBaseName(to);
  const resources = {
    'category-id': 'service-categories',
    'services-id': 'services',
    'news-id': 'news',
  };
  const resource = resources[name];
  if (!resource) return;
  // Read the destination URL: the current locale may still belong to the old page.
  const language = /^\/sk(?:\/|$)/.test(to.path) ? 'sk' : 'cs';
  const id = await api.translatedId(resource, to.params.id, language);

  if (!id) {
    throw createError({ statusCode: 404, statusMessage: 'Not Found' });
  }

  if (String(id) !== String(to.params.id)) {
    return navigateTo(localePath({
      name,
      params: { ...to.params, id: String(id) },
      query: to.query,
      hash: to.hash,
    }, language), { replace: true, redirectCode: 302 });
  }
});
