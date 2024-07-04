<template>
  <div class="mb-10">
    <form @submit.prevent="add" class="flex items-center mt-3">
      <span>Le</span>
      <InputSelect v-model="day" :options="days" class="mx-3" dense></InputSelect>

      <span>De</span>
      <InputDefault v-model="startInput" type="time" class="mx-3" dense />
      <span>à</span>
      <InputDefault v-model="endInput" type="time" class="mx-3" dense />
      
      <SecondaryButton type="submit">Ajouter</SecondaryButton>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import SecondaryButton from './SecondaryButton.vue';
import InputDefault from './InputDefault.vue';
import InputSelect from './InputSelect.vue';

const emit = defineEmits(['addToTimes'])

const day = ref(null)
const startInput = ref(null);
const endInput = ref(null);

const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']

const add = async () => {
  if(!startInput.value || !endInput.value) return;
  emit('addToTimes', {day: day.value, value: [startInput.value, endInput.value]})
  startInput.value = null
  endInput.value = null
};
</script>