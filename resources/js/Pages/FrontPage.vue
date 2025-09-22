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
import Testimonials from "@/Components/Testimonials.vue";
import ContentFeatured from "@/Components/ContentFeatured.vue";
import RoomSlider from "@/Components/RoomSlider.vue";


const images = [
  "/images/f1.png",
  "/images/f2.png",
  "/images/f3.png",
  "/images/f4.png",
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

const edSen = ref('EdSen Villa room for rent');
const HeaderCatchingText = ref("At EdSen Villa, every stay is more than just a rental — it's a retreat where comfort meets elegance, and every moment feels like home.")

watch(
  () => form.stay_type,
  (newVal, oldVal) => {      
    if(newVal == 'transient') {
      form.open_ended = false
      form.length_stay = 1
    } else if (newVal == 'monthly') {
      form.length_stay = 1
    }     
  })

watch(
  () => form.open_ended,
  (newVal) => {
    console.log('Open-ended status changed:', newVal)
    if (newVal) {
      form.length_stay = '' 
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
      console.log(errors)     
    }
  })
}

// from Inertia 
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
      new Slider(slider.value) 
    } 

   setTimeout(() => {
    isVisible.value = true;
  }, 500);
})
</script>

<template>
 
      <transition name="out-in">
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
  
    <Head title="Welcome" />
    <ScrollAnimate>
      <section> 
        <Slideshow :slides="images" :interval="3000" /> 
      </section>
    </ScrollAnimate>


    <div class="text-black/50 dark:bg-black dark:text-white/50">     
        <div class="pt-3 mb-5  sm:pt-5" style="padding: 12px;">    
         <ScrollAnimate>       
            <span class="block  text-[5em] text-center font-semibold text-white dark:text-white">
                {{ edSen }}
            </span>
         </ScrollAnimate>   

         <ScrollAnimate>   
            <div  class="mt-14 mb-20 text-white text-center text-lg">
            <p class="text-[22px] mt-14 mb-20 text-white text-center">
            {{ HeaderCatchingText }}
             </p>
            </div>
          </ScrollAnimate>  
          <ScrollAnimate>
            <div class="flex flex-col items-center mb-5">
            <a href="https://www.facebook.com/nheza.villafuerte">
              <svg style="border-radius: 23px;
              border: 4px solid #eee;
              width: 43px;
              height: 41px;
              padding: 4px;" fill="#ffffff" height="30px" width="30px" viewBox="-337 273 123.5 256" xmlns="http://www.w3.org/2000/svg">
                <path d="M-260.9,327.8c0-10.3,9.2-14,19.5-14c10.3,0,21.3,3.2,21.3,3.2l6.6-39.2c0,0-14-4.8-47.4-4.8c-20.5,0-32.4,7.8-41.1,19.3
                c-8.2,10.9-8.5,28.4-8.5,39.7v25.7H-337V396h26.5v133h49.6V396h39.3l2.9-38.3h-42.2V327.8z"/>
              </svg>
            </a>
            </div>
         
            <nav class="mb-1 -mx-3 flex flex-1 justify-center">                       
              <button 
                @click="showModal = true" 
                class="bg-[#09352d] hover:bg-[#2f9f8a] text-white font-semibold px-4 py-2 rounded-full border-[10px] border-[#169981] w-[300px] h-20" > Don't wait, Reserve Now! </button> 
            </nav>    
            </ScrollAnimate>     
        </div>

        <ScrollAnimate>
          <RoomSlider/>
        </ScrollAnimate>
        <ScrollAnimate>
          <ContentFeatured/>
        </ScrollAnimate> 
        <ScrollAnimate>
          <Testimonials/>
        </ScrollAnimate>          
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