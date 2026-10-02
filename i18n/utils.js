// Literal message functions preserve @, braces, pipes and whitespace exactly.
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
