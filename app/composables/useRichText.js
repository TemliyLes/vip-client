import { h } from "vue";
import { parse } from "node-html-parser";

import RichTextFallback from "~/components/ui/RichTextFallback.vue";

export const useWpRichText = (components = {}) => {
  const componentMap = {
    ...components,
  };

  const getProps = (node) => {
    return {
      ...(node.attributes || {}),
    };
  };

  const renderNode = (node, index = 0) => {
    // Текст
    if (node.nodeType === 3) {
      return node.rawText;
    }

    if (!node.tagName) {
      return null;
    }

    const tag = node.tagName.toLowerCase();

    const children = node.childNodes
      .map((child, childIndex) => renderNode(child, childIndex))
      .filter(Boolean);

    const component = componentMap[tag];

    // Если компонента пока нет
    if (!component) {
      return h(
        RichTextFallback,
        {
          tag,
          key: index,
        },
        {
          default: () => children,
        },
      );
    }

    return h(
      component,
      {
        ...getProps(node),
        key: index,
      },
      {
        default: () => children,
      },
    );
  };

  const renderRichText = (html) => {
    if (!html) return [];

    const root = parse(html);

    return root.childNodes
      .map((node, index) => renderNode(node, index))
      .filter(Boolean);
  };

  return {
    renderRichText,
  };
};
