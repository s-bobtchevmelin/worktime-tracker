<template>
    <div class="text-white rounded-full text-xs text-center px-2" :style="`background-color: ${color};`">{{ tag.label }}</div>
</template>

<script setup>

import colors from '../../../config/tagColor'

const props = defineProps({ tag: Object })
const color = colors[props.tag.color] ?? props.tag.color

</script>