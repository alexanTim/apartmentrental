<template>
  <div class="slideshow-container p-6" style="margin-top:67px !important;">
    <!-- Slides -->
    <div
      v-for="(slide, index) in slides"
      :key="index"
      class="mySlides"
      v-show="currentIndex === index"
    >
      <img :src="slide" class="w-full rounded-lg shadow-lg" />
    </div>

    <!-- Dots -->
    <div style="display: none;" class="flex justify-center mt-2">
      <span
        v-for="(dot, index) in slides"
        :key="'dot-' + index"
        class="dot mx-1 h-3 w-3 rounded-full cursor-pointer"
        :class="{
          'bg-blue-500': currentIndex === index,
          'bg-gray-300': currentIndex !== index
        }"
        @click="goToSlide(index)"
      ></span>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const props = defineProps({
  slides: {
    type: Array,
    required: true,
  },
  interval: {
    type: Number,
    default: 2000,
  },
});

const currentIndex = ref(0);
let timer = null;

const startSlideshow = () => {
  timer = setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % props.slides.length;
  }, props.interval);
};

const goToSlide = (index) => {
  currentIndex.value = index;
};

onMounted(() => {
  startSlideshow();
});

onBeforeUnmount(() => {
  clearInterval(timer);
});
</script>

<style scoped>
.mySlides {
  display: block;
}
.mySlides img {
  width: 100%;
}
</style>