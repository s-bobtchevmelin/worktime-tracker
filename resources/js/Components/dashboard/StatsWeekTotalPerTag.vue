<template>
  <div class="mt-3">
    <div v-if="calculateTotalTimeForTag(null) !== '0h'">
      <span>Sans tags</span> : <span>{{ calculateTotalTimeForTag(null) }}</span>
    </div>

    <div v-for="tag in globalStore.tags" :key="'tag-' + tag.label">
      <div v-if="calculateTotalTimeForTag(tag.id)  !== '0h'">
        <tag :tag="tag" class="inline"></tag> : <span>{{ calculateTotalTimeForTag(tag.id) }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { calculateTimesCumul } from '@/Composables/dateTimesUtils';
import { useGlobalStore } from '@/Stores/global-store';
import Tag from '@/Components/common/Tag.vue';

const globalStore = useGlobalStore()

const calculateTotalTimeForTag = (tagId) => {
  const periods = globalStore.periods.filter(period => period.tag_id === tagId)
  return calculateTimesCumul(periods)
}

</script>