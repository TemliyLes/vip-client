<template>
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 xl:gap-x-12 items-start">
    <ul v-for="(column, columnIndex) in columns" :key="columnIndex" class="flex flex-col min-w-0">
      <li
        v-for="({ item, index }) in column"
        :key="item.id"
        class="faq-item border-b border-[#E8E1DC] transition-colors duration-300"
        :class="{ 'bg-milk': opened === index }"
      >
        <h3>
          <button
            type="button"
            :id="`${id}-question-${index}`"
            :aria-expanded="opened === index"
            :aria-controls="`${id}-answer-${index}`"
            class="faq-header w-full flex justify-between items-center gap-4 py-6 px-4 sm:px-6 text-left"
            @click="toggle(index)"
          >
            <Header tag="span" mini class="block min-w-0 [&>span]:leading-6!">
              {{ decodeWpText(item.title.rendered) }}
            </Header>

            <span aria-hidden="true"
              class="w-10 h-10 bg-wine flex items-center justify-center shrink-0 select-none"
            >
              <Chevron
                class="transition-transform duration-300"
                :class="{ 'rotate-180': opened === index }"
              />
            </span>
          </button>
        </h3>

        <div
          role="region"
          :id="`${id}-answer-${index}`"
          :aria-labelledby="`${id}-question-${index}`"
          :aria-hidden="opened !== index"
          :inert="opened !== index"
          :ref="(el) => (contents[index] = el)"
          class="faq-content overflow-hidden h-0"
        >
          <div class="px-6 pb-6">
            <Paragraph tag="div" class="normal-case! text-sm! leading-6! [&_p+p]:mt-4">
              <div v-html="item.content.rendered" />
            </Paragraph>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Header from "./Header.vue";
import Paragraph from "./Paragraph.vue";
import Chevron from "../icons/Chevron.vue";
import { decodeWpText } from "~/utils/decodeWpText";

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
  data: {
    type: Array,
    default: () => [],
  },
});

// Read down the first column, then the second; mobile keeps the same order.
// Separate lists let answers expand without stretching the neighbouring column.
const columns = computed(() => {
  const items = props.data.map((item, index) => ({ item, index }));
  const middle = Math.ceil(items.length / 2);
  return [items.slice(0, middle), items.slice(middle)].filter(column => column.length);
});

const opened = ref(null);
const id = useId();

const contents = ref([]);

function openItem(index) {
  const content = contents.value[index];

  if (!content) return;

  // Measure the natural height, then continue from the current rendered height.
  const height = content.scrollHeight;

  gsap.killTweensOf(content, "height");

  gsap.to(content, {
    height,
    duration: 0.45,
    ease: "power2.out",
    onComplete() {
      if (opened.value === index) {
        content.style.height = "auto";
      }
      ScrollTrigger.refresh(true);
    },
  });
}

function closeItem(index) {
  const content = contents.value[index];

  if (!content) return;

  gsap.killTweensOf(content, "height");

  gsap.to(content, {
    height: 0,
    duration: 0.35,
    ease: "power2.inOut",
    onComplete: () => ScrollTrigger.refresh(true),
  });
}

function toggle(index) {
  // закрываем текущий
  if (opened.value === index) {
    closeItem(index);

    opened.value = null;

    return;
  }

  // закрываем предыдущий
  if (opened.value !== null) {
    closeItem(opened.value);
  }

  // открываем новый
  openItem(index);

  opened.value = index;
}

onBeforeUnmount(() => {
  gsap.killTweensOf(contents.value);
});
</script>
