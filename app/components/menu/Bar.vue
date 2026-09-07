<template>
  <div class="flex justify-between gap-4 h-full items-center relative">
    <div
      v-for="item in items"
      :key="item.title"
      class="relative h-full flex items-center"
      @mouseenter="item.children && openMenu(item.title)"
      @mouseleave="item.children && startClose(item.title)"
    >
      <NuxtLink :to="item?.to" class="h-full flex items-center">
        <Paragraph
          :class="[
            '!transition-colors !duration-300',
            !active ? '!text-white' : '!text-darkbeige',
          ]"
        >
          {{ item.title }}
        </Paragraph>
      </NuxtLink>

      <!-- Dropdown -->
      <div
        v-if="item.children"
        :ref="(el) => setDropdownRef(item.title, el)"
        class="dropdown absolute top-[48px] left-0 min-w-[280px] bg-white shadow-xl p-5 opacity-0 invisible scale-y-95 origin-top"
        @mouseenter="cancelClose(item.title)"
        @mouseleave="startClose(item.title)"
      >
        <div class="flex flex-col gap-4">
          <NuxtLink
            v-for="child in item.children"
            :key="child.title"
            :to="child.to"
          >
            <Paragraph
              class="!text-darkbeige hover:!text-wine !transition-colors !duration-300"
            >
              {{ child.title }}
            </Paragraph>
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { gsap } from "gsap";
import Paragraph from "../ui/Paragraph.vue";

defineProps({
  items: {
    type: Array,
    default: () => [],
  },

  active: {
    type: Boolean,
    default: false,
  },
});

const dropdowns = {};
const timers = {};

const setDropdownRef = (key, el) => {
  if (el) {
    dropdowns[key] = el;
  }
};

const openMenu = (key) => {
  const dropdown = dropdowns[key];

  if (!dropdown) return;

  clearTimeout(timers[key]);

  gsap.set(dropdown, {
    visibility: "visible",
  });

  gsap.to(dropdown, {
    opacity: 1,
    y: 0,
    scale: 1,
    duration: 0.35,
    ease: "power3.out",
  });
};

const startClose = (key) => {
  timers[key] = setTimeout(() => {
    closeMenu(key);
  }, 150);
};

const cancelClose = (key) => {
  clearTimeout(timers[key]);
};

const closeMenu = (key) => {
  const dropdown = dropdowns[key];

  if (!dropdown) return;

  gsap.to(dropdown, {
    opacity: 0,
    y: 10,
    scale: 0.97,
    duration: 0.25,
    ease: "power2.in",
    onComplete: () => {
      gsap.set(dropdown, {
        visibility: "hidden",
      });
    },
  });
};
</script>

<style scoped>
.dropdown::before {
  content: "";
  position: absolute;
  top: -20px;
  left: 0;
  width: 100%;
  height: 20px;
}
</style>
