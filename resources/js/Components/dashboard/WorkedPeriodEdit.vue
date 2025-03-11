<template>
  <div class="flex flex-col w-full">
    <div class="flex items-center mb-2">
      <!-- Time inputs -->
      <input 
        type="time" 
        v-model="form.start" 
        class="border rounded px-2 py-1 mr-2 w-24"
      >
      <span>-</span>
      <input 
        type="time" 
        v-model="form.end" 
        class="border rounded px-2 py-1 ml-2 w-24"
      >
      
      <!-- Tag input -->
      <input 
        type="text" 
        v-model="form.tag" 
        placeholder="Tag" 
        class="border rounded px-2 py-1 ml-3 mr-2"
      >

      <!-- Save button -->
      <img src="../../../images/icons/save-icon.svg" 
        width="18" 
        class="col-span-1 mr-2 cursor-pointer" 
        @click="save"
      >
      
      <!-- Cancel button -->
      <img src="../../../images/icons/cancel-icon.svg" 
        width="18" 
        class="col-span-1 mr-2 cursor-pointer"
        @click="cancel"
      >
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { useGlobalStore } from '@/Stores/global-store';

const props = defineProps({
  time: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['cancel', 'saved']);
const globalStore = useGlobalStore();

const form = ref({
  date: '',
  start: '',
  end: '',
  tag: ''
});

onMounted(() => {
  // Initialize form with time data
  form.value = {
    date: props.time.date,
    start: props.time.start,
    end: props.time.end,
    tag: props.time.tag ? props.time.tag.label : ''
  };
});

const save = async () => {
  const inertiaForm = useForm({
    date: form.value.date,
    start: form.value.start,
    end: form.value.end,
    tag: form.value.tag
  });

  inertiaForm.put(`/workedPeriod/${props.time.id}`, {
    onSuccess: async () => {
      await globalStore.fetchTimes();
      emit('saved');
    }
  });
};

const cancel = () => {
  emit('cancel');
};
</script>