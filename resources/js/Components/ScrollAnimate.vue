<template>
  <div
    ref="el"
    :class="[
      'transition-all duration-700 ease-out',
      isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'
    ]"
  >
    <slot />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const isVisible = ref(false);
const el = ref(null);
let observer = null;

onMounted(() => {
  observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        // 👇 animate when in view
        if (entry.isIntersecting) {
          isVisible.value = true;
        } else {
          // 👇 reset when out of view (so it animates again)
          isVisible.value = false;
        }
      });
    },
    { threshold: 0.25 } // trigger when 20% is visible
  );

  if (el.value) {
    observer.observe(el.value);
  }
});

onBeforeUnmount(() => {
  if (el.value) {
    observer.unobserve(el.value);
  }
});
</script>
