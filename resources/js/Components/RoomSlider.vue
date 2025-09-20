<template>
  <div class="flex flex-col items-center justify-center min-h-screen">
    <!-- Title -->
    <div class="w-full text-center text-white pb-10 text-4xl">View Rooms</div>

    <!-- Slider -->
    <div class="image-slider w-full max-w-4xl">
      <section class="slider__content relative flex items-center justify-center">
        <!-- Prev Button -->
        <button
          type="button"
          class="slider-control--button prev-button absolute left-0 p-2 bg-white/70 rounded-full shadow"
          @click="prevSlide"
        >
          <svg
            width="24"
            height="24"
            fill="currentColor"
            class="icon arrow-left-circle"
            viewBox="0 0 16 16"
          >
            <path
              fill-rule="evenodd"
              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 
              2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 
              0-.708l3-3a.5.5 0 1 1 .708.708L5.707 
              7.5z"
            />
          </svg>
        </button>

        <!-- Displayed Image -->
        <main class="image-display">
          <img
            :src="images[currentIndex]"
            alt="Room Image"
            class="rounded-xl shadow-lg max-h-[400px] w-full object-cover"
          />
        </main>

        <!-- Next Button -->
        <button
          type="button"
          class="slider-control--button next-button absolute right-0 p-2 bg-white/70 rounded-full shadow"
          @click="nextSlide"
        >
          <svg
            width="24"
            height="24"
            fill="currentColor"
            class="icon arrow-right-circle"
            viewBox="0 0 16 16"
          >
            <path
              fill-rule="evenodd"
              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 
              8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 
              16 0M4.5 7.5a.5.5 0 0 0 0 
              1h5.793l-2.147 2.146a.5.5 0 0 
              0 .708.708l3-3a.5.5 0 0 0 
              0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 
              7.5z"
            />
          </svg>
        </button>
      </section>

      <!-- Navigation Thumbnails -->
      <nav class="slider-navigation flex justify-center mt-4 gap-2">
        <button
          v-for="(img, index) in images"
          :key="index"
          class="nav-button border-2 rounded-lg overflow-hidden focus:outline-none"
          :class="currentIndex === index ? 'border-yellow-400' : 'border-transparent'"
          @click="goToSlide(index)"
        >
          <img
            :src="img"
            :alt="'Thumbnail ' + (index + 1)"
            class="thumbnail w-20 h-12 object-cover"
          />
        </button>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"

const images = [
  "https://picsum.photos/800/400?random=1",
  "https://picsum.photos/800/400?random=2",
  "https://picsum.photos/800/400?random=3",
  "https://picsum.photos/800/400?random=4",
  "https://picsum.photos/800/400?random=5",
  "https://picsum.photos/800/400?random=6",
]

const currentIndex = ref(0)

function nextSlide() {
  currentIndex.value = (currentIndex.value + 1) % images.length
}

function prevSlide() {
  currentIndex.value =
    (currentIndex.value - 1 + images.length) % images.length
}

function goToSlide(index) {
  currentIndex.value = index
}
</script>
