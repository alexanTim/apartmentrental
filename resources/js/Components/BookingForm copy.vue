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

</script>



<template>
 
    <!-- Left: Reservation Form -->
    <div style="background-color: #427A70;"
     class="bg-white mb-5 dark:bg-gray-900 rounded-md w-full max-w-lg md:max-w-lg max-h-[90vh]
     p-6 flex-2  sm:flex-row pb-32 xs:flex-row md:flex-row gap-6 overflow-y-auto">
      

      <!-- Your existing form here -->
<form @submit.prevent="submit" class="grid grid-cols-1 w-full md:grid-cols-2 gap-4  max-w-lg  col-span-2 mb-8 md:col-span-1">

<div class="col-span-2 flex justify-center">
<h2 class="w-full text-xl font-semibold mb-4 text-center text-white">Reservation Form</h2>
</div>
  <!-- First Name -->
    <div class="col-span-2  md:col-span-1 max-w-screen-sm">
    <label class="block mb-1 font-semibold text-white" for="firstName">Name</label>
    <input id="firstName" v-model="form.name" type="text" class="w-full border p-2 rounded" />
    <p v-if="form.errors.name" class="text-gray-50 text-sm">{{ form.errors.name }}</p>
  </div>

  <!-- Email -->
    <div class="col-span-2  md:col-span-1">
    <label class="block mb-1 font-semibold text-white" for="email">Email</label>
    <input id="email" v-model="form.email" type="email" class="w-full border p-2 rounded" />
    <p v-if="form.errors.email" class="text-gray-50 text-sm">{{ form.errors.email }}</p>
  </div>

  <!-- Telephone -->
  <div class="col-span-2  md:col-span-1">
    <label class="block mb-1 font-semibold text-white" for="telephone">Telephone</label>
    <input id="telephone" v-model="form.telephone" type="text" class="w-full border p-2 rounded" />
    <p v-if="form.errors.telephone" class="text-gray-50 text-sm">{{ form.errors.telephone }}</p>
  </div>

  <div class="col-span-2  md:col-span-1">
    <label class="block mb-1 font-semibold text-white">Room</label>
    <select v-model="form.room_id" class="w-full border rounded p-2" :disabled="rooms.length === 0">
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
    <div class="col-span-2">
    <label for="stay_type" class="block mb-1 font-semibold text-white">Stay Type</label>
    <select
      id="stay_type"
      name="stay_type"
      v-model="form.stay_type"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    >
      <option value="">-- Select Stay Type --</option>
      <option value="transient">Transient (Short-term)</option>
      <option value="monthly">Monthly (Long-term)</option>
    </select>
    <span v-if="form.errors.stay_type" class="text-gray-50 text-sm">{{ form.errors.stay_type }}</span>
  </div>

  <!-- Open Ended (only for monthly) -->
  <div v-if="form.stay_type === 'monthly'"  class="col-span-2">
    <label class="inline-flex items-center">
      <input 
        type="checkbox"
        v-model="form.open_ended"                                    
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
      />
      <span class="ml-2 block mb-1 font-semibold text-white">Indefinite stay (open-ended)</span>
    </label>
  </div>

  <!-- Length Stay select -->
  <div v-if="form.stay_type && form.open_ended==false"   class="col-span-2">
    <label for="length_stay" class="block text-sm font-medium text-white">
      {{ form.stay_type === 'transient' ? 'Number of Days' : 'Number of Months' }}
    </label>
    <select
      id="length_stay"
      v-model="form.length_stay"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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

  <div class="col-span-2  md:col-span-1">
    <label class="block mb-1 font-semibold text-white">Start Date</label>
    <input v-model="form.start_date" type="date" class="w-full border rounded p-2" />
    <span v-if="form.errors.start_date" class="text-gray-50 text-sm">{{ form.errors.start_date }}</span>
  </div>

  <div v-if=" form.open_ended==false"  class="col-span-2  md:col-span-1">
    <label class="block mb-1 font-semibold text-white">End Date</label>
    <input v-model="form.end_date" type="date" class="w-full border rounded p-2" />
    <span v-if="form.errors.end_date" class="text-gray-50 text-sm">{{ form.errors.end_date }}</span>
  </div>  

  <!-- Buttons -->
  <div class="col-span-2 flex justify-between items-center mt-4">
  <button v-if="rooms.length > 0" type="submit" class="bg-slate-700 text-white px-4 py-2 rounded">Submit</button>
    <button type="button"
            @click="cancel"
            class="bg-gray-300 text-black px-4 py-2 rounded">
      Cancel
    </button>
    <span v-if="rooms.length === 0" class="text-gray-50 text-sm">No available rooms for booking.</span>
  </div>
</form>
      <!-- ... -->


    <!-- Right: Availability Panel -->
    <!-- Right: Availability Panel -->
    <div class="bg-white dark:bg-gray-900 rounded-lg w-full  p-6 col-span-2  md:col-span-1">
      <h2 class="text-xl font-semibold mb-4 text-center text-gray-800 dark:text-white">
        Room Availability
      </h2>

      <div v-if="selectedRoom">
        <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">
          Room {{ selectedRoom.room_number }} - ₱{{ selectedRoom.price }}
        </h3>

        <div v-if="selectedRoom.bookings.length > 0">
          <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-300">
            <li v-for="b in selectedRoom.bookings" :key="b.id">
              Occupied: {{ b.start_date }} → {{ b.end_date ?? 'Open-ended' }}
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
