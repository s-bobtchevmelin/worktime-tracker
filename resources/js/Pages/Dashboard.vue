<template>
    <AppLayout title="Dashboard">
        <div class="grid grid-cols-12 md:px-6 py-2 md:py-8">

            <!-- WEEK -->
            <div :class="'order-2 md:order-1 col-span-12 md:col-span-7 ' + boxCSS">
                <WeekSelector />

                <div>
                    <!-- ADD PERIOD FORM -->
                    <WorkedPeriodAdd :days="days" :tags="tags" />

                    <!-- PERIODS LIST -->
                    <WorkedPeriodList :days="days" />
                </div>
            </div>

            <div :class="'order-1 md:rder-2 col-span-12 md:col-span-5 mb-2 md:mb-0' + boxCSS">
                coucou
            </div>
        </div>
    </AppLayout>
</template>

<script setup>

import WorkedPeriodAdd from '@/Components/dashboard/WorkedPeriodAdd.vue';
import WorkedPeriodList from '@/Components/dashboard/WorkedPeriodList.vue';
import WeekSelector from '@/Components/dashboard/WeekSelector.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({tags: Array})

const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
const boxCSS = "xl:col-span-6 bg-white py-3 md:py-5 px-4 md:px-8 rounded-xl mx-2"
</script>