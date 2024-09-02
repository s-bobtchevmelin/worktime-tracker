<template>
  <div v-if="globalStore.activeWeek.length > 0" class="flex items-center justify-center mb-8">
    <!-- Previous week -->
    <div @click="previousWeek" class="arrow-prev flex items-center justify-center">
      <div>{{ '<' }}</div>
    </div>

    <!-- Current week -->
    <div>{{`Semaine du ${beautifulDate(globalStore.activeWeek[0])} au ${beautifulDate(globalStore.activeWeek[1])}`}}</div>

    <!-- Next week -->
    <div @click="nextWeek" class="arrow-next flex items-center justify-center">
      <div>{{ '>' }}</div>
    </div>
  </div>
</template>

<script setup>
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';
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
  margin: 0 2rem;
  cursor: pointer;
}
</style>