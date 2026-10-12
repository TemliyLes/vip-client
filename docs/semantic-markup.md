# Semantic markup

The site uses one main content landmark (`app.vue`), header navigation and a footer.
Content blocks use `section`, standalone cards and detail pages use `article`,
collections use `ul`/`li`, and service attributes use `dl`/`dt`/`dd`.
Layout, animation layers and wrappers around HTML from WordPress remain `div`.

## Headings

- `Header` defaults to `h2`; set `tag` explicitly for another level or for text
  that only shares the heading's visual style (`p`/`span`). `mini` affects styling only.
- `Title` and `Tag` are eyebrow labels, not headings.
- The home page has an `h1` in the active hero variant. Its ClientOnly fallback
  supplies the same heading in server HTML and is replaced during hydration.
- About has a visually hidden page heading. Contacts passes `heading-tag="h1"`
  to its contact block. Category and detail pages use their page title as `h1`.
- Cards normally use `h3` under a block's `h2`. Category listing cards use `h2`
  directly below the category's `h1`.
- `Container` accepts `tag` for blocks that need both its layout and a semantic root.

WordPress rich text is rendered as authored. Use `h2` for top-level headings
inside a service/news body and `h3` for their subsections; the page already has its `h1`.

## Interactive content

Navigation uses links inside lists. Action controls use buttons; buttons do not
contain block headings or paragraphs. FAQ questions are `h3` containing buttons
with expanded state and an associated answer region. Closed answers are inert.
Video captions use `figure`/`figcaption`. Form labels and the existing dialog
role/focus handling are preserved.

Existing Czech dictionary values are unchanged. Accessible names and hidden
collection headings are added under `accessibility` in both language dictionaries.
