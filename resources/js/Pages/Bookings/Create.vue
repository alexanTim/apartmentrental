<script setup>
import { watch,computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';

const props = defineProps({
  tenants: Array,
  rooms: Array,
})

// const isShowMonthly = computed(() => {
//   return form.stay_type && form.length_stay !== ''     
// })


const form = useForm({
  create_booking: false,
  tenant_id: '',
  room_id: '',
  start_date: '',
  end_date: '',
  total_price: '',
  status: 'pending',
  notes: '',
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

const submit = () => {
  form.post('/bookings')
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
       
        <div class="py-4">
            <div class="w-full px-4 lg:px-4">
  <!-- Your content goes here -->
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-2 text-gray-900 dark:text-gray-100">
                       <div class="flex">   
                        <Sidebar />

                        <!-- Main Content -->
                        <main class="flex-1 p-6 w-full mx-auto overflow-y-auto" style="max-height: 200vh;">
                         <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                            <h1 class="text-2xl font-bold mb-4 text-slate-600">Create Booking</h1>

                            <form @submit.prevent="submit" class="space-y-4">
                              <!-- Tenant -->
                              <div>
                                <label class="block font-medium">Tenant</label>
                                <select v-model="form.tenant_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                  <option disabled value="">Select Tenant</option>
                                  <option v-for="t in tenants" :key="t.id" :value="t.id">{{ t.name }}</option>
                                </select>
                                <span v-if="form.errors.tenant_id" class="text-red-500 text-sm">{{ form.errors.tenant_id }}</span>
                              </div>

                              <!-- Room -->
                              <div>
                                <label class="block font-medium">Room</label>
                                <select v-model="form.room_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                  <option disabled value="">Select Room</option>
                                  <option v-for="r in rooms" :key="r.id" :value="r.id">{{ r.room_number }} - ₱{{ r.price }}</option>
                                </select>
                                <span v-if="form.errors.room_id" class="text-red-500 text-sm">{{ form.errors.room_id }}</span>
                              </div>
                              
                             <div class="">
                                <label for="stay_type" class="block font-medium">
                                    Stay Type
                                </label>
                                <select
                                  id="stay_type"
                                  name="stay_type"
                                  v-model="form.stay_type"
                                  class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full"
                                >
                                  <option value="">-- Select Stay Type --</option>
                                  <option value="transient">Transient (Short-term)</option>
                                  <option value="monthly">Monthly (Long-term)</option>
                                </select>
                                <span v-if="form.errors.stay_type" class="text-red-500 text-sm">{{ form.errors.stay_type }}</span>
                              </div>

                              <div 
                                v-if="form.stay_type === 'monthly'" class="mb-4">
                                <label 
                                  class="inline-flex items-center">

                                  <input 
                                    type="checkbox"
                                    v-model="form.open_ended"                                    
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" 
                                  />
                                    <span 
                                      class="ml-2">
                                      Indefinite stay (open-ended)
                                    </span>
                                </label>
                              </div>

                              <div>
                                  <!-- Length of Stay -->
                                <div>
                                  <div v-if="form.stay_type && form.open_ended==false" class="mb-4">                                
                                      <label for="length_stay" class="block text-sm font-medium text-gray-700">
                                        {{ form.stay_type === 'transient' ? 'Number of Days' : 'Number of Months' }}
                                      </label>
                                      <select
                                        id="length_stay"
                                        v-model="form.length_stay"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full"
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
                                </div>
                              </div>
                              <!-- Dates -->
                              <div class="grid grid-cols-2 gap-4">
                                <div>
                                  <label class="block font-medium">Start Date</label>
                                  <input v-model="form.start_date" type="date" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                                  <span v-if="form.errors.start_date" class="text-red-500 text-sm">{{ form.errors.start_date }}</span>
                                </div>

                                <div v-if=" form.open_ended==false">
                                  <label class="block font-medium">End Date</label>
                                  <input v-model="form.end_date" type="date" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                                  <span v-if="form.errors.end_date" class="text-red-500 text-sm">{{ form.errors.end_date }}</span>
                                </div>
                              </div>
                             
                              <!-- Status -->
                              <div>
                                <label class="block font-medium">Status</label>
                                <select v-model="form.status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                  <option value="pending">Pending</option>
                                  <option value="confirmed">Confirmed</option>
                                  <option value="checked_in">Checked In</option>
                                  <option value="checked_out">Checked Out</option>
                                  <option value="cancelled">Cancelled</option>
                                </select>
                                <span v-if="form.errors.status" class="text-red-500 text-sm">{{ form.errors.status }}</span>
                              </div>

                              <!-- Notes -->
                              <div>
                                <label class="block font-medium">Notes</label>
                                <textarea v-model="form.notes" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full"></textarea>
                                <span v-if="form.errors.notes" class="text-red-500 text-sm">{{ form.errors.notes }}</span>
                              </div>

                              <!-- Buttons -->
                              <div class="flex items-center space-x-2">
                                <button type="submit" 
                                  class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                  :disabled="form.processing">
                                  Save
                                </button>
                                <Link 
                                  href="/bookings"
                                  class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                                  >Cancel</Link>
                              </div>
                            </form>
                          </div>
                        </main>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


