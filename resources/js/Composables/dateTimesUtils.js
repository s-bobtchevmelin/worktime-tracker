import moment from 'moment';

export function defaultDateFormat(date) {
  return date.format('DD/MM/YYYY')
}

export function dbDateFormat(date) {
  return date.format('YYYY-MM-DD')
}

export function getTimeFormat(time) {
  return moment(time, "HH:mm")
}

export function defaultTimeFormat(time) {
  return time.slice(0, 5)
}