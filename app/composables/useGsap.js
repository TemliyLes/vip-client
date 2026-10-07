// composables/useGsap.js

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

export const useGsap = () => {
  let timeline = null;

  let smoother = null;
  let pointerFocus = false;
  const onPointerDown = () => { pointerFocus = true; };
  const onKeyDown = () => { pointerFocus = false; };

  function init() {
    if (!smoother) {
      window.addEventListener("pointerdown", onPointerDown, true);
      window.addEventListener("mousedown", onPointerDown, true);
      window.addEventListener("keydown", onKeyDown, true);
      smoother = ScrollSmoother.create({
        wrapper: "#smooth-wrapper",

        content: "#smooth-content",

        smooth: 1.5,

        effects: true,

        // Pointer focus must not move a card between pointerdown and click.
        // Keep automatic scrolling when navigating with the keyboard.
        onFocusIn: () => !pointerFocus,
      });
    }

    if (!timeline) {
      timeline = gsap.timeline({
        scrollTrigger: {
          trigger: "#smooth-content",

          start: "top top",

          end: "bottom bottom",

          scrub: 1,
        },
      });
    }

    return timeline;
  }

  function add(animation) {
    if (!timeline) {
      init();
    }

    timeline.add(animation);
  }

  function getTimeline() {
    if (!timeline) {
      init();
    }

    return timeline;
  }

  function revealOnScroll(elements, y = 50, duration = 1.2, stagger = 0.3) {
    if (!elements || !elements.length) return;

    return gsap.from(elements, {
      y,

      opacity: 0,

      duration,

      stagger,

      ease: "power4.out",

      scrollTrigger: {
        trigger: elements[0],

        start: "top 85%",

        toggleActions: "play none none none",
      },
    });
  }

  function parallax(element, y = 100) {
    if (!element) return;

    return gsap.fromTo(
      element,

      {
        y: 0,
      },

      {
        y,

        ease: "none",

        scrollTrigger: {
          trigger: element,

          start: "top top",

          end: "bottom top",

          scrub: 1,
          ignoreMobileResize: true,
          invalidateOnRefresh: true,
        },
      },
    );
  }

  function scrollTop() {
    if (smoother) {
      smoother.scrollTo(0, false);
    } else {
      window.scrollTo(0, 0);
    }
  }

  function resetScroll() {
    ScrollTrigger.clearScrollMemory();

    if (smoother) {
      smoother.scrollTo(0, false);
    }

    window.scrollTo(0, 0);
  }

  function refresh() {
    ScrollTrigger.refresh(true);
  }

  function destroy() {
    window.removeEventListener("pointerdown", onPointerDown, true);
    window.removeEventListener("mousedown", onPointerDown, true);
    window.removeEventListener("keydown", onKeyDown, true);
    if (timeline) {
      timeline.kill();

      timeline = null;
    }

    if (smoother) {
      smoother.kill();

      smoother = null;
    }

    ScrollTrigger.clearScrollMemory();
  }
  return {
    init,

    add,

    getTimeline,

    revealOnScroll,

    parallax,

    scrollTop,

    resetScroll,

    refresh,

    destroy,
  };
};
