<template>
	<div v-if="globalStore.activeWeek.length > 0" v-for="(day, index) in days" :key="day" class="mb-3">

		<!-- Week day label -->
		<SectionTitle>
			<template #title>
				<span>{{ day }}</span>
				<span class="ml-3 text-base">{{ getDayOfWeek(index) }}</span>
			</template>
		</SectionTitle>

		<!-- Periods list -->
		<div class="mb-1">
			<div v-for="period in filteredPeriods[index + 1]" :key="'period-' + period.id">
				<div v-if="updatingPeriod !== period.id" class="w-8/12 lg:w-6/12 flex items-center">
					<div class="flex mr-5">

					<!-- Delete -->
					<img src="../../../images/icons/trash-icon-red.svg" 
						width="18" 
						class="col-span-1 mr-2 cursor-pointer" 
						@click="deletePeriod(period)"
					>

					<!-- Update -->
					<img src="../../../images/icons/edit-icon-orange.svg" 
						width="18" 
						class="col-span-1 mr-2 cursor-pointer" 
						@click="togglePeriodUpdate(period)"
					>

					<!-- Time -->
					<span >{{ defaultTimeFormat(period.start) }} - {{ defaultTimeFormat(period.end) }}</span>
					</div>

					<!-- Tag -->
					<tag v-if="period.tag" :tag="period.tag"></tag>
				</div>

				<WorkedPeriodEdit 
					v-if="updatingPeriod === period.id" 
					:period="period" 
					@close-update-form="() => updatingPeriod = null"
				/>
			</div>
		</div>

		<div v-if="filteredPeriods[index + 1]" class="italic">
			Heures travaillées : {{ calculateTimesCumul(filteredPeriods[index + 1]) }}
		</div>
	</div>
</template>

<script setup>

import SectionTitle from '@/Components/common/SectionTitle.vue';
import Tag from '@/Components/common/Tag.vue';
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';
import { computed, ref } from 'vue';
import { calculateTimesCumul, defaultTimeFormat } from '@/Composables/dateTimesUtils'
import { useForm } from '@inertiajs/vue3'
import WorkedPeriodEdit from './WorkedPeriodEdit.vue';

const props = defineProps(['days'])
const globalStore = useGlobalStore()

const updatingPeriod = ref(null)

const filteredPeriods = computed(() => {
	const periods = {}
	globalStore.periods.forEach(period => {
		const getDay = moment(period.date).isoWeekday()
		if(!periods[getDay]) periods[getDay] = [period]
		else periods[getDay].push(period)
	})
	return periods 
})

const getDayOfWeek = (index) => {
	const date = globalStore.activeWeek[0].clone().add(index, 'days');
	return date.format('DD')
}

const togglePeriodUpdate = (period) => {
	updatingPeriod.value = period.id
}

const deletePeriod = async(period) => {
	const form = useForm({})
	form.delete(`/workedPeriod/${period.id}`, {
		onSuccess: async () => {
			await globalStore.fetchPeriods()
		}
	})
}
</script>