<template>
  <div v-if="globalStore.activeWeek.length > 0" class="lg:flex items-center justify-around mb-8">

    <SecondaryButton @click="resetWeek" class="w-full lg:w-auto mb-4 lg:mb-0 lg:mr-3">Semaine actuelle</SecondaryButton>

    <div class="flex items-center justify-around lg:justify-center text-center">
      <!-- Previous week -->
      <img src="../../../images/icons/arrowCircleRight-icon.svg" 
        :width="iconSize" 
        class="mr-2 cursor-pointer" 
        style="transform: rotate(180deg);"
        @click="previousWeek"
      >

      <!-- Current week -->
      <div class="font-medium">{{`Semaine du ${beautifulDate(globalStore.activeWeek[0])} au ${beautifulDate(globalStore.activeWeek[1])}`}}</div>

      <!-- Next week -->
      <img src="../../../images/icons/arrowCircleRight-icon.svg" 
        :width="iconSize" 
        class="ml-2 cursor-pointer" 
        @click="nextWeek"
      >
    </div>
  </div>
</template>

<script setup>
import { useGlobalStore } from '@/Stores/global-store';
import { onMounted } from "vue"
import { defaultDateFormat } from "@/Composables/dateTimesUtils"
import { isMobile, isTablet } from '@/Composables/responsive';
import SecondaryButton from '../common/SecondaryButton.vue';

const globalStore = useGlobalStore()
const iconSize = isMobile || isTablet ? '36' : '24';

const beautifulDate = (date) => defaultDateFormat(date)

const resetWeek = async () => {
  const currentWeek = globalStore.getWeek
  await globalStore.updateActiveWeek(currentWeek)
}

const previousWeek = async () => {
  const start = globalStore.activeWeek[0].clone().subtract(7, 'days');
  const end = globalStore.activeWeek[1].clone().subtract(7, 'days');
  await globalStore.updateActiveWeek([start, end])
}

const nextWeek = async () => {
  const start = globalStore.activeWeek[0].clone().add(7, 'days');
  const end = globalStore.activeWeek[1].clone().add(7, 'days');
  await globalStore.updateActiveWeek([start, end])
}

onMounted(async () => {
  const activeWeek = globalStore.getWeek;
  await globalStore.updateActiveWeek([activeWeek[0], activeWeek[1]])
})

</script>

<style>
.arrow-prev, .arrow-next {
  background-color: lightgray;
  border-radius: 20px;
  width: 20px;
  height: 20px;
  font-size: large;
  font-weight: 500;
  cursor: pointer;
}
</style>