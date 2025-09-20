<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import { Inertia } from '@inertiajs/inertia'
import { computed } from 'vue';
const props = defineProps({
  expenses: Object,
});

function deletebooking(id) {
  if (confirm('Are you sure you want to delete this expenses? ')) {
    Inertia.delete(`/bookings/${id}`)
  }
}

const pages = computed(() => {
  const total = props.expenses.last_page;
  return Array.from({ length: total }, (_, i) => i + 1);
});
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
                        <main class="flex-1 p-6 w-full mx-auto overflow-y-auto" style="max-height: 80vh;">
                           <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">

                           <div class="flex justify-between items-center mb-0">
                            <h1 class="text-2xl font-bold mb-4 text-slate-600">Expenses</h1>
                              <Link
                                  href="/expenses/create"
                                  class="px-4 py-2  bg-blue-600  text-white rounded mb-12"
                                >
                                  + Add Expenses
                                </Link>
                            </div>

                            <table class="mt-0 min-w-full bg-white shadow rounded-lg">
                              <thead class="bg-gray-100">
                                <tr>
                                  <th class="px-4 py-2 text-slate-700">Category</th>
                                  <th class="px-4 py-2 text-slate-700">Description</th>
                                  <th class="px-4 py-2 text-slate-700">Amount</th>
                                  <th class="px-4 py-2 text-slate-700">Date</th>
                                  <th class="px-4 py-2 text-slate-700">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="expense in expenses.data" :key="expense.id" class="border-t">
                                  <td class="px-4 py-2">{{ expense.category }}</td>
                                  <td class="px-4 py-2">{{ expense.description }}</td>
                                  <td class="px-4 py-2">₱{{ expense.amount }}</td>
                                  <td class="px-4 py-2">{{ expense.expense_date }}</td>
                                  <td class="px-4 py-2 space-x-2">
                                      <div class="ml-4 flex space-x-2">
                                 <Link :href="`/expenses/${expense.id}/edit`" class="text-blue-600">
                               
                                <svg  style="width: 20px;
  height: 21px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.548 3.452a1.542 1.542 0 0 1 0 2.182l-7.636 7.636-3.273 1.091 1.091-3.273 7.636-7.636a1.542 1.542 0 0 1 2.182 0zM4 21h15a1 1 0 0 0 1-1v-8a1 1 0 0 0-2 0v7H5V6h7a1 1 0 0 0 0-2H4a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1z"/></svg>
                                
</Link>
                                  <span>
                                 
<svg @click="deletebooking(expense.id)" style="width: 20px;height:20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><title>Artboard-15</title><g id="Trash"><rect x="6" y="1" width="13" height="1" style="fill:#232326"/><path d="M23,3H2V4H4V22.5A1.5017,1.5017,0,0,0,5.5,24h14A1.5017,1.5017,0,0,0,21,22.5V4h2ZM9,20H8V7H9Zm4,0H12V7h1Zm4,0H16V7h1Z" style="fill:#232326"/></g></svg></span>
  </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <div class="flex justify-end gap-2 mt-4">
                            <!-- Previous -->
                            <Link
                              v-if="expenses.prev_page_url"
                              :href="expenses.prev_page_url"
                              class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
                            >
                              Previous
                            </Link>

                            <!-- Pages -->
                            <Link
                              v-for="page in pages"
                              :key="page"
                              :href="`/expenses?page=${page}`"
                              class="px-3 py-1 rounded"
                              :class="page === expenses.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'"
                            >
                              {{ page }}
                            </Link>

                            <!-- Next -->
                            <Link
                              v-if="props.expenses.next_page_url"
                              :href="props.expenses.next_page_url"
                              class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
                            >
                              Next
                            </Link>
                          </div>
                          </div>                          
                        </main>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>