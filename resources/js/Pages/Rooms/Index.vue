<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
defineProps({
  rooms: Array
})

function deleteroom(id) {
  if (confirm('Are you sure you want to delete this room? All the associated bookings will be deleted')) {
    Inertia.delete(`/rooms/${id}`)
  }
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
                       <div class="flex h-screen">   
                        <Sidebar />

                        <!-- Main Content -->
                        <main class="flex-1 p-6 w-full mx-auto overflow-y-auto" style="max-height: 80vh;">
                         <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                         <div class="flex justify-between items-center mb-0">
                          <h1 class="text-2xl text-slate-600 font-bold mb-4">Rooms</h1>

                            <Link
                                href="/rooms/create"
                               class="px-4 py-2  bg-blue-600  text-white rounded mb-12"
                              >
                                + Add Room
                            </Link>
                          </div>
                         
                           <table class="min-w-full bg-white shadow rounded-lg mt-0">
                            <thead>
                              <tr>
                                <th class="px-4 py-2 text-slate-700 bg-gray-100">Room Name</th>
                                <th class="px-4 py-2 text-slate-700 bg-gray-100">Room #</th>
                                <th class="px-4 py-2 text-slate-700 bg-gray-100">Price</th>
                                <th class="px-4 py-2 text-slate-700 bg-gray-100">Status</th>
                                <th class="px-4 py-2 text-slate-700 bg-gray-100">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="room in rooms" :key="room.id">
                                <td class="p-2 border">{{ room.name }}</td>
                                <td class="p-2 border">{{ room.room_number }}</td>
                                <td class="p-2 border">P {{ room.price }}</td>
                                <td style="text-align: center; vertical-align: middle;" class="p-2 border text-center">
                                <div class="text-center flex justify-center items-center">
                                <svg v-if=" room.status =='available'" xmlns="http://www.w3.org/2000/svg" 
     viewBox="0 0 24 24" 
     fill="currentColor" 
     class="w-6 h-6 text-green-500 text-center">
  <path fill-rule="evenodd" d="M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5zm4.28 7.97a.75.75 0 00-1.06-1.06l-4.72 4.72-2.22-2.22a.75.75 0 10-1.06 1.06l2.75 2.75a.75.75 0 001.06 0l5.25-5.25z" clip-rule="evenodd" />
</svg></div>
</td>
                                <td class="p-2 border space-x-2">
                                 

                                <div class="ml-4 flex space-x-2">
                                  <Link :href="`/rooms/${room.id}/edit`" class="text-blue-600">                               
                                  <svg  style="width: 20px;
                                    height: 21px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M20.548 3.452a1.542 1.542 0 0 1 0 2.182l-7.636 7.636-3.273 1.091 1.091-3.273 7.636-7.636a1.542 1.542 0 0 1 2.182 0zM4 21h15a1 1 0 0 0 1-1v-8a1 1 0 0 0-2 0v7H5V6h7a1 1 0 0 0 0-2H4a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1z"/>
                                  </svg>                                                                
                                  </Link>
                                  <span
                                    as="button"
                                    @click="deleteroom(room.id)"                                  
                                  >
                                    <svg style="width: 20px;height:20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
                                      <title>Artboard-15</title><g id="Trash"><rect x="6" y="1" width="13" height="1" style="fill:#232326"/>
                                      <path d="M23,3H2V4H4V22.5A1.5017,1.5017,0,0,0,5.5,24h14A1.5017,1.5017,0,0,0,21,22.5V4h2ZM9,20H8V7H9Zm4,0H12V7h1Zm4,0H16V7h1Z" style="fill:#232326"/></g>
                                    </svg>
                                  </span>
                                
                                </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          </div>
                        </main>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>