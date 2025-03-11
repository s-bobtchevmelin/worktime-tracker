import moment from 'moment';

export function defaultDateFormat(date) {
  return date ? date.format('DD/MM/YYYY') : null
}

export function dbTimeFormat(time) {

  if (!time) return null

  // Time already in correct format, skip formatting
  if (/^\d{2}:\d{2}:\d{2}$/.test(time)) {
    return time
  }

  return time + ':00'
}

export function dbDateFormat(date) {
  return date ? date.format('YYYY-MM-DD') : null
}

export function getTimeFormat(time) {
  return moment(time, "HH:mm")
}

export function defaultTimeFormat(time) {
  return time.slice(0, 5)
}

export function convertMillisecondsToHoursAndMinutes(duration) {
  const totalMinutes = (duration / 60000)
  const leftMinutes = totalMinutes % 60
  const hours = (totalMinutes - leftMinutes) / 60

  return {
    hours: hours,
    minutes: leftMinutes
  }
}

export function calculateTimesCumul(times) {
  let total = 0

  times.forEach(period => {
    const start = moment(period.start, "HH:mm")
    const end = moment(period.end, "HH:mm")
    const duration = moment.duration(end.diff(start))

    total += duration._milliseconds
  });

  const totalDuration = convertMillisecondsToHoursAndMinutes(total)
  return totalDuration.hours + "h" + (totalDuration.minutes || '');
}