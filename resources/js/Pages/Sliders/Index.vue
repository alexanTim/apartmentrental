
<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import draggable from 'vuedraggable';
import Sidebar from '@/Components/Sidebar.vue';
const props = defineProps({ sliders: Array });
const slidersData = ref([...props.sliders]);

// Drag-and-drop order update
const updateOrder = () => {
  const orderData = slidersData.value.map((slider, index) => ({
    id: slider.id,
    order: index
  }));

  // Optimistically update UI (already done by v-model)
  // Then persist to server
  Inertia.post('/admin/sliders/order', { sliders: orderData }, { preserveState: true });
}

// Inline image update
const updateImage = (slider) => (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const data = new FormData();
  data.append('image', file);

  // Update local image immediately for real-time feel
  slider.image = URL.createObjectURL(file);

  Inertia.post(`/admin/sliders/${slider.id}/image`, data, { preserveState: true });
}

// Delete slider
const deleteSlider = (slider) => {
  if (!confirm('Are you sure?')) return;
  slidersData.value = slidersData.value.filter(s => s.id !== slider.id); // remove immediately
  Inertia.delete(`/admin/sliders/${slider.id}`, { preserveState: true });
}

const form = ref({
  title: '',
  subtitle: '',
  image: null,
  url: '',
  status: 1
});

const handleImage = (e) => { form.value.image = e.target.files[0]; }

const addSlider = () => {
  const data = new FormData();
  for (const key in form.value) data.append(key, form.value[key]);
  Inertia.post('/admin/sliders', data);
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
                              <div>
                              <h2 class="text-xl font-bold mb-4">Sliders</h2>

                              <!-- Add Slider Form -->
                              <form @submit.prevent="addSlider" class="mb-6 flex flex-wrap gap-2">
                                <input 
                                    v-model="form.title" 
                                    placeholder="Title" 
                                    class="border px-2 py-1"
                                />

                                <input 
                                    v-model="form.subtitle" 
                                    placeholder="Subtitle" 
                                    class="border px-2 py-1"
                                />

                                <input 
                                    type="file" 
                                    @change="handleImage" 
                                    class="border px-2 py-1"
                                />
                                
                                <input 
                                    v-model="form.url" 
                                    placeholder="URL" 
                                    class="border px-2 py-1"
                                />
                                
                                <label class="flex items-center gap-1">
                                  <input 
                                    type="checkbox" 
                                    v-model="form.status"
                                  /> Active
                                </label>

                                <button 
                                    type="submit" 
                                    class="bg-green-500 text-white px-4 py-2 rounded">
                                    Add
                                </button>
                              </form>

                              <!-- Sliders Table with Drag-and-Drop -->
                              <draggable v-model="slidersData" @end="updateOrder" class="space-y-2">
                                <template #item="{ element: slider }">
                                  <div class="flex items-center border p-2 rounded bg-white shadow">
                                    <img :src="`/storage/${slider.image}`" class="h-16 w-32 object-cover mr-4"/>
                                    <div class="flex-1">
                                      <div><strong>{{ slider.title }}</strong></div>
                                      <div>{{ slider.subtitle }}</div>
                                    </div>
                                    <span :class="slider.status ? 'bg-green-500 text-white px-2 py-1 rounded' : 'bg-red-500 text-white px-2 py-1 rounded'">
                                      {{ slider.status ? 'Active' : 'Inactive' }}
                                    </span>
                                    <div class="ml-4 flex gap-2">
                                      <input type="file" @change="updateImage(slider)" class="border px-2 py-1"/>
                                      <button @click="deleteSlider(slider)" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                    </div>
                                  </div>
                                </template>
                              </draggable>
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


