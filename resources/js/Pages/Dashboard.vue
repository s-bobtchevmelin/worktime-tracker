<template>
    <AppLayout title="Dashboard">
        <div class="grid grid-cols-2 px-6 py-8">
            <div>

                <!-- WEEK -->
                <div class="bg-white py-5 px-8">
                    <div class="text-center mb-8">Semaine du xx au xx</div>
                    <div>
                        <!-- ADD PERIOD FORM -->
                        <WorkPeriod @add-to-times="addToTimes"></WorkPeriod>

                        <!-- PERIODS LIST -->
                        <div v-for="day in days" :key="day">
                            <SectionTitle>
                                <template #title>
                                    {{ day }}
                                </template>
                            </SectionTitle>

                            <div class="mb-3">
                                <div v-for="time in times[day]">{{ time[0] }} - {{ time[1] }}</div>
                            </div>
                        </div>
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

import SectionTitle from '@/Components/SectionTitle.vue';
import WorkPeriod from '@/Components/WorkPeriod.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
const times = reactive({})

const addToTimes = ({day, value}) => {
    console.log(day, value);
    times[day] = [...(times[day] || []), value];
    
}
</script>