<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>


<template>

<AuthenticatedLayout>       
        <div class="py-4">
            <div class="w-full px-4 lg:px-4">
  <!-- Your content goes here -->
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-2 text-gray-900 dark:text-gray-100">
                       <div class="flex ">   
                       <Sidebar />

                        <!-- Main Content -->
                        <main class="flex-1 p-6 w-full mx-auto overflow-y-auto" style="max-height: 80vh;">
                       
                           <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-gray-100 rounded-lg shadow-md">
                              <div class="py-12">
                                <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                                    <div
                                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                                    >
                                        <UpdateProfileInformationForm
                                            :must-verify-email="mustVerifyEmail"
                                            :status="status"
                                            class="max-w-xl"
                                        />
                                    </div>

                                    <div
                                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                                    >
                                        <UpdatePasswordForm class="max-w-xl" />
                                    </div>

                                    <div
                                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                                    >
                                        <DeleteUserForm class="max-w-xl" />
                                    </div>
                                </div>
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

