<script setup>
import { watch,computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';

const form = useForm({
  category: 'maintenance',
  description: '',
  amount: '',
  expense_date: '',
  payment_method: 'cash',
  notes: '',
});

function submit() {
  form.post('/expenses');
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
                            <h1 class="text-2xl font-bold mb-4 text-slate-600">Add Expense</h1>

                            <form @submit.prevent="submit" class="space-y-4">
                              <div>
                                <label class="block">Category</label>
                                <select v-model="form.category" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                  <option value="maintenance">Maintenance</option>
                                  <option value="utilities">Utilities</option>
                                  <option value="supplies">Supplies</option>
                                  <option value="other">Other</option>
                                </select>
                                <span v-if="form.errors.category" class="text-red-500 text-sm text-sm">{{ form.errors.category }}</span>
                              </div>

                              <div>
                                <label class="block">Description</label>
                                <input type="text" v-model="form.description" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                                 <span v-if="form.errors.description" class="text-red-500 text-sm text-sm">{{ form.errors.description }}</span>
                              </div>

                              <div>
                                <label class="block">Amount</label>
                                <input type="number" step="0.01" v-model="form.amount" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                                 <span v-if="form.errors.amount" class="text-red-500 text-sm text-sm">{{ form.errors.amount }}</span>
                              </div>

                              <div>
                                <label class="block">Expense Date</label>
                                <input type="date" v-model="form.expense_date" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                                 <span v-if="form.errors.expense_date" class="text-red-500 text-sm text-sm">{{ form.errors.expense_date }}</span>
                              </div>

                              <div>
                                <label class="block">Payment Method</label>
                                <select v-model="form.payment_method" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                  <option value="cash">Cash</option>
                                  <option value="gcash">GCash</option>
                                  <option value="bank_transfer">Bank Transfer</option>
                                  <option value="credit_card">Credit Card</option>
                                  <option value="other">Other</option>
                                </select>
                                 <span v-if="form.errors.payment_method" class="text-red-500 text-sm text-sm">{{ form.errors.payment_method }}</span>
                              </div>

                              <div>
                                <label class="block">Notes</label>
                                <textarea v-model="form.notes" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full"></textarea>
                                 <span v-if="form.errors.notes" class="text-red-500 text-sm text-sm">{{ form.errors.notes }}</span>
                              </div>

                                <!-- Buttons -->
                              <div class="flex items-center space-x-2">
                                <button type="submit" 
                                  class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                  :disabled="form.processing">
                                  Save
                                </button>
                                <Link 
                                  href="/expenses"
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


