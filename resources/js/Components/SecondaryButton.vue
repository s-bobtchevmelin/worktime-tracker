<script setup>
const props = defineProps({
    type: {
        type: String,
        default: 'button',
    },
    dense: {
        type: Boolean,
        default: false,
    },
});

const isDense = props.dense ? 'px-2 py-dense' : 'px-4 py-2'
</script>

<template>
    <button :type="type" :class="'inline-flex items-center bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 ' + isDense">
        <slot />
    </button>
</template>

<style>
.py-dense {
    padding-top: 0.40rem;
    padding-bottom: 0.40rem;
}
</style>