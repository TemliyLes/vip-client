# VIP Polylang REST

Плагин открывает поля языка и связей переводов Polylang в REST API для
headless-фронта VIP Client. Он не хранит список языков: набор языков и связи
между чешскими исходными записями и переводами задаются в Polylang.

Требования: WordPress 6.0+, PHP 7.4+, активный Polylang с настроенными языками.
Типы записей и таксономии должны быть доступны в REST API и включены для
перевода в настройках Polylang.

## Установка

1. В WordPress откройте **Плагины → Добавить плагин → Загрузить плагин**.
2. Выберите `vip-polylang-rest.zip`, нажмите **Установить**.
3. Активируйте **VIP Polylang REST**.
4. Языки и связи будут взяты из настроек Polylang.

## Контракт API

Списки принимают код существующего языка:

```text
/wp-json/wp/v2/services?lang=cs&per_page=100
/wp-json/wp/v2/services?lang=ru&per_page=100
/wp-json/wp/v2/services?lang=en&per_page=100
/wp-json/wp/v2/service-categories?lang=ru&hide_empty=false&per_page=100
```

Неизвестный код в запросе списка возвращает ошибку WordPress (400). Фильтрация
по языку происходит до пагинации, поэтому `X-WP-Total` и `X-WP-TotalPages`
относятся к выбранному языку.

У каждой локализованной записи собственный slug. Фронтенд находит запись по
`slug` и `lang`, а при переключении языка получает ID перевода из `translations`
и использует его только для запроса другой записи. Числовые ID в адресе Nuxt
не используются. Примеры REST-запросов:

```text
/wp-json/wp/v2/services?lang=cs&slug=pece-o-plet
/wp-json/wp/v2/services?lang=ru&slug=uhod-za-kozhey
/wp-json/wp/v2/services?lang=en&slug=skin-care
```

Категория при фильтрации услуг передаётся ID перевода, соответствующего языку
запроса. `lang=ru` не преобразует чешский ID термина автоматически; фронтенд
использует связь переводов, чтобы определить правильный ID.

В ответах записей и категорий доступны поля `lang` и `translations`:

```json
{
  "id": 291,
  "slug": "pece-o-plet",
  "lang": "cs",
  "translations": { "cs": 291, "ru": 410, "en": 518 }
}
```

Поля доступны в списках и одиночных ответах. В `_fields` их нужно запросить
явно, если используется сокращённый набор. В публичных ответах не показываются
ID неопубликованных переводов.

Авторизованный редактор может задавать `lang` и `translations` через POST/PUT
WordPress. Плагин проверяет права, тип контента и язык и сохраняет существующие
связи. Он не переводит и не копирует содержимое: переводы создаются отдельными
записями WordPress и связываются с исходной чешской записью.

Перед включением новых языковых маршрутов проверьте, что в Polylang настроены
`cs`, `ru`, `en`, а записи и категории каждого языка опубликованы и имеют
уникальные латинские slug в нижнем регистре с дефисами.

## Отключение

Деактивируйте **VIP Polylang REST** в списке плагинов. Фильтры и поля исчезнут
из API; записи, переводы, картинки и настройки Polylang сохранятся.

## Основания реализации

- [Публичные функции Polylang](https://polylang.pro/documentation/support/developers/function-reference/)
- [Фильтр REST-запросов записей WordPress](https://developer.wordpress.org/reference/hooks/rest_this-post_type_query/)
- [Фильтр REST-запросов терминов WordPress](https://developer.wordpress.org/reference/hooks/rest_this-taxonomy_query/)
