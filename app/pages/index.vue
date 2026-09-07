<template>
  <div>
    <Hero />

    <Service />
    <Clinic />
    <Slushba />
    <Videos />
    <AboutMain />
    <Team />
    <HomeNews />
    <Programm />
    <Feedback />
    <Sale />
    <FAQ />
    <!-- <Blank /> -->
  </div>
</template>

<script setup>
import Hero from "~/components/blocks/Hero.vue";

import Service from "~/components/blocks/Service.vue";
import Slushba from "~/components/blocks/Slushba.vue";
import AboutMain from "~/components/blocks/AboutMain.vue";
import Videos from "~/components/blocks/Videos.vue";
import Team from "~/components/blocks/Team.vue";
import Blank from "~/components/Blank.vue";
import HomeNews from "~/components/blocks/HomeNews.vue";
import Clinic from "~/components/blocks/Clinic.vue";
import Container from "~/components/ui/Container.vue";
import Programm from "~/components/blocks/Programm.vue";
import Feedback from "~/components/blocks/Feedback.vue";
import Sale from "~/components/blocks/Sale.vue";
import FAQ from "~/components/blocks/FAQ.vue";
</script>
