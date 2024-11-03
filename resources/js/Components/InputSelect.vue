<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    options: Array,
    dense: {type: Boolean, default: false},
});

defineEmits(['update:modelValue']);

const input = ref(null);

const isString = (option) => typeof option === 'string'

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        ref="input"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :class="{'input-dense': dense}"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option v-for="(option, index) in options" :value="isString(option) ? option : option.value">
            {{ isString(option) ? option : option.label }}
        </option>
    </select>
</template>

<style>
.input-dense {
    padding: .24rem .75rem;
}
</style>