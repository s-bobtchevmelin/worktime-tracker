<template>
    <div class="mb-2">
      <form @submit.prevent="update" class="mt-1"> 
        <div class="flex flex-col md:flex-row lg:flex-col xl:flex-row ">
  
          <div class="flex items-center">
            <!-- Times -->
            <span>De</span>
            <InputDefault v-model="form.start" type="time" class="mx-3" dense />
            <span>à</span>
            <InputDefault v-model="form.end" type="time" class="mx-3" dense />
          </div>

          <div class="flex items-center pt-3 md:pt-0 lg:pt-3 xl:pt-0">
            <!-- Tag -->
            <Tagger v-model="form.tag" :tags="globalStore.tags" class=""></Tagger>
    
            <!-- Update button -->
            <SecondaryButton type="submit" class="ml-2 " dense>
              <img src="../../../images/icons/edit-icon-orange.svg" width="18" style="max-width: unset;">
            </SecondaryButton>
    
            <!-- Cancel button -->
            <SecondaryButton type="button" class="ml-2" dense @click="$emit('closeUpdateForm')">
              <img src="../../../images/icons/cancel-icon.svg" width="18" style="max-width: unset;">
            </SecondaryButton>
          </div>
  
          
        </div>
      </form>
  
      <div class="mt-3 text-red-600">
        <div v-for="error in form.errors">{{ error }}</div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { useGlobalStore } from '@/Stores/global-store';
  import { useForm } from '@inertiajs/vue3';
  
  import SecondaryButton from '../common/SecondaryButton.vue';
  import InputDefault from '../common/InputDefault.vue';
  import Tagger from '../common/Tagger.vue';
  import { dbTimeFormat } from '@/Composables/dateTimesUtils';
  
  const props = defineProps({period: Object})
  const emit = defineEmits(['closeUpdateForm']);
  const globalStore = useGlobalStore()
  
  const form = useForm({
    start: props.period.start,
    end: props.period.end,
    tag: props.period?.tag?.label
  })
  
  const update = async () => {  
    
    form
      .transform(data => ({
        start: dbTimeFormat(data.start),
        end: dbTimeFormat(data.end),
        tag: data.tag
      }))
      .put('/workedPeriod/' + props.period.id, {
        onSuccess: async () => {
          await globalStore.fetchPeriods()
          emit('closeUpdateForm')
        }
      })
  };
  </script>