<template>
  <div class="w-full flex flex-col items-center">
    <section class="bg-gray-100 py-16 mt-24 w-full">
      <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">
          Testimonials
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
          <div
            v-for="(testimonial, index) in testimonials"
            :key="index"
            class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center animate-fadeInUp"
          >
            <img
              :src="testimonial.image"
              :alt="testimonial.name"
              class="w-20 h-20 rounded-full mb-4"
            />
            <p class="text-gray-600 italic mb-4">
              “{{ testimonial.message }}”
            </p>
            <h3 class="font-semibold text-gray-800">{{ testimonial.name }}</h3>
            <span class="text-yellow-400 mt-2">★★★★★</span>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
const testimonials = [
  {
    image: "https://i.pravatar.cc/100?img=1",
    message:
      "EdsenVillas was the perfect escape. The rooms were spotless and the view of the gardens was breathtaking!",
    name: "Sarah L.",
  },
  {
    image: "https://i.pravatar.cc/100?img=2",
    message:
      "I loved the peaceful atmosphere. Every detail was designed for comfort and relaxation. Highly recommend!",
    name: "Michael R.",
  },
  {
    image: "https://i.pravatar.cc/100?img=3",
    message:
      "A true hidden gem! The staff made me feel at home, and the villa itself was simply stunning.",
    name: "Anna P.",
  },
]
</script>
