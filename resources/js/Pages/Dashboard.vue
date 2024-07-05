<template>
    <AppLayout title="Dashboard">
        <div class="grid grid-cols-2 px-6 py-8">
            <div>

                <!-- WEEK -->
                <div class="bg-white py-5 px-8">
                    
                    <WeekSelector />

                    <div>
                        <!-- ADD PERIOD FORM -->
                        <WorkedPeriodAdd :days="days" />

                        <!-- PERIODS LIST -->
                        <WorkedPeriodList :days="days" />
                    </div>
                </div>
            </div>

            <div>
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
</script>