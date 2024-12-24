<template>
  <div v-if="globalStore.activeWeek.length > 0" v-for="(day, index) in days" :key="day" class="mb-3">
		<SectionTitle>
			<template #title>
				<span>{{ day }}</span>
				<span class="ml-3 text-base">{{ getDayOfWeek(index) }}</span>
			</template>
		</SectionTitle>

		<div class="mb-1">
			<div v-for="time in filteredTimes[index + 1]" class="w-8/12 lg:w-6/12 flex items-center">
        <div class="flex mr-5">

          <!-- Delete -->
          <img src="../../../images/trash-icon-red.svg" 
            width="18" 
            class="col-span-1 mr-2 cursor-pointer" 
            @click="deletePeriod(time)"
          >

          <!-- Time -->
          <span >{{ defaultTimeFormat(time.start) }} - {{ defaultTimeFormat(time.end) }}</span>
        </div>

        <!-- Tag -->
        <tag v-if="time.tag" :tag="time.tag"></tag>
         
		  </div>
		</div>

		<div v-if="filteredTimes[index + 1]" class="italic">
			Heures travaillées : {{ calculateTimesCumul(filteredTimes[index + 1]) }}
		</div>
  </div>
</template>

<script setup>

import SectionTitle from '@/Components/common/SectionTitle.vue';
import Tag from '@/Components/common/Tag.vue';
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';
import { computed } from 'vue';
import { calculateTimesCumul, defaultTimeFormat } from '@/Composables/dateTimesUtils'
import { useForm } from '@inertiajs/vue3'

const props = defineProps(['days'])
const globalStore = useGlobalStore()

const filteredTimes = computed(() => {
	const times = {}
	globalStore.times.forEach(time => {
		const getDay = moment(time.date).isoWeekday()
		if(!times[getDay]) times[getDay] = [time]
		else times[getDay].push(time)
	})
	return times 
})

const getDayOfWeek = (index) => {
	const date = globalStore.activeWeek[0].clone().add(index, 'days');
	return date.format('DD')
}

const deletePeriod = async(time) => {
	const form = useForm({})
	form.delete(`/workedPeriod/${time.id}`, {
		onSuccess: async () => {
			await globalStore.fetchTimes()
		}
	})
}
</script>