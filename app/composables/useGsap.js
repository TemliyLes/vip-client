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

    destroy,
  };
};
