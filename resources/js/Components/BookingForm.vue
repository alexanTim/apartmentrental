<script setup>
import { computed } from 'vue';

const props = defineProps({
   form: Object, // <-- form instance from parent
   rooms: Array
})

const emit = defineEmits(['submit','cancel'])

function submit() {
  emit('submit')
}

function cancel() {
  emit('cancel')
}

// compute selected room
const selectedRoom = computed(() =>
  props.rooms.find(r => r.id === props.form.room_id)
);

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>



<template>
 
    <!-- Left: Reservation Form -->
    <div style="border:10px solid #11846f"
     class="bg-[#436d66] bg-opacity-50 mb-5 dark:bg-gray-900 rounded-md w-full max-w-3xl md:max-w-3xl max-h-[90vh]
     p-6 flex  sm:flex-row pb-32 xs:flex-row md:flex-row gap-6 overflow-y-auto ">
      

      <!-- Your existing form here -->
      <form @submit.prevent="submit" class="grid grid-cols-1 w-full md:grid-cols-2 gap-4 sx:w-1/2 max-w-2xl md:w-1/2 sx:w-1/2 sm:w-1/2 col-span-2 mt-10 md:col-span-1">

      <div class="col-span-2 flex justify-center">
      <h2 class="w-full text-xl font-semibold mb-4 text-center text-white">Reservation Form</h2>
      </div>
        <!-- First Name -->
        <div class="col-span-2 mb-4 md:col-span-1 max-w-screen-sm">
          <label class="block mb-1 font-semibold text-white" for="firstName">Name</label>
          <input id="firstName" v-model="form.name" type="text" class="italic text-[#888] w-full  bg-[#fff] border-4 border-[#eee] p-2 rounded" />
          <p v-if="form.errors.name" class="text-gray-50 text-sm">{{ form.errors.name }}</p>
        </div>

        <!-- Email -->
          <div class="col-span-2   mb-4 md:col-span-1">
          <label class="block mb-1 font-semibold text-white" for="email">Email</label>
          <input id="email" v-model="form.email" type="email" class="italic text-[#888] w-full  bg-[##fff] border-4 border-[#eee] p-2 rounded" />
          <p v-if="form.errors.email" class="text-gray-50 text-sm">{{ form.errors.email }}</p>
        </div>

        <!-- Telephone -->
        <div class="col-span-2  mb-4  md:col-span-1">
          <label class="block mb-1 font-semibold text-white" for="telephone">Telephone</label>
          <input id="telephone" v-model="form.telephone" type="text" class="italic text-[#888] w-full  bg-[##fff] border-4 border-[#eee] p-2 rounded" />
          <p v-if="form.errors.telephone" class="text-gray-50 text-sm">{{ form.errors.telephone }}</p>
        </div>

        <div class="col-span-2  mb-4  md:col-span-1">
          <label class="block mb-1 font-semibold text-white">Room</label>
          <select v-model="form.room_id" class="italic text-[#888] w-full  bg-[##fff] border-4 border-[#eee] p-2 rounded" :disabled="rooms.length === 0">
            <option disabled value="">
              {{ rooms.length === 0 ? 'No available rooms' : 'Select Room' }}
            </option>
            <option v-for="r in rooms" :key="r.id" :value="r.id">
              {{ r.room_number }} - ₱{{ r.price }}
            </option>
          </select>
          <span v-if="form.errors.room_id" class="text-gray-50 text-sm">{{ form.errors.room_id }}</span>
        </div>                              

        <!-- Stay Type -->
          <div class="col-span-2  mb-4 ">
          <label for="stay_type" class="block mb-1 font-semibold text-white">Stay Type</label>
          <select
            id="stay_type"
            name="stay_type"
            v-model="form.stay_type"
            class="italic text-[#888] w-full  bg-[#fff] border-4 border-[#eee] p-2 rounded"
          >
            <option value="">-- Select Stay Type --</option>
            <option value="transient">Transient (Short-term)</option>
            <option value="monthly">Monthly (Long-term)</option>
          </select>
          <span v-if="form.errors.stay_type" class="text-gray-50 text-sm">{{ form.errors.stay_type }}</span>
        </div>

        <!-- Open Ended (only for monthly) -->
        <div v-if="form.stay_type === 'monthly'"  class="col-span-2  mb-4 ">
          <label class="inline-flex items-center">
            <input 
              type="checkbox"
              v-model="form.open_ended"                                    
              class="italic text-white  bg-[#598981] border-4 border-[#eee] p-2 rounded" 
            />
            <span class="ml-2 block mb-1 font-semibold text-white">Indefinite stay (open-ended)</span>
          </label>
        </div>

        <!-- Length Stay select -->
        <div v-if="form.stay_type && form.open_ended==false"   class="col-span-2  mb-4 ">
          <label for="length_stay" class="block text-sm font-medium text-white">
            {{ form.stay_type === 'transient' ? 'Number of Days' : 'Number of Months' }}
          </label>
          <select
            id="length_stay"
            v-model="form.length_stay"
            class="italic text-[#888] w-full  bg-[#fff] border-4 border-[#eee] p-2 rounded"
          >
            <option value="">-- Select --</option>

            <!-- Transient options -->
            <option v-if="form.stay_type === 'transient'" v-for="day in 30" :key="day" :value="day">
              {{ day }} day<span v-if="day > 1">s</span>
            </option>

            <!-- Monthly options -->
            <option v-if="form.stay_type === 'monthly'" v-for="month in 12" :key="month" :value="month">
              {{ month }} month<span v-if="month > 1">s</span>
            </option>
          </select>   
        </div>

        <div class="col-span-2  md:col-span-1  mb-4 ">
          <label class="block mb-1 font-semibold text-white">Start Date</label>
          <input v-model="form.start_date" type="date" class="italic text-[#888] w-full  bg-[#fff] border-4 border-[#eee] p-2 rounded" />
          <span v-if="form.errors.start_date" class="text-gray-50 text-sm">{{ form.errors.start_date }}</span>
        </div>

        <div v-if=" form.open_ended==false"  class="col-span-2   mb-4  md:col-span-1">
          <label class="block mb-1 font-semibold text-white">End Date</label>
          <input v-model="form.end_date" type="date" class="italic text-[#888] w-full  bg-[#fff] border-4 border-[#eee] p-2 rounded" />
          <span v-if="form.errors.end_date" class="text-gray-50 text-sm">{{ form.errors.end_date }}</span>
        </div>  

      <div class="col-span-2 w-full flex flex-col sm:flex-row justify-between gap-2">

      <!-- Submit Button (always right) -->
        <button 
          v-if="rooms.length > 0" 
          type="submit" 
          class="bg-[#11846f] text-white px-4 py-2 rounded w-full sm:w-auto"
        >
          Submit
        </button>
        <!-- Cancel Button (always left) -->
        <button 
          type="button"
          @click="cancel"
          class="bg-gray-300 text-black px-4 py-2 rounded w-full sm:w-auto"
        >
          Cancel
        </button>

        

        <!-- Span -->
        <span 
          v-if="rooms.length === 0" 
          class="text-gray-50 text-sm w-full text-center sm:w-auto sm:text-right mt-2 sm:mt-0"
        >
          No available rooms for booking.
        </span>
      </div>


        <div style="height: 10px;"></div>
      </form>
      <!-- ... -->


    <!-- Right: Availability Panel -->
    <!-- Right: Availability Panel -->
    <div class="bg-white dark:bg-gray-900 rounded-lg w-full md:w-1/2 sx:w-1/2 sm:w-1/2 max-h-[200vh] overflow-y-auto p-6 col-span-2  md:col-span-1 mt-14">
      <h2 class="text-xl font-semibold mb-4 text-center text-[#888] dark:text-white">
        Room Availability
      </h2>

      <div v-if="selectedRoom">
        <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">
          Room {{ selectedRoom.room_number }} - Price ₱{{ selectedRoom.price }}
        </h3>

        <div v-if="selectedRoom.bookings.length > 0">
        <span class="text-[#1c8c77] font-bold">Occupied Dates</span>
          <ul class="list-disc list-inside text-sm text-[#1c8c77] mt-4 dark:text-gray-300">
            <li class="mb-4" v-for="b in selectedRoom.bookings" :key="b.id">
               {{ formatDate(b.start_date)}} → {{ b.end_date ? formatDate(b.end_date): 'Open-ended' }}
            </li>
          </ul>
        </div>
        <div v-else class="text-sm text-green-600 dark:text-green-400">
          ✅ Available (no bookings yet)
        </div>
      </div>

      <div v-else class="text-sm text-gray-500 text-center">
        Please select a room to view availability
      </div>
     </div>
 </div>
 
</template>
