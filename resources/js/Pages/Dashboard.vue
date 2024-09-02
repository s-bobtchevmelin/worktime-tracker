<template>
    <AppLayout title="Dashboard">
        <div class="grid grid-cols-12 px-6 py-8">

            <!-- WEEK -->
            <div :class="'col-span-7 ' + boxCSS">
                <WeekSelector />

                <div>
                    <!-- ADD PERIOD FORM -->
                    <WorkedPeriodAdd :days="days" />

                    <!-- PERIODS LIST -->
                    <WorkedPeriodList :days="days" />
                </div>
            </div>

            <div :class="'col-span-5 ' + boxCSS">
                coucou
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { reactive } from 'vue';

import WorkedPeriodAdd from '@/Components/dashboard/WorkedPeriodAdd.vue';
import WorkedPeriodList from '@/Components/dashboard/WorkedPeriodList.vue';
import WeekSelector from '@/Components/dashboard/WeekSelector.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
const boxCSS = "xl:col-span-6 bg-white py-5 px-8 rounded-xl mx-2"
</script>