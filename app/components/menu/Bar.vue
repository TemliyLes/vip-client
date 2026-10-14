<template>
  <nav :aria-label="$t('accessibility.primaryNavigation')" class="flex justify-between gap-4 h-full items-center relative">
    <ul class="flex justify-between gap-4 h-full items-center relative w-full">
      <li
        v-for="item in items"
        :key="item.id"
        class="relative h-full flex items-center"
        @mouseenter="item.children && openMenu(item.id)"
        @mouseleave="item.children && startClose(item.id)"
        @focusin="item.children && openMenu(item.id)"
        @focusout="item.children && startClose(item.id)"
      >
        <NuxtLinkLocale :to="item?.to" class="focus-link h-full flex items-center"
          :class="{ 'focus-on-dark': !active }"
          :aria-expanded="item.children ? Boolean(openMenus[item.id]) : undefined"
        >
          <Paragraph tag="span"
            class="focus-label hover:text-wine"
            :class="[
              '!transition-colors !duration-300',
              !active ? 'text-white' : 'text-darkbeige',
            ]"
          >
            {{ item.title }}
          </Paragraph>
        </NuxtLinkLocale>

        <!-- Dropdown -->
        <div
          v-if="item.children"
          :ref="(el) => setDropdownRef(item.id, el)"
          class="dropdown absolute top-[48px] left-0 min-w-[280px] bg-white shadow-xl p-5 opacity-0 invisible scale-y-95 origin-top"
          @mouseenter="cancelClose(item.id)"
          @mouseleave="startClose(item.id)"
        >
          <ul class="flex flex-col gap-4">
            <li v-for="child in item.children" :key="child.id">
              <NuxtLinkLocale
                :to="child.to"
                class="focus-link block"
              >
                <Paragraph tag="span"
                  class="focus-label text-darkbeige hover:text-wine !transition-colors !duration-300"
                >
                  {{ child.title }}
                </Paragraph>
              </NuxtLinkLocale>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
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
const openMenus = reactive({});

const setDropdownRef = (key, el) => {
  if (el) {
    dropdowns[key] = el;
  }
};

const openMenu = (key) => {
  const dropdown = dropdowns[key];

  if (!dropdown) return;

  clearTimeout(timers[key]);
  openMenus[key] = true;
  gsap.killTweensOf(dropdown);

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
  clearTimeout(timers[key]);
  timers[key] = setTimeout(() => {
    // Tabbing into a submenu must keep it visible after the pointer leaves.
    const item = dropdowns[key]?.parentElement;
    if (item?.matches(":focus-within, :hover")) return;
    closeMenu(key);
  }, 150);
};

const cancelClose = (key) => {
  clearTimeout(timers[key]);
};

const closeMenu = (key) => {
  const dropdown = dropdowns[key];

  if (!dropdown) return;

  openMenus[key] = false;
  gsap.killTweensOf(dropdown);
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

onUnmounted(() => {
  Object.values(timers).forEach(clearTimeout);
  Object.values(dropdowns).forEach((dropdown) => gsap.killTweensOf(dropdown));
});
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
