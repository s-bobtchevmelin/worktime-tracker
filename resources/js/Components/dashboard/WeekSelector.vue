<template>
  <div class="flex items-center justify-center mb-8">
    <!-- Previous week -->
    <div class="arrow-prev flex items-center justify-center">
      <div>{{ '<' }}</div>
    </div>

    <!-- Current week -->
    <div>{{`Semaine du ${beautifulDate(globalStore.nowWeek[0])} au ${beautifulDate(globalStore.nowWeek[1])}`}}</div>

    <!-- Next week -->
    <div class="arrow-next flex items-center justify-center">
      <div>{{ '>' }}</div>
    </div>
  </div>
</template>

<script setup>
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';

const globalStore = useGlobalStore()

const formatedDate = (date) => date.format()
const beautifulDate = (date) => date.format('DD/MM/YYYY')
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