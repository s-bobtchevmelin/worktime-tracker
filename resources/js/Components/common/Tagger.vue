<template>
    <div class="flex item-center">
			<img src="../../../images/tag-icon.svg" width="18" style="max-width: unset;">

			<InputDefault id="tagInput" 
				:value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
				list="userTags" 
				class="w-full ml-1" 
				dense 
			/>
			<datalist id="userTags">
				<option v-for="tag in tags">{{ tag.label }}</option>
			</datalist>
    </div>
</template>

<script setup>

import InputDefault from './InputDefault.vue';

const props = defineProps({modelValue: String, tags: Array})
defineEmits(['update:modelValue']);

</script>

<style>
#tagInput::-webkit-calendar-picker-indicator {
	opacity:0;
}
</style> 