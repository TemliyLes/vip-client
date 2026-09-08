<template>
  <Teleport to="body">
    <!-- Burger -->
    <button
      ref="button"
      class="fixed top-5 right-5 z-[99999] flex flex-col gap-1.5 w-12 h-12 items-center justify-center bg-wine"
      @click="toggle"
    >
      <span
        class="block w-7 h-[1px] bg-white transition-all duration-300"
        :class="open ? 'rotate-45 translate-y-[7px]' : ''"
      />

      <span
        class="block w-7 h-[1px] bg-white transition-all duration-300"
        :class="open ? 'opacity-0' : ''"
      />

      <span
        class="block w-7 h-[1px] bg-white transition-all duration-300"
        :class="open ? '-rotate-45 -translate-y-[7px]' : ''"
      />
    </button>

    <!-- Menu -->
    <div
      ref="menuWrapper"
      class="fixed inset-0 z-[99998] bg-white opacity-0 invisible overflow-y-auto"
    >
      <div ref="menuContent" class="flex flex-col pt-[110px] px-6 pb-10 gap-5">
        <div v-for="item in menu" :key="item.title" class="menu-item">
          <!-- Simple link -->
          <NuxtLink
            v-if="!item.children?.length"
            :to="item.to"
            class="block py-2"
            @click="close"
          >
            <Paragraph>
              {{ item.title }}
            </Paragraph>
          </NuxtLink>

          <!-- Item with children -->
          <template v-else>
            <button
              class="flex justify-between items-center w-full py-2"
              @click="toggleSub(item.title)"
            >
              <Paragraph>
                {{ item.title }}
              </Paragraph>

              <span
                class="text-darkbeige text-xl transition-transform duration-300"
                :class="openedSub === item.title ? 'rotate-45' : ''"
              >
                +
              </span>
            </button>

            <!-- Children -->
            <div
              :ref="(el) => setSubmenuRef(item.title, el)"
              class="overflow-hidden max-h-0"
            >
              <div class="mt-3 flex flex-col bg-milk px-5 py-3">
                <NuxtLink
                  v-for="child in item.children"
                  :key="`${item.title}-${child.title}-${child.to}`"
                  :to="child.to"
                  class="block py-3 border-b border-darkbeige/20 last:border-none"
                  @click="close"
                >
                  <Paragraph>
                    {{ child.title }}
                  </Paragraph>
                </NuxtLink>
              </div>
            </div>
          </template>
        </div>

        <Button class="mt-4"> Rezervovat Online </Button>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { gsap } from "gsap";

import Paragraph from "../ui/Paragraph.vue";
import Button from "../ui/Button.vue";

import { menu } from "#imports";

const open = ref(false);

const openedSub = ref(null);

const menuWrapper = ref(null);

const menuContent = ref(null);

const submenus = {};

const setSubmenuRef = (key, el) => {
  if (el) {
    submenus[key] = el;
  }
};

const toggle = () => {
  open.value ? close() : show();
};

const show = () => {
  open.value = true;

  gsap.killTweensOf(menuWrapper.value);

  gsap.set(menuWrapper.value, {
    visibility: "visible",
    yPercent: -5,
  });

  gsap.to(menuWrapper.value, {
    opacity: 1,

    yPercent: 0,

    duration: 0.45,

    ease: "power3.out",
  });

  gsap.fromTo(
    menuContent.value.querySelectorAll(".menu-item"),

    {
      opacity: 0,
      y: 25,
    },

    {
      opacity: 1,
      y: 0,
      stagger: 0.07,
      duration: 0.35,
      ease: "power3.out",
    },
  );

  document.body.style.overflow = "hidden";
};

const close = () => {
  open.value = false;

  openedSub.value = null;

  Object.values(submenus).forEach((submenu) => {
    gsap.set(submenu, {
      maxHeight: 0,
    });
  });

  gsap.killTweensOf(menuWrapper.value);

  gsap.to(menuWrapper.value, {
    opacity: 0,

    yPercent: -5,

    duration: 0.3,

    ease: "power2.in",

    onComplete() {
      gsap.set(menuWrapper.value, {
        visibility: "hidden",
      });
    },
  });

  document.body.style.overflow = "";
};

const toggleSub = (title) => {
  const submenu = submenus[title];

  if (!submenu) return;

  const isOpen = openedSub.value === title;

  if (openedSub.value && openedSub.value !== title) {
    const previousSubmenu = submenus[openedSub.value];

    if (previousSubmenu) {
      gsap.to(previousSubmenu, {
        maxHeight: 0,

        duration: 0.3,

        ease: "power3.out",
      });
    }
  }

  openedSub.value = isOpen ? null : title;

  gsap.to(submenu, {
    maxHeight: isOpen ? 0 : submenu.scrollHeight,

    duration: 0.35,

    ease: "power3.out",
  });
};
</script>
