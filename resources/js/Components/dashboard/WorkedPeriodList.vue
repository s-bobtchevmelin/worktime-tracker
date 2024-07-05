<template>
  <div v-for="day in days" :key="day" class="mb-3">
      <SectionTitle>
          <template #title>
              {{ day }}
          </template>
      </SectionTitle>

      <div class="mb-1">
          <div v-for="time in times[day]">{{ time[0] }} - {{ time[1] }}</div>
      </div>

      <div v-if="times[day]" class="italic">
          Heures travaillées : {{ calculateWorkedHoursForADay(times[day]) }}
      </div>
  </div>
</template>

<script setup>

import SectionTitle from '@/Components/SectionTitle.vue';
import moment from 'moment';

const props = defineProps(['days', 'times'])

const calculateWorkedHoursForADay = (dayTimes) => {
    let total = 0

    dayTimes.forEach(period => {
        const start = moment(period[0], "HH:mm")
        const end = moment(period[1], "HH:mm")
        const duration = moment.duration(end.diff(start))
        total += duration._milliseconds
    });

    const totalDuration = moment.duration(total)
    return totalDuration.hours()  + "h" +  (totalDuration.minutes() || '');
}

</script>