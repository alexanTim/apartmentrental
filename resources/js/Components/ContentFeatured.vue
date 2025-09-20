<template>
  <div
    class="flex items-center justify-center min-h-screen bg-gray-100 bg-cover bg-center"
    :style="{ backgroundImage: `url(${backgroundImage})` }"
  >
    <div
      class="max-w-3xl text-center p-10 bg-white bg-opacity-80 rounded-2xl shadow-2xl space-y-6"
    >
      <p class="text-2xl italic text-gray-800">
        Escape the noise of everyday life and find your sanctuary at
        <span class="font-bold">{{ villaName }}</span>,
        where comfort surrounds you and every detail is made for your relaxation.
      </p>

      <p class="text-lg text-gray-700">
        Nestled in a serene environment, our villas offer breathtaking views of
        lush greenery and open skies, creating the perfect balance between
        luxury and nature.
      </p>

      <p class="text-lg text-gray-700">
        Every corner is designed with your peace in mind — from spacious
        interiors to cozy outdoor spaces where you can unwind, reflect, and
        simply breathe.
      </p>

      <p class="text-lg text-gray-700">
        Whether you’re here for a weekend escape or a longer stay,
        <span class="font-semibold">{{ villaName }}</span>
        is more than just a place to sleep — it’s an experience of pure comfort,
        harmony, and renewal.
      </p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  villaName: {
    type: String,
    default: "EdsenVillas",
  },
  backgroundImage: {
    type: String,
    default:
      "https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1600&q=80",
  },
})
</script>
