<template>
    <AppLayout title="Dashboard">
        <div class="grid grid-cols-2 px-6 py-8">
            <div>

                <!-- WEEK -->
                <div class="bg-white py-5 px-8">
                    <div class="text-center mb-8">Semaine du xx au xx</div>
                    <div>
                        <!-- ADD PERIOD FORM -->
                        <WorkedPeriodAdd :days="days" @add-to-times="addToTimes" />

                        <!-- PERIODS LIST -->
                        <WorkedPeriodList :days="days" :times="times" />
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
import AppLayout from '@/Layouts/AppLayout.vue';

const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
const times = reactive({})

const addToTimes = ({day, value}) => {
    times[day] = [...(times[day] || []), value];
}
</script>