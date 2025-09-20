<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import { useForm,Link } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  room_number: 1,
  price: '',
  status: 'available'
})

function submit() {
  form.post('/rooms')
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
                        <main class="flex-1 bg-white p-6">
                          <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                          <h1 class="text-2xl font-bold mb-4 text-slate-600">Add Room</h1>
                          
                          <form @submit.prevent="submit" class="space-y-4">
                            <div>
                              <input 
                                v-model="form.name" 
                                placeholder="Room name" 
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" 
                              />
                              <span v-if="form.errors.name" class="text-red-500 text-sm">
                                {{ form.errors.name }}
                              </span>
                            </div>

                            <div>
                              <label class="block mb-1">Room Number</label>
                              <input 
                                v-model="form.room_number" 
                                type="number" 
                                placeholder="Room #" 
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" 
                              />
                             <span v-if="form.errors.room_number" class="text-red-500 text-sm">
                                {{ form.errors.room_number }}
                              </span>
                            </div>

                            <div>
                              <label class="block mb-1">Price</label>
                              <input 
                                v-model="form.price" 
                                type="number"
                                placeholder="Price"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" 
                              />
                               <span v-if="form.errors.price" class="text-red-500 text-sm">
                                {{ form.errors.price }}
                              </span>
                            </div>

                            <div>
                              <label class="block mb-1">Status</label>
                              <select 
                                v-model="form.status" 
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                              </select>
                              <span v-if="form.errors.status" class="text-red-500 text-sm">
                                {{ form.errors.status }}
                              </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button 
                                  type="submit" 
                                  class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                  :disabled="form.processing">
                                  Save
                                </button>
                                <Link href="/rooms" 
                                  class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                                >
                                  Cancel
                                </Link>
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


