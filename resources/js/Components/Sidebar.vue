<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'
const isActive = (name) => route().current(name)

</script>
<template>
  <aside class="w-64 text-black flex flex-col border-gray-400 dark:bg-gray-800">
    <!-- Brand / Logo -->
    <div class="p-6 text-2xl font-bold text-left text-slate-600 dark:text-white">
      Edsen Villa Management
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 space-y-2">
      <Link
         :href="route('dashboard')"
         :class="isActive('dashboard') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500  dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
        
      >
        Dashboard
      </Link>

      <Link
        :href="route('bookings.index')"       
        :class="isActive('bookings.index') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
      >
        Bookings
      </Link>

       <Link
        :href="route('rooms.index')"       
        :class="isActive('rooms.index') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
      >
        Rooms
      </Link>

      <Link
        :href="route('tenants.index')"       
        :class="isActive('tenants.index') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
      >
        Tenants
      </Link>
      
      <Link
        :href="route('expenses.index')"       
        :class="isActive('expenses.index') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
      >
        Expenses
      </Link>

      <Link
        :href="route('reports.expenses')"       
        :class="isActive('reports.expenses') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
      >
        Reports
      </Link>
      <div>
      <Link
          :href="route('profile.edit')"
       :class="isActive('profile.edit') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"
      >
          Profile
      </Link>
      </div>

      <div>
        <Link :href="route('sliders.index')" 
        :class="isActive('sliders.index') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-slate-500 hover:text-slate-50'"      
        >
        <i class="icon-photograph"></i>
        <span>Content Slider</span>
        </Link>
      </div>
      <Link
          style="width:223px;text-align: left;"
          :href="route('logout')"
          method="post"    
       :class="isActive('profile.edit') ? 'hover:bg-slate-500 hover:text-slate-50 block px-4 py-2 rounded  bg-slate-500 dark:hover:bg-zinc-700 w-lg text-slate-50' : 'block px-4 py-2 rounded  bg-slate-200 dark:hover:bg-zinc-700 text-slate-800 hover:bg-red-600 hover:text-slate-50 w-lg'"
      >
          Log out
      </Link>
      
    </nav>
  </aside>
</template>

