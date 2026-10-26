import assert from 'node:assert/strict'
import { readFile, readdir } from 'node:fs/promises'
import { execFileSync } from 'node:child_process'
import { createRequire } from 'node:module'
import { parse as parseSfc } from '@vue/compiler-sfc'
import { parse as parseTemplate } from '@vue/compiler-dom'
import { literalMessages, renderMessage } from '../i18n/utils.js'

// Exercise the same Vue I18n version installed by the Nuxt module.
const moduleRequire = createRequire(import.meta.resolve('@nuxtjs/i18n'))
const { createI18n } = moduleRequire('vue-i18n')
const cs = JSON.parse(await readFile('i18n/locales/cs.json', 'utf8'))
const ru = JSON.parse(await readFile('i18n/locales/ru.json', 'utf8'))
const en = JSON.parse(await readFile('i18n/locales/en.json', 'utf8'))
const dictionaries = { cs, ru, en }
const manifest = JSON.parse(await readFile('i18n/source/ui-manifest.json', 'utf8'))
function flatten(value, path = '', result = {}) {
  if (typeof value === 'string') result[path] = value
  else for (const [key, child] of Object.entries(value)) flatten(child, path ? `${path}.${key}` : key, result)
  return result
}
const csFlat = flatten(cs)
for (const [locale, dictionary] of Object.entries(dictionaries)) {
  const flat = flatten(dictionary)
  assert.deepEqual(Object.keys(flat).sort(), Object.keys(csFlat).sort(), `${locale} dictionary must have the same keys as Czech`)
  if (locale !== 'cs') {
    assert(Object.values(flat).every((value) => value.trim() !== ''), `${locale} dictionary contains an empty translation`)
  }
}

// Check each recorded source revision and the dictionary, including archived keys
// whose UI was removed upstream. Keep CRLF/spacing exact; Git stores LF source.
const originals = new Map()
const current = new Map()
for (const entry of manifest.ui) {
  assert.equal(csFlat[entry.key], entry.value, `Czech text changed: ${entry.key}`)
  const baselineKey = `${entry.revision || manifest.revision}:${entry.file}`
  if (!originals.has(baselineKey)) {
    originals.set(baselineKey, execFileSync('git', ['show', baselineKey], { encoding: 'utf8' }))
  }
  const baseline = originals.get(baselineKey).replaceAll('\r\n', '\n')
  assert(baseline.includes(entry.source.replaceAll('\r\n', '\n')), `Original source missing: ${entry.key}`)
  if (entry.active !== false) {
    if (!current.has(entry.file)) current.set(entry.file, await readFile(entry.file, 'utf8'))
    assert(current.get(entry.file).includes(`'${entry.key}'`), `Translation not connected: ${entry.key}`)
  }
  if (entry.key.startsWith('ui.') && /Text\d+$/.test(entry.key)) {
    const originalText = parseTemplate(`<p>${entry.value}</p>`).children[0].children[0].content
    assert.equal(renderMessage(entry.value, entry.key), originalText, `Original Vue whitespace behavior changed: ${entry.key}`)
  }
}

const i18n = createI18n({
  legacy: false, locale: 'cs', fallbackLocale: 'cs', missingWarn: false, fallbackWarn: false,
  postTranslation: renderMessage,
  messages: Object.fromEntries(Object.entries(dictionaries).map(([locale, dictionary]) => [locale, literalMessages(dictionary)])),
})
for (const locale of Object.keys(dictionaries)) {
  i18n.global.locale.value = locale
  const flat = flatten(dictionaries[locale])
  for (const [key, value] of Object.entries(flat)) {
    assert.equal(i18n.global.t(key), renderMessage(value, key), `Runtime ${locale} text is not verbatim: ${key}`)
  }
}

// Scan templates for remaining unextracted visible strings and unknown $t keys.
async function scan(directory) {
  for (const entry of await readdir(directory, { withFileTypes: true })) {
    const file = `${directory}/${entry.name}`
    if (entry.isDirectory()) { await scan(file); continue }
    if (!entry.name.endsWith('.vue') && !entry.name.endsWith('.js')) continue
    const source = await readFile(file, 'utf8')
    for (const match of source.matchAll(/\b(?:\$t|t)\('([^']+)'\)/g)) {
      assert(Object.hasOwn(csFlat, match[1]), `Unknown dictionary key in ${file}: ${match[1]}`)
    }
    if (!file.endsWith('.vue')) continue
    const { descriptor } = parseSfc(source)
    if (!descriptor.template) continue
    const ast = parseTemplate(descriptor.template.content)
    function walk(node) {
      if (node.type === 2) assert(!node.content.trim(), `Unextracted text in ${file}: ${node.content}`)
      for (const prop of node.props || []) {
        if (prop.type === 6 && ['title', 'header', 'description', 'alt', 'placeholder', 'aria-label', 'address'].includes(prop.name)) {
          assert(!prop.value?.content, `Unextracted ${prop.name} in ${file}`)
        }
      }
      for (const child of node.children || []) walk(child)
    }
    walk(ast)
  }
}
await scan('app')
console.log(`Verified ${manifest.ui.length} original static text occurrences and ${Object.keys(csFlat).length} complete values in each of cs, ru, and en.`)
