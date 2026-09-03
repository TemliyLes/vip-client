import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";

let timeline = null;
let smoother = null;

export const useGsap = () => {
  function init() {
    if (!smoother) {
      smoother = ScrollSmoother.create({
        wrapper: "#smooth-wrapper",

        content: "#smooth-content",

        smooth: 1.5,

        effects: true,

        normalizeScroll: true,
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

    gsap.from(elements, {
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

    gsap.fromTo(
      element,
      {
        y: 0,
      },
      {
        y: y,

        ease: "none",

        scrollTrigger: {
          trigger: element,

          start: "top top",

          end: "bottom top",

          scrub: 1,

          invalidateOnRefresh: true,
        },
      },
    );
  }
  function destroy() {
    if (timeline) {
      timeline.kill();

      timeline = null;
    }

    if (smoother) {
      smoother.kill();

      smoother = null;
    }

    ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
  }

  return {
    init,

    add,

    getTimeline,

    parallax,

    destroy,

    revealOnScroll,
  };
};
