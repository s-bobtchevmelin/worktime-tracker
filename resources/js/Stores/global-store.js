import { defineStore } from 'pinia'
import moment from 'moment';
import { dbDateFormat } from "@/Composables/dateTimesUtils"

export const useGlobalStore = defineStore('global', {
  state: () => ({
    activeWeek: [],
    periods: [],
    tags: []
  }),
  getters: {
    getWeek: () => {
      const date = moment()
      const start = date.clone().startOf('isoWeek');
      const end = date.clone().endOf('isoWeek');
      return [start, end]
    },
  },
  actions: {
    async fetchPeriods() {
      const start = dbDateFormat(this.activeWeek[0])
      const end = dbDateFormat(this.activeWeek[1])
      const response = await axios.get(`/workedPeriod/week/${start}/${end}`)
      this.periods = response.data
    },
    async updateActiveWeek(value) {
      this.activeWeek = value;
      await this.fetchPeriods()
    },
    updateTags(value) {
      this.tags = value;
    },
  },
})