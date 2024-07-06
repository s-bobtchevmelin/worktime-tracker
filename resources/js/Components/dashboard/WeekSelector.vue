<template>
  <div class="flex items-center justify-center mb-8">
    <!-- Previous week -->
    <div @click="previousWeek" class="arrow-prev flex items-center justify-center">
      <div>{{ '<' }}</div>
    </div>

    <!-- Current week -->
    <div>{{`Semaine du ${beautifulDate(weekStart)} au ${beautifulDate(weekEnd)}`}}</div>

    <!-- Next week -->
    <div @click="nextWeek" class="arrow-next flex items-center justify-center">
      <div>{{ '>' }}</div>
    </div>
  </div>
</template>

<script setup>
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';
import {ref} from "vue"

const globalStore = useGlobalStore()

const weekStart = ref(globalStore.nowWeek[0])
const weekEnd = ref(globalStore.nowWeek[1])

const beautifulDate = (date) => date.format('DD/MM/YYYY')

const previousWeek = () => {
  weekStart.value = weekStart.value.clone().subtract(7, 'days');
  weekEnd.value = weekEnd.value.clone().subtract(7, 'days');
}

const nextWeek = () => {
  weekStart.value = weekStart.value.clone().add(7, 'days');
  weekEnd.value = weekEnd.value.clone().add(7, 'days');
}
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