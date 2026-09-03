<template>
  <div>
    <AlterHero />
    {{ $route.params.id }}
  </div>
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
</script>
