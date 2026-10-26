const routeNames = {
  category: 'category-slug',
  services: 'services-slug',
  news: 'news-slug',
};

export function wpItemRoute(type, item) {
  const name = routeNames[type];
  const slug = item?.slug;
  if (!name || !slug) return null;

  return { name, params: { slug: String(slug) } };
}
