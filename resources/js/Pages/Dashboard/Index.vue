<script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import Sidebar from '@/Components/Sidebar.vue';

  const props = defineProps({
    totalTenants: Number,
    totalBookings: Number,
    totalRevenue: Number,
    totalearnings: Number,
    totalExpenses: Number,
    tenantspercentageLastMonth: Number,
    expensesLastWeek: Number,
    earningsLastMonth: Number,
    percentageChange: Number,
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
                        <main class="flex-1 bg-white p-6">
                        <div class="border border-gray-300 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
                        
                        <h1 class="text-2xl text-slate-600 font-bold mb-4">Dashboard</h1>
                        <!-- Add your page content here -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Card 1 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tenants</h2>
                            <span class="p-2 bg-green-100 dark:bg-green-900 rounded-xl text-green-600 dark:text-green-300">
                                <!-- Example icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 11V3h2v8h-2zm0 4h2v6h-2v-6z" />
                                </svg>
                            </span>
                            </div>
                            <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">{{ totalTenants }}</p>
                            <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                            +{{ tenantspercentageLastMonth }}% from last month</p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Expenses</h2>
                            <span class="p-2 bg-blue-100 dark:bg-blue-900 rounded-xl text-blue-600 dark:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M12 14a4 4 0 100-8 4 4 0 000 8z"/>
                                </svg>
                            </span>
                            </div>
                            <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">P {{ totalExpenses }}</p>
                            <p class="text-sm text-blue-600 dark:text-blue-400 mt-2">+ {{ expensesLastWeek }} this week</p>
                        </div>

  <!-- Card 3 -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Earning</h2>
      <span class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-xl text-yellow-600 dark:text-yellow-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-7a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </span>
    </div>
    <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">P {{ totalearnings }}</p>
    <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-2">+{{ earningsLastMonth }} last month</p>
  </div>

  <!-- Card 4 -->
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Revenue</h2>
      <span class="p-2 bg-purple-100 dark:bg-purple-900 rounded-xl text-purple-600 dark:text-purple-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 16v-4"/>
        </svg>
      </span>
    </div>
    <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">₱ {{ totalRevenue }}</p>
    <p class="text-sm text-purple-600 dark:text-purple-400 mt-2">+{{percentageChange}}% from last week</p>
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







  <!-- <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-white p-4 rounded shadow border border-gray-200">
        <h2 class="font-semibold text-gray-700">Total Revenue</h2>
        <p class="text-xl font-bold mt-2">₱{{ totalRevenue.toLocaleString() }}</p>
      </div>

      <div class="bg-white p-4 rounded shadow border border-gray-200">
        <h2 class="font-semibold text-gray-700">Total Expenses</h2>
        <p class="text-xl font-bold mt-2">₱{{ totalExpenses.toLocaleString() }}</p>
      </div>

      <div class="bg-white p-4 rounded shadow border border-gray-200">
        <h2 class="font-semibold text-gray-700">Net Income</h2>
        <p class="text-xl font-bold mt-2">₱{{ (totalRevenue - totalExpenses).toLocaleString() }}</p>
      </div>
    </div>
  </div> -->


