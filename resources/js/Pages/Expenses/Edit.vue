<script setup>
import { watch,computed } from 'vue'
import { useForm ,Link} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
const props = defineProps({
  expense: Object,
});

const form = useForm({
  category: props.expense.category,
  description: props.expense.description,
  amount: props.expense.amount,
  expense_date: props.expense.expense_date,
  payment_method: props.expense.payment_method,
  notes: props.expense.notes,
});

const submit = () => {
  form.put(route('expenses.update', props.expense.id));
};
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
                       <main class="flex-1 p-6 w-full mx-auto overflow-y-auto" style="max-height: 100vh;">  
                         <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                          <h2 class="text-xl font-semibold mb-4">Edit Expense</h2>

                          <form @submit.prevent="submit" class="space-y-4">
                            <div>
                              <label class="block font-medium">Category</label>
                              <select v-model="form.category" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                <option value="maintenance">Maintenance</option>
                                <option value="utilities">Utilities</option>
                                <option value="supplies">Supplies</option>
                                <option value="other">Other</option>
                              </select>
                              <div v-if="form.errors.category" class="text-red-500 text-sm text-sm">{{ form.errors.category }}</div>
                            </div>

                            <div>
                              <label class="block font-medium">Description</label>
                              <input type="text" v-model="form.description" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                              <div v-if="form.errors.description" class="text-red-500 text-sm text-sm">{{ form.errors.description }}</div>
                            </div>

                            <div>
                              <label class="block font-medium">Amount</label>
                              <input type="number" step="0.01" v-model="form.amount" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                              <div v-if="form.errors.amount" class="text-red-500 text-sm text-sm">{{ form.errors.amount }}</div>
                            </div>

                            <div>
                              <label class="block font-medium">Expense Date</label>
                              <input type="date" v-model="form.expense_date" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                              <div v-if="form.errors.expense_date" class="text-red-500 text-sm text-sm">{{ form.errors.expense_date }}</div>
                            </div>

                            <div>
                              <label class="block font-medium">Payment Method</label>
                              <select v-model="form.payment_method" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                <option value="cash">Cash</option>
                                <option value="gcash">GCash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="other">Other</option>
                              </select>
                              <div v-if="form.errors.payment_method" class="text-red-500 text-sm text-sm">{{ form.errors.payment_method }}</div>
                            </div>

                            <div>
                              <label class="block font-medium">Notes</label>
                              <textarea v-model="form.notes" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full"></textarea>
                              <div v-if="form.errors.notes" class="text-red-500 text-sm text-sm">{{ form.errors.notes }}</div>
                            </div>

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


