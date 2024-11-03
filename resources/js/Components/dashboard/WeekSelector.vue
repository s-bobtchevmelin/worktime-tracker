<template>
  <div v-if="globalStore.activeWeek.length > 0" class="flex items-center justify-around md:justify-center mb-8 text-center">

    <!-- Previous week -->
    <img src="../../../images/arrowCircleRight-icon.svg" 
      width="22" 
      class="mr-2 cursor-pointer" 
      style="transform: rotate(180deg);"
      @click="previousWeek"
    >

    <!-- Current week -->
    <div class="font-medium">{{`Semaine du ${beautifulDate(globalStore.activeWeek[0])} au ${beautifulDate(globalStore.activeWeek[1])}`}}</div>

    <!-- Next week -->
    <img src="../../../images/arrowCircleRight-icon.svg" 
      width="22" 
      class="ml-2 cursor-pointer" 
      @click="nextWeek"
    >
  </div>
</template>

<script setup>
import { useGlobalStore } from '@/Stores/global-store';
import {onMounted, ref} from "vue"
import { defaultDateFormat } from "@/Composables/dateTimesUtils"

const globalStore = useGlobalStore()

const beautifulDate = (date) => defaultDateFormat(date)

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