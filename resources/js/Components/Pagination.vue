<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue';

const props = defineProps({
  ObjectName: Object,
  hrefValue: String
})  

// Compute pages array for links
const pages = computed(() => {
  const total = props.ObjectName.last_page;
  return Array.from({ length: total }, (_, i) => i + 1);
});
</script>

<template>
  <div class="flex justify-end gap-2 mt-4">
    <!-- Previous -->
    <Link
      v-if="props.ObjectName.prev_page_url"
      :href="props.ObjectName.prev_page_url"
      class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
    >
      Previous
    </Link>

    <!-- Pages -->
    <Link
      v-for="page in pages"
      :key="page"
      :href="`/${hrefValue}?page=${page}`"
      class="px-3 py-1 rounded"
      :class="page === props.ObjectName.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'"
    >
      {{ page }}
    </Link>

    <!-- Next -->
    <Link
      v-if="props.ObjectName.next_page_url"
      :href="props.ObjectName.next_page_url"
      class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
    >
      Next
    </Link>
  </div> 
</template>