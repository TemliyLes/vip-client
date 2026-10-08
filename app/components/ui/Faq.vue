<template>
  <div class="flex flex-col">
    <div
      v-for="(item, index) in data"
      :key="item.id"
      class="faq-item border-b border-[#E8E1DC] transition-colors duration-300"
      :class="{ 'bg-milk': opened === index }"
    >
      <button
        class="faq-header w-full flex justify-between items-center py-6 px-6 text-left"
        @click="toggle(index)"
      >
        <Header mini>
          {{ decodeWpText(item.title.rendered) }}
        </Header>

        <div
          class="w-10 h-10 bg-wine flex items-center justify-center shrink-0 select-none"
        >
          <Chevron
            class="transition-transform duration-300"
            :class="{ 'rotate-180': opened === index }"
          />
        </div>
      </button>

      <div
        :ref="(el) => (contents[index] = el)"
        class="faq-content overflow-hidden h-0"
      >
        <div class="px-6 pb-6">
          <Paragraph tag="div">
            <div v-html="item.content.rendered" />
          </Paragraph>
        </div>
      </div>
    </div>
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

defineProps({
  data: {
    type: Array,
    default: () => [],
  },
});

const opened = ref(null);

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
