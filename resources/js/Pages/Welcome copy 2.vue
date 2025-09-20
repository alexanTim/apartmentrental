<script setup>
import { ref,watch,onMounted } from 'vue'
import { Head, Link ,usePage} from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import BookingForm from '@/Components/BookingForm.vue'
import { Inertia } from '@inertiajs/inertia'
import Slider from '@/Untility/Slider.js' // import the class
const showModal = ref(false)
import Slideshow from "@/Components/SlideShow.vue";
import ScrollAnimate from "@/Components/ScrollAnimate.vue";

const images = [
  "/images/img_nature_wide.jpg",
  "/images/img_snow_wide.jpg",
  "/images/img_mountains_wide.jpg",
];


const isVisible = ref(false);

// Form data
// Form state using Inertia useForm
const form = useForm({
  frontend_create_tenant: true,
  name: '',
  room_id: '', 
  email: '',
  telephone: '',
  start_date:'',
  end_date:'',
  length_stay: '',
  stay_type: null, // 'transient' or 'monthly'
  open_ended: false, // for monthly tenants who don’t know end date
})

watch(
  () => form.stay_type,
  (newVal, oldVal) => {
    console.log(`Stay type changed from ${oldVal} → ${newVal}`)
    // example: reset length if type changes
    if(newVal == 'transient') {
      form.open_ended = false // reset open_ended if switching to transient
      form.length_stay = 1 // default to 1 day for transient
    } else if (newVal == 'monthly') {
      form.length_stay = 1 // default to 1 month for monthly
    }  
    console.log(`Length of stay set to ${form.length_stay}`)
  })

watch(
  () => form.open_ended,
  (newVal) => {
    console.log('Open-ended status changed:', newVal)
    if (newVal) {
      form.length_stay = '' // clear length_stay if indefinite stay
    }
  }
)

const cancel = () => {

  showModal.value = false
  form.clearErrors()
  form.reset()
}

// Submit handler
const submitForm = () => {
  form.post('/bookings', {
    onSuccess: () => {
      showModal.value = false // close modal
      form.reset()            // reset inputs
      alert('Booking submitted successfully!')
    },
    onError: (errors) => {
      console.log(errors)     // validation errors automatically populate form.errors
    }
  })
}



defineProps({
    rooms: Array,
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const slider = ref(null)

onMounted(() => { 
    if (slider.value) {
      new Slider(slider.value) // initialize with the DOM element
    } 

     const moveCursor = (e) => {
    if (cursor.value) {
      cursor.value.style.left = e.clientX + 'px'
      cursor.value.style.top = e.clientY + 'px'
    }
  }

  setTimeout(() => {
    isVisible.value = true;
  }, 500);
})
</script>

<template>
    <div class="">
    <!-- Button to open modal --> 
    <!-- Overlay -->
    <transition name="fade">
      <div 
        v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-40"
        @click.self="showModal = false"
      ></div>
    </transition>

    <transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 -translate-y-10"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-10"
    >
      <div
        v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <BookingForm
          :form ="form" 
          :rooms ="rooms"
          @cancel ="cancel" 
          @submit ="submitForm" 
        />
      </div>
    </transition>

  </div>
    <Head title="Welcome" />
     <ScrollAnimate>
    <section>
 
    <Slideshow :slides="images" :interval="3000" />
 
</section>
</ScrollAnimate>
    <div class="text-black/50 dark:bg-black dark:text-white/50">
     
         <div class="pt-3 mb-5  sm:pt-5" style="padding: 12px;">    
         <ScrollAnimate>       
            <span class="block text-white text-[5em] text-center font-semibold text-black dark:text-white">
                EdSen Villa room for rent
            </span>
         </ScrollAnimate>    
         <ScrollAnimate>   
            <div  class="mt-14 mb-20 text-white text-center text-lg text-gray-800">
            <p class="text-[22px] mt-14 mb-20 text-white text-center">
                "At EdSen Villa, every stay is more than just a rental — it's a retreat where comfort meets elegance, and every moment feels like home."</p>
            </div>
           </ScrollAnimate>  
           <ScrollAnimate>
            <div class="flex flex-col items-center mb-5">
              <svg style="border-radius: 23px;
              border: 4px solid #eee;
              width: 43px;
              height: 41px;
              padding: 4px;" fill="#ffffff" height="30px" width="30px" viewBox="-337 273 123.5 256" xmlns="http://www.w3.org/2000/svg">
                <path d="M-260.9,327.8c0-10.3,9.2-14,19.5-14c10.3,0,21.3,3.2,21.3,3.2l6.6-39.2c0,0-14-4.8-47.4-4.8c-20.5,0-32.4,7.8-41.1,19.3
                c-8.2,10.9-8.5,28.4-8.5,39.7v25.7H-337V396h26.5v133h49.6V396h39.3l2.9-38.3h-42.2V327.8z"/>
              </svg>
            </div>
         
            <nav class="mb-1 -mx-3 flex flex-1 justify-center">                       
            <button @click="showModal = true" class="bg-[#09352d] hover:bg-[#2f9f8a] text-white font-semibold px-4 py-2 rounded-full border-[10px] border-[#169981] w-[300px] h-20" > Don't wait, Reserve Now! </button>
                  <!-- Floating Button -->   
            </nav>    </ScrollAnimate>     
    </div>

    <ScrollAnimate>
      <div class="flex flex-col items-center justify-center min-h-screen ">
        <div class="w-full text-center text-white pb-10 text-4xl">View Rooms</div>  
        <div ref="slider" class="image-slider">
            <section class="slider__content">
                <button type="button" class="slider-control--button prev-button">
                    <svg width="16" height="16" fill="currentColor" class="icon arrow-left-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                    </svg>
                </button>
                <main class="image-display"></main>
                <button type="button" class="slider-control--button next-button">
                    <svg width="16" height="16" fill="currentColor" class="icon arrow-right-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
                    </svg>
                </button>
            </section>
            <nav class="slider-navigation">
                <button class="nav-button" aria-selected="true">
                    <img class="thumbnail" src="https://picsum.photos/800/400?random=1" alt="Thumbnail 1" />
                </button>
                <button class="nav-button" aria-selected="false">
                    <img class="thumbnail" src="https://picsum.photos/800/400?random=2" alt="Thumbnail 2" />
                </button>
                <button class="nav-button" aria-selected="false">
                    <img class="thumbnail" src="https://picsum.photos/800/400?random=3" alt="Thumbnail 3" />
                </button>
                <button class="nav-button" aria-selected="false">
                    <img class="thumbnail" src="https://picsum.photos/800/400?random=4" alt="Thumbnail 4" />
                </button>
                <button class="nav-button" aria-selected="false">
                    <img class="thumbnail" src="https://picsum.photos/800/400?random=5" alt="Thumbnail 5" />
                </button>
                <button class="nav-button" aria-selected="false">
                    <img class="thumbnail" src="https://picsum.photos/800/400?random=6" alt="Thumbnail 6" />
                </button>
            </nav>
        </div>
      </div>
    </ScrollAnimate>
<ScrollAnimate>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1600&q=80');">
  <div class="max-w-3xl text-center p-10 bg-white bg-opacity-80 rounded-2xl shadow-2xl space-y-6">
    
    <p class="text-2xl italic text-gray-800">
      Escape the noise of everyday life and find your sanctuary at <span class="font-bold">EdsenVillas</span>, 
      where comfort surrounds you and every detail is made for your relaxation.
    </p>
    
    <p class="text-lg text-gray-700">
      Nestled in a serene environment, our villas offer breathtaking views of lush greenery and open skies, 
      creating the perfect balance between luxury and nature.
    </p>
    
    <p class="text-lg text-gray-700">
      Every corner is designed with your peace in mind — from spacious interiors to cozy outdoor spaces 
      where you can unwind, reflect, and simply breathe.
    </p>
    
    <p class="text-lg text-gray-700">
      Whether you’re here for a weekend escape or a longer stay, <span class="font-semibold">EdsenVillas</span> 
      is more than just a place to sleep — it’s an experience of pure comfort, harmony, and renewal.
    </p>
    
  </div>
</div>
 </ScrollAnimate>

 

  <ScrollAnimate>
    <div class="wp-full flex flex-col items-center">      
      <section class="bg-gray-100 py-16 mt-24">
        <div class="max-w-6xl mx-auto px-4">
          <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">
            Testimonials
          </h2>

          <div class="grid md:grid-cols-3 gap-8">
            <!-- Testimonial Card 1 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center animate-fadeInUp">
              <img
                src="https://i.pravatar.cc/100?img=1"
                alt="Guest"
                class="w-20 h-20 rounded-full mb-4"
              />
              <p class="text-gray-600 italic mb-4">
                “EdsenVillas was the perfect escape. The rooms were spotless and the
                view of the gardens was breathtaking!”
              </p>
              <h3 class="font-semibold text-gray-800">Sarah L.</h3>
              <span class="text-yellow-400 mt-2">★★★★★</span>
            </div>

            <!-- Testimonial Card 2 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center animate-fadeInUp">
              <img
                src="https://i.pravatar.cc/100?img=2"
                alt="Guest"
                class="w-20 h-20 rounded-full mb-4"
              />
              <p class="text-gray-600 italic mb-4">
                “I loved the peaceful atmosphere. Every detail was designed for
                comfort and relaxation. Highly recommend!”
              </p>
              <h3 class="font-semibold text-gray-800">Michael R.</h3>
              <span class="text-yellow-400 mt-2">★★★★★</span>
            </div>

            <!-- Testimonial Card 3 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center animate-fadeInUp">
              <img
                src="https://i.pravatar.cc/100?img=3"
                alt="Guest"
                class="w-20 h-20 rounded-full mb-4"
              />
              <p class="text-gray-600 italic mb-4">
                “A true hidden gem! The staff made me feel at home, and the villa
                itself was simply stunning.”
              </p>
              <h3 class="font-semibold text-gray-800">Anna P.</h3>
              <span class="text-yellow-400 mt-2">★★★★★</span>
            </div>
          </div>
        </div>
      </section>
    </div>
  </ScrollAnimate>

        <div style="display: none;"
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
              


                <main class="mt-6">
                   
                     <!-- Button -->
   

   
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">    
                   
                        <a 
                            href="#"
                            class="flex items-start gap-4  p-6  ring-1 ring-white/[0.05] transition duration-300 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800  dark:focus-visible:ring-[#FF2D20]"
                        >
                           

                            <div class="pt-3 sm:pt-5">
                                <h2
                                    class="text-xl font-semibold text-white dark:text-white"
                                >
                                    Ketchen
                                </h2>

                                <p class="mt-4 text-sm/relaxed">
                                   <img  src="https://www.thespruce.com/thmb/d3fKdYmsnt2xPxbKJUR3sKPW-Zc=/5400x0/filters:no_upscale():max_bytes(150000):strip_icc()/DesignbyNatalieKraiemPhotobyKirstenFrancis-c8c60d48cd3541a9bdb756a933aa3780.jpg" alt="Edsen Villas" class="mx-auto rounded-lg shadow-lg" style="max-width: 100%; height: auto;border:20px solid #1d594e">
                                </p>
                            </div>

                        </a>

                        <a
                            href="https://laravel-news.com"
                            class="flex items-start gap-4 p-6  ring-1 ring-white/[0.05] transition duration-300  focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:focus-visible:ring-[#FF2D20]"
                        >
                           

                            <div class="pt-3 sm:pt-5">
                                <h2
                                    class="text-xl font-semibold text-white dark:text-white"
                                >
                                    Room
                                </h2>

                                <p class="mt-4 text-sm/relaxed">
                                   <img  src="https://plus.unsplash.com/premium_photo-1661877303180-19a028c21048?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YmVhdXRpZnVsJTIwcm9vbXxlbnwwfHwwfHx8MA%3D%3D" alt="Edsen Villas" class="mx-auto rounded-lg shadow-lg" style="max-width: 100%; height: 378px; width:552px ;border:20px solid #1d594e" >
                                </p>
                            </div>

                            
                        </a>
 <div
                            class="flex items-start gap-4  p-6 ring-1 ring-white/[0.05] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800"
                        >
                          

                            <div class="pt-3 sm:pt-5">
                                <h2
                                    class="text-xl text-white font-semibold  dark:text-white"
                                >
                                    Restroom
                                </h2>

                                <p class="mt-4 text-sm/relaxed">
                                    <img  width="552" height="368" src="https://lh3.googleusercontent.com/proxy/xbUNJ_1EviRkvAF0rx83mOhvmzTKRfFpy3iCj38HcZ0XDW0f3T5rI2oX8bpCRB8bMGTIp9dXU4mEdjJQmEoxQzBbkfipBd8Eo8mc52Tr_wJ25Nsy8WeLDCFutXcSLMDX83QC-GNn1lIiFv_qn7fMy7g2VU8ycxLS-dCGuj0tCKzZI3AG6wSkWVQrhpjf2JHkfw" alt="Edsen Villas" class="mx-auto rounded-lg shadow-lg" style="max-width: 100%; height: auto;border:20px solid #1d594e">
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-4  p-6  ring-1 ring-white/[0.05] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800"
                        >
                           

                            <div class="pt-3 sm:pt-5">
                                <h2
                                    class="text-xl text-white font-semibold  dark:text-white"
                                >
                                    Outdoor scenery
                                </h2>

                                <p class="mt-4 text-sm/relaxed">
                                   <img  src="https://media.istockphoto.com/id/149360161/photo/manicured-house-and-garden.jpg?s=612x612&w=0&k=20&c=QM7ussZ_9IjiMbUUIusbKmXNRgTYy__C1XpZnQx2BKQ=" alt="Edsen Villas" class="mx-auto rounded-lg shadow-lg" style="border:20px solid #1d594e;max-width: 100%; height: auto;">
                                </p>
                            </div>
                        </div>
                        
                    </div>
  
                </main>
                                 
            </div>
        </div>

          
    </div>
    <footer class="bg-[#0f443b] text-white py-4">
      <div class="text-center">
        Developed by Alexander Timbal
      </div>
    </footer>
</template>

<style>
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>

<style>
/* Add to your global CSS (resources/css/app.css) */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeInUp {
  animation: fadeInUp 0.8s ease-in-out forwards;
}

  /* custom cursor element */
  .custom-cursor {
    width: 20px;
    height: 20px;
    border: 2px solid #1abc9c;
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    transform: translate(-50%, -50%);
    transition: transform 0.1s ease, background 0.2s ease, width 0.2s ease, height 0.2s ease;
    z-index: 9999;
  }

  body:hover .custom-cursor {
    background: rgba(26, 188, 156, 0.3);
    width: 30px;
    height: 30px;
  }
</style>
<style>

:root {
    --active-color: hsl(204 100 53);
    --bg-color: #e1e3e5;
    --icon-default: hsl(203 5 75);
    --icon-accent: hsl(203 15 98);
    --navigation-color: hsl(203 5 25 / 0.3);
}


.image-slider {
    display: flex;
    flex-flow: column;
    width: clamp(360px, 96vw, 830px);
    aspect-ratio: 16 / 9;
    min-height: 300px;
    overflow: hidden;
    border-radius: 8px;
    container-type: inline-size;
    contain: content;
    background-color: #0006;
    box-shadow: rgba(0, 0, 0, 0.2) 0px 1px 2px, rgba(0, 0, 0, 0.3) 0px 2px 4px,
        rgba(0, 0, 0, 0.25) 0px 4px 8px, rgba(0, 0, 0, 0.2) 0px 8px 16px,
        rgba(0, 0, 0, 0.15) 0px 16px 32px;
}

.slider__content {
    flex-grow: 1;
    display: flex;
    justify-content: space-between;
}

.slider-control--button {
    border: 0;
    background: 0;
    outline: 0;
    cursor: pointer;
    place-content: center;
    padding-inline: 3vw;
    z-index: 1;
    display: grid;
}

.icon {
    height: 2rem;
    width: 2rem;
    fill: var(--icon-default);
    border-radius: 50%;
}

.slider-control--button:where(:hover) {
    background-image: linear-gradient(
        to var(--position),
        #0000 0%,
        #0002,
        80%,
        #0006 100%
    );
    .icon {
        fill: var(--icon-accent);
        background: #0001;
    }
}

.slider-control--button:active {
    outline: 0.2em solid hsl(204 100 53);
    outline-offset: -0.5em;
}

.prev-button {
    --position: left;
}
.next-button {
    --position: right;
}

.image-display {
    position: fixed;
    inset: 0;
}

.slider-navigation {
    z-index: 10;
    display: grid;
    grid-auto-flow: column;
    grid-template-columns: repeat(6, 1fr);
    grid-auto-columns: 100%;
    gap: 1.25rem;
    padding: 1rem;
    place-content: center;
    background-color: var(--navigation-color);
    backdrop-filter: blur(6px);
}

.nav-button {
    display: grid;
    width: 100%;
    height: 100%;
    border-radius: 0.5em;
    overflow: hidden;
    align-items: center;
    justify-content: center;
    border: 0;
    aspect-ratio: 16 / 9;
    transition: filter 150ms linear, scale 266ms ease;
}

.thumbnail {
    display: block;
    max-width: 100%;
    width: 100%;
    object-fit: cover;
    height: 100%;
}

.nav-button[aria-selected="true"] {
    scale: 1.1;
}

.nav-button[aria-selected="true"],
.nav-button:focus-visible {
    outline: 0.2em solid var(--active-color);
    outline-offset: 0.2em;
}

.nav-button[aria-selected="false"] {
    filter: opacity(0.7);
}

.nav-button[aria-selected="false"]:where(:hover, :focus-visible) {
    filter: opacity(1);
}

@container (max-width: 660px) {
    .nav-button:not(:has(img)) {
        background-color: rgb(241, 235, 232);
    }

    .slider-navigation {
        display: flex;
        justify-content: center;
        padding-block: 1.5em;
    }

    .nav-button {
        inline-size: 0.625rem;
        aspect-ratio: 1;
        border-radius: 50%;
    }

    .nav-button > .thumbnail {
        display: none;
    }

    .nav-button[aria-selected="true"] {
        background-color: black;
        scale: 1.5;
    }
}
        </style>