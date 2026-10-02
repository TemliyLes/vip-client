import { mkdir, readFile, writeFile } from 'node:fs/promises'

const output = process.argv[2] || 'i18n/source/cms-latest.json'
if (output.replaceAll('\\', '/').endsWith('i18n/source/cms.json')) {
  throw new Error('The original CMS baseline is immutable; export to a different file')
}

// Read-only export of every published record used by this frontend, including pagination.
const config = await readFile(new URL('../nuxt.config.ts', import.meta.url), 'utf8')
const base = process.env.I18N_CMS_URL || config.match(/apiBase:\s*["']([^"']+)/)?.[1]
if (!base) throw new Error('Missing CMS API base URL')
const resources = ['pages', 'services', 'service-categories', 'news', 'reviews', 'faq', 'videos', 'posts']
const snapshot = { capturedAt: new Date().toISOString(), resources: {} }
for (const resource of resources) {
  const records = []
  let totalPages = 1
  for (let page = 1; page <= totalPages; page++) {
    const response = await fetch(`${base}/wp-json/wp/v2/${resource}?per_page=100&page=${page}`)
    if (!response.ok) throw new Error(`${resource}: HTTP ${response.status}`)
    const data = await response.json()
    if (!Array.isArray(data)) throw new Error(`${resource}: expected a collection`)
    totalPages = Number(response.headers.get('x-wp-totalpages') || 1)
    records.push(...data)
  }
  snapshot.resources[resource] = records
  console.log(`${resource}: ${records.length} records`)
}
await mkdir(new URL('../i18n/source/', import.meta.url), { recursive: true })
await writeFile(output, JSON.stringify(snapshot, null, 2) + '\n')
