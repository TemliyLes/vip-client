import cs from './locales/cs.json'
import ru from './locales/ru.json'
import en from './locales/en.json'
import { literalMessages, renderMessage } from './utils.js'

export default defineI18nConfig(() => ({
  legacy: false,
  fallbackLocale: 'cs',
  missingWarn: false,
  fallbackWarn: false,
  postTranslation: renderMessage,
  // Literal functions keep the editable JSON out of message-format parsing.
  messages: {
    cs: literalMessages(cs),
    ru: literalMessages(ru),
    en: literalMessages(en),
  },
}))
