import { defineStore } from 'pinia'
import moment from 'moment';

export const useGlobalStore = defineStore('global', {
  state: () => ({ 
    times: {}
  }),
  getters: {
    nowWeek: () => {
      const now = moment()
      const startOfWeek = now.clone().startOf('isoWeek');
      const endOfWeek = now.clone().endOf('isoWeek');
      return [startOfWeek, endOfWeek]
    },
  },
  actions: {
    addTimesForADay(day, value) {
      this.times[day] = [...(this.times[day] || []), value];
    },
  },
})