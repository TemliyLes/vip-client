<template>
  <div
    class="w-full fixed top-0 left-0 z-[999] h-[80px] grid place-items-center"
  >
    <Container>
      <div class="flex justify-between">
        <Logo />

        <Button>Rezrvovat Online</Button>
      </div>
    </Container>
  </div>
</template>

<script setup lang="ts">
import Container from "../ui/Container.vue";
import Logo from "../icons/logo.vue";
import Button from "../ui/Button.vue";
</script>
