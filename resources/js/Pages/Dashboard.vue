<template>
  <AppLayout title="Dashboard">
    <div class="dashboard flex flex-col lg:flex-row lg:px-6 py-2 lg:py-8">

      <!-- LEFT PANEL - Week -->
      <div :class="'lg:w-1/2 order-2 lg:order-1 ' + boxCSS">
        <WeekSelector />
        <WorkedPeriodAdd :days="days" :tags="tags" />
        <WorkedPeriodList :days="days" />
      </div>

      <!-- RIGTH PANEL - Stats preview -->
      <div class="lg:w-1/2 order-1 lg:order-2">
        
        <!-- Total per week -->
        <div :class="'mb-3 lg:mb-0 ' + boxCSS"> 
          <StatsWeekTotal></StatsWeekTotal>
        </div>

        <div v-if="! isSmallDevice">
          coucou
        </div>
      </div>
      
    </div>
  </AppLayout>
</template>

<script setup>

import WorkedPeriodAdd from '@/Components/dashboard/WorkedPeriodAdd.vue';
import WorkedPeriodList from '@/Components/dashboard/WorkedPeriodList.vue';
import WeekSelector from '@/Components/dashboard/WeekSelector.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import StatsWeekTotal from '@/Components/dashboard/StatsWeekTotal.vue';
import { isSmallDevice } from '@/Composables/responsive';

const props = defineProps({tags: Array})

const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
const boxCSS = "bg-white py-3 lg:py-5 px-4 lg:px-8 rounded-xl mx-2"
</script>

<style>
.dashboard {
  height: 92vh;
}
</style>