<template>
  <div>
    <Hero />
    <HomeNews />

    <Service />
    <Slushba />
    <Videos />
    <AboutMain />
    <Team />
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
</script>
