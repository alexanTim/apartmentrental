<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  filters: Object,
  expenses: Array,
  total: Number,
})

const form = ref({
  start_date: props.filters.start_date,
  end_date: props.filters.end_date,
  category: props.filters.category ?? '',
})

const submit = () => {
  router.get(route('reports.expenses'), form.value, { preserveState: true })
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
                        <main class="flex-1 p-6 w-full mx-auto overflow-y-auto" style="max-height: 80vh;">
                         <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                          <h2 class="text-2xl font-bold mb-4 text-slate-600">Expense Report</h2>

                          <!-- Filters -->
                          <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div>
                              <label class="block text-sm font-medium mb-1">Start Date</label>
                              <input type="date" v-model="form.start_date" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full border p-2" />
                            </div>

                            <div>
                              <label class="block text-sm font-medium mb-1">End Date</label>
                              <input type="date" v-model="form.end_date" class="w-full border rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" />
                            </div>

                            <div>
                              <label class="block text-sm font-medium mb-1">Category</label>
                              <select v-model="form.category" class="w-full border rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                                <option value="">All</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="utilities">Utilities</option>
                                <option value="supplies">Supplies</option>
                                <option value="other">Other</option>
                              </select>
                            </div>

                            <div class="flex items-end">
                              <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                Filter
                              </button>
                            </div>
                          </form>

                          <!-- ✅ Export Button goes here -->
                          <div class="flex justify-end mb-4">
                            <a :href="route('reports.expenses', { 
                                  start_date: form.start_date, 
                                  end_date: form.end_date, 
                                  category: form.category, 
                                  export: 'pdf' 
                                })"
                              class="bg-red-600 text-white px-4 py-2 rounded shadow">
                              Export to PDF
                            </a>
                          </div>
                          <!-- Table -->
                          <div class="overflow-x-auto">
                            <table class="w-full border border-gray-200 rounded-lg">
                              <thead class="bg-gray-100">
                                <tr>
                                  <th class="px-4 py-2 text-left">Date</th>
                                  <th class="px-4 py-2 text-left">Category</th>
                                  <th class="px-4 py-2 text-left">Description</th>
                                  <th class="px-4 py-2 text-right">Amount</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="expense in props.expenses" :key="expense.id" class="border-t">
                                  <td class="px-4 py-2">{{ expense.expense_date }}</td>
                                  <td class="px-4 py-2 capitalize">{{ expense.category }}</td>
                                  <td class="px-4 py-2">{{ expense.description }}</td>
                                  <td class="px-4 py-2 text-right">₱{{ expense.amount.toLocaleString() }}</td>
                                </tr>
                              </tbody>
                              <tfoot class="bg-gray-100 font-semibold">
                                <tr>
                                  <td colspan="3" class="px-4 py-2 text-right">Total:</td>
                                  <td class="px-4 py-2 text-right">₱{{ props.total.toLocaleString() }}</td>
                                </tr>
                              </tfoot>
                            </table>
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