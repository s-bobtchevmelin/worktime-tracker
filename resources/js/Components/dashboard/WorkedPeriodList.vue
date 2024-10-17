<template>
  <div v-if="globalStore.activeWeek.length > 0" v-for="(day, index) in days" :key="day" class="mb-3">
		<SectionTitle>
			<template #title>
				<span>{{ day }}</span>
				<span class="ml-3 text-base">{{ getDayOfWeek(index) }}</span>
			</template>
		</SectionTitle>

		<div class="mb-1">
			<div v-for="time in filteredTimes[index + 1]" class="flex">
				{{ defaultTimeFormat(time.start) }}
				- 
				{{ defaultTimeFormat(time.end) }}
				<img src="../../../images/trash-icon-red.svg" 
					width="18" 
					class="ml-2 cursor-pointer" 
					@click="deletePeriod(time)"
				>
			</div>
		</div>

		<div v-if="filteredTimes[index + 1]" class="italic">
			Heures travaillées : {{ calculateWorkedHoursForADay(filteredTimes[index + 1]) }}
		</div>
  </div>
</template>

<script setup>

import SectionTitle from '@/Components/SectionTitle.vue';
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';
import { computed } from 'vue';
import { defaultTimeFormat } from '@/Composables/dateTimesUtils'
import { router } from '@inertiajs/vue3'

const props = defineProps(['days'])
const globalStore = useGlobalStore()

const filteredTimes = computed(() => {
	const times = {}
	globalStore.times.forEach(time => {
		const getDay = moment(time.date).weekday()
		if(!times[getDay]) times[getDay] = [time]
		else times[getDay].push(time)
	})
	return times 
})

const getDayOfWeek = (index) => {
	const date = globalStore.activeWeek[0].clone().add(index, 'days');
	return date.format('DD')
}

const calculateWorkedHoursForADay = (dayTimes) => {
	let total = 0

	dayTimes.forEach(period => {
		const start = moment(period.start, "HH:mm")
		const end = moment(period.end, "HH:mm")
		const duration = moment.duration(end.diff(start))
		total += duration._milliseconds
	});

	const totalDuration = moment.duration(total)
	return totalDuration.hours()  + "h" +  (totalDuration.minutes() || '');
}

const deletePeriod = async(time) => {
	router.delete(`/workedPeriod/${time.id}`, {
		onSuccess: async () => {
			await globalStore.fetchTimes()
		}
	})
}

</script>