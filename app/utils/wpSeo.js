import { decodeWpText } from './decodeWpText.js';

export function resolveWpSeo(record = {}, fallback = {}) {
  const seo = record?.seo ?? {};
  const fallbackTitle = decodeWpText(fallback.title || record?.title?.rendered || record?.name || 'PALIY');
  const title = seo.title?.trim() || (fallbackTitle === 'PALIY' ? fallbackTitle : `${fallbackTitle} | PALIY`);
  const description = seo.description?.trim() || fallback.description || '';
  const image = seo.og_image?.url || record?.images?.original?.url;

  return {
    title,
    description: description || undefined,
    ogTitle: seo.og_title?.trim() || title,
    ogDescription: seo.og_description?.trim() || description || undefined,
    ogImage: image || undefined,
    robots: seo.noindex === true ? 'noindex, follow' : 'index, follow',
  };
}
