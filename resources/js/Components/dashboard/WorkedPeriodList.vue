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
      <div v-for="period in filteredPeriods[index + 1]" :key="'period-' + period.id" class="w-8/12 lg:w-6/12 flex items-center">
        <!-- Normal Mode -->
        <div v-if="!isEditing(period.id)" class="flex mr-5">
          <!-- Delete -->
          <img src="../../../images/icons/trash-icon-red.svg" 
            width="18" 
            class="col-span-1 mr-2 cursor-pointer" 
            @click="deletePeriod(period)"
          >

          <!-- Update -->
          <img src="../../../images/icons/edit-icon.svg"
            width="18"
            class="col-span-1 mr-2 cursor-pointer"
            @click="startEditing(period)"
          >

          <!-- Time -->
          <span>{{ defaultTimeFormat(period.start) }} - {{ defaultTimeFormat(period.end) }}</span>

          <!-- Tag -->
          <tag v-if="period.tag" :tag="period.tag"></tag>
        </div>

        <!-- Edition Mode -->
        <WorkedPeriodEdit 
          v-else 
          :time="period" 
          @cancel="cancelEdit" 
          @saved="editingId = null"
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
import WorkedPeriodEdit from '@/Components/dashboard/WorkedPeriodEdit.vue';
import { useGlobalStore } from '@/Stores/global-store';
import moment from 'moment';
import { ref, computed } from 'vue';
import { calculateTimesCumul, defaultTimeFormat } from '@/Composables/dateTimesUtils';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['days']);
const globalStore = useGlobalStore();

// Edition States
const editingId = ref(null);

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
  return date.format('DD');
};

const isEditing = (id) => {
  return editingId.value === id;
};

const startEditing = (period) => {
  editingId.value = period.id;
};

const cancelEdit = () => {
  editingId.value = null;
};

const deletePeriod = async(period) => {
  const form = useForm({})
  form.delete(`/workedPeriod/${period.id}`, {
    onSuccess: async () => {
      await globalStore.fetchPeriods()
    }
  })
}
</script>