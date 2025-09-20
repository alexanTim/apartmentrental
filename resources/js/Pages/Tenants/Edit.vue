<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';

const props = defineProps({
  tenant: Object
})

const form = useForm({
  name: props.tenant.name,
  email: props.tenant.email,
  phone: props.tenant.phone,
  tenant_type: props.tenant.tenant_type,
  address: props.tenant.address
})

const submit = () => {
  form.put(`/tenants/${props.tenant.id}`)
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
                        <main class="flex-1  p-6">
                          <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                          <h1 class="text-2xl font-bold mb-4">Edit Tenant</h1>

                          <form @submit.prevent="submit" class="space-y-4">
                            <div>
                              <label class="block font-medium">Name</label>
                              <input v-model="form.name" type="text" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                              <span v-if="form.errors.name" class="text-red-500 text-sm text-sm">{{ form.errors.name }}</span>
                            </div>

                            <div>
                              <label class="block font-medium">Email</label>
                              <input v-model="form.email" type="email" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                              <span v-if="form.errors.email" class="text-red-500 text-sm text-sm">{{ form.errors.email }}</span>
                            </div>

                            <div>
                              <label class="block font-medium">Phone</label>
                              <input v-model="form.phone" type="text" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full" />
                              <span v-if="form.errors.phone" class="text-red-500 text-sm text-sm">{{ form.errors.phone }}</span>
                            </div>

                            <div>
                              <label class="block font-medium">Tenant Type</label>
                              <select v-model="form.tenant_type" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full">
                                <option value="transient">Transient</option>
                                <option value="monthly">Monthly</option>
                              </select>
                              <span v-if="form.errors.tenant_type" class="text-red-500 text-sm text-sm">{{ form.errors.tenant_type }}</span>
                            </div>

                            <div>
                              <label class="block font-medium">Address</label>
                              <textarea v-model="form.address" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 mt-1 block w-full"></textarea>
                              <span v-if="form.errors.address" class="text-red-500 text-sm text-sm">{{ form.errors.address }}</span>
                            </div>

                            <div class="flex items-center space-x-2">
                              <button type="submit" 
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" 
                               :disabled="form.processing">
                                Update
                              </button>
                              <Link 
                                href="/tenants" 
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


