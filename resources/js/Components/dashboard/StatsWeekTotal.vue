<template>
  <div>
    <h3 class="font-bold">Heures travaillées cette semaine :</h3>
    <div>{{ calculateTimesCumul(globalStore.times) }}</div>
  </div>
</template>

<script setup>
import { calculateTimesCumul } from '@/Composables/dateTimesUtils';
import { useGlobalStore } from '@/Stores/global-store';

const globalStore = useGlobalStore()

</script>