// Literal message functions preserve HTML, @, braces, pipes and whitespace exactly.
// An empty Slovak value means "translation pending" and is omitted for Vue I18n fallback.
export function literalMessages(dictionary, omitEmpty = false) {
  if (typeof dictionary === 'string') {
    return omitEmpty && dictionary === '' ? undefined : () => dictionary
  }
  const result = {}
  for (const [key, value] of Object.entries(dictionary)) {
    const message = literalMessages(value, omitEmpty)
    if (message !== undefined) result[key] = message
  }
  return result
}

// Vue originally condensed template text whitespace at compilation. Keep that
// display behavior (and SSR hydration) while retaining the exact raw JSON values.
export function renderMessage(value, key) {
  return key.startsWith('ui.') && /Text\d+$/.test(key)
    ? value.replace(/[\t\r\n\f ]+/g, ' ')
    : value
}

const technicalFields = new Set([
  '_links', 'guid', 'date', 'date_gmt', 'modified', 'modified_gmt', 'slug',
  'status', 'type', 'taxonomy', 'link', 'url', 'href', 'src', 'source_url',
  'mime_type', 'filename', 'file', 'format', 'template', 'class_list',
  'comment_status', 'ping_status', 'video_type', 'embed', 'embed_url',
  'youtube_id', 'youtube_url', 'robots', 'canonical', 'og_type', 'schema',
  'head', 'full_head',
])

export const cmsSegment = (value) => String(value).replaceAll('-', '_')

export function isCmsText(value) {
  return typeof value === 'string' && value !== '' &&
    !/^(?:https?:|\/\/|data:|mailto:|tel:)/i.test(value) &&
    !/^\d+(?:[.,]\d+)?$/.test(value)
}

// Shared by the dictionary exporter and the reactive runtime. Record IDs stay stable
// when WordPress changes collection ordering; nested repeaters without IDs use itemN.
export function mapCmsText(value, path, visit) {
  if (typeof value === 'string') return isCmsText(value) ? visit(path, value) : value
  if (Array.isArray(value)) {
    return value.map((item, index) => mapCmsText(item, `${path}.item${item?.id ?? index}`, visit))
  }
  if (value && typeof value === 'object') {
    return Object.fromEntries(Object.entries(value).map(([key, child]) => [
      key,
      technicalFields.has(key) || /(?:_url|_id)$/.test(key)
        ? child
        : mapCmsText(child, `${path}.${cmsSegment(key)}`, visit),
    ]))
  }
  return value
}

export function mapCmsRecords(value, resource, visit) {
  const root = `cms.${cmsSegment(resource)}`
  const record = (item) => {
    if (item?.id != null) return mapCmsText(item, `${root}.id${item.id}`, visit)
    if (item && typeof item === 'object') {
      return Object.fromEntries(Object.entries(item).map(([key, child]) => [
        key, mapCmsRecords(child, resource, visit),
      ]))
    }
    return item
  }
  return Array.isArray(value) ? value.map(record) : record(value)
}

export function setDictionaryValue(dictionary, path, value) {
  const parts = path.split('.')
  const key = parts.pop()
  let target = dictionary
  for (const part of parts) target = target[part] ||= {}
  target[key] = value
}

export function getDictionaryValue(dictionary, path) {
  return path.split('.').reduce((value, key) => value?.[key], dictionary)
}
