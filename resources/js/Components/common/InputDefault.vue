<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    type: {type: String, default: "text"},
    dense: {type: Boolean, default: false},
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :class="{'input-dense': dense}"
        :value="modelValue"
        :type="type"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>

<style>
.input-dense {
    padding: .24rem .75rem;
}
</style>