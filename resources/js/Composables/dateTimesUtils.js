import moment from 'moment';

export function defaultDateFormat(date) {
  return date ? date.format('DD/MM/YYYY') : null
}

export function dbTimeFormat(time) {
  return moment(time, 'HH:mm:ss').format('HH:mm:ss')
}

export function dbDateFormat(date) {
  return date ? date.format('YYYY-MM-DD') : null
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