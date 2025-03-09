<template>
  <div v-if="globalStore.activeWeek.length > 0" v-for="(day, index) in days" :key="day" class="mb-3">
		<SectionTitle>
			<template #title>
				<span>{{ day }}</span>
				<span class="ml-3 text-base">{{ getDayOfWeek(index) }}</span>
			</template>
		</SectionTitle>

		<div class="mb-1">
			<div v-for="time in filteredTimes[index + 1]" :key="'time-' + time.id" class="w-8/12 lg:w-6/12 flex items-center">
				<!-- Normal Mode -->
        <div v-if="!isEditing(time.id)" class="flex mr-5">

          <!-- Delete -->
          <img src="../../../images/icons/trash-icon-red.svg" 
            width="18" 
            class="col-span-1 mr-2 cursor-pointer" 
            @click="deletePeriod(time)"
          >

					<!-- Update -->
					<img src="../../../images/icons/edit-icon.svg"
						width="18"
						class="col-span-1 mr-2 cursor-pointer"
						@click="startEditing(time)"
					>

          <!-- Time -->
          <span >{{ defaultTimeFormat(time.start) }} - {{ defaultTimeFormat(time.end) }}</span>

					<!-- Tag -->
					<tag v-if="time.tag" :tag="time.tag"></tag>
        </div>

				<!-- Edition Mode -->
        <div v-else class="flex flex-col w-full">
          <div class="flex items-center mb-2">
            <!-- Time inputs -->
            <input 
              type="time" 
              v-model="editForm.start" 
              class="border rounded px-2 py-1 mr-2 w-24"
            >
            <span>-</span>
            <input 
              type="time" 
              v-model="editForm.end" 
              class="border rounded px-2 py-1 ml-2 w-24"
            >
            
            <!-- Tag input -->
            <input 
              type="text" 
              v-model="editForm.tag" 
              placeholder="Tag" 
              class="border rounded px-2 py-1 ml-3 mr-2"
            >

						<!-- Save button -->
						<img src="../../../images/icons/save-icon.svg" 
							width="18" 
							class="col-span-1 mr-2 cursor-pointer" 
							@click="saveEdit(time)"
          	>
            
            <!-- Cancel button -->
						<img src="../../../images/icons/cancel-icon.svg" 
							width="18" 
							class="col-span-1 mr-2 cursor-pointer"
							@click="cancelEdit()"
          	>
          </div>
        </div>
         
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
import { ref, computed } from 'vue';
import { calculateTimesCumul, defaultTimeFormat } from '@/Composables/dateTimesUtils'
import { useForm } from '@inertiajs/vue3'

const props = defineProps(['days'])
const globalStore = useGlobalStore()

// Edition States
const editingId = ref(null);
const editForm = ref({
  date: '',
  start: '',
  end: '',
  tag: ''
});

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

const isEditing = (id) => {
  return editingId.value === id;
}

const startEditing = (time) => {
  editingId.value = time.id;
  editForm.value = {
    date: time.date,
    start: time.start,
    end: time.end,
    tag: time.tag ? time.tag.label : ''
  };
}

const cancelEdit = () => {
  editingId.value = null;
}

const saveEdit = async (time) => {
  const form = useForm({
    date: editForm.value.date,
    start: editForm.value.start,
    end: editForm.value.end,
    tag: editForm.value.tag
  });

  form.put(`/workedPeriod/update/${time.id}`, {
    onSuccess: async () => {
      await globalStore.fetchTimes();
      editingId.value = null;
    }
  });
}

const deletePeriod = async(time) => {
	const form = useForm({})
	form.delete(`/workedPeriod/${time.id}`, {
		onSuccess: async () => {
			await globalStore.fetchTimes()
		}
	})
}

const updatePeriod = async(time) => {

}
</script>