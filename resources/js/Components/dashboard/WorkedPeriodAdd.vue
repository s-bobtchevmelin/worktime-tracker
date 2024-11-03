<template>
  <div class="mb-10">
    <form @submit.prevent="add" class=" mt-3"> 
      <div class="flex items-center mb-3">
        <span>Le</span>
        <InputSelect v-model="day" :options="days" class="mx-3 w-5/12 md:w-6/12" dense></InputSelect>
        <Tagger v-model="tag" :tags="tags" class="w-6/12 md:w-7/12"></Tagger>
      </div>
      
      <div class="flex items-center">
        <span>De</span>
        <InputDefault v-model="form.start" type="time" class="mx-3" dense />
        <span>à</span>
        <InputDefault v-model="form.end" type="time" class="mx-3" dense />

        <SecondaryButton type="submit" dense>
          <img src="../../../images/add-icon.svg" width="18" style="max-width: unset;">
        </SecondaryButton>
      </div>
    </form>

    <div class="mt-3 text-red-600">
      <div v-for="error in form.errors">{{ error }}</div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useGlobalStore } from '@/Stores/global-store';
import { useForm } from '@inertiajs/vue3';
import { dbDateFormat } from "@/Composables/dateTimesUtils"

import SecondaryButton from '../SecondaryButton.vue';
import InputDefault from '../InputDefault.vue';
import InputSelect from '../InputSelect.vue';
import Tagger from '../Tagger.vue';

const props = defineProps({days: Array, errors: Object, tags: Array})
const globalStore = useGlobalStore()

const day = ref(null)
const tag = ref(null)
const form = useForm({
  start: null,
  end: null
})

const add = async () => {
  if(!form.start || !form.end) return;

  const dayIndex = props.days.indexOf(day.value)
  
  form
    .transform(data => ({
      date: dbDateFormat(globalStore.activeWeek[0].clone().add(dayIndex, 'days')),
      start: data.start + ':00',
      end: data.end + ':00',
      tag: tag
    }))
    .post('/workedPeriod', {
      onSuccess: async () => {
        await globalStore.fetchTimes()
        form.reset()
      }
    })
};
</script>