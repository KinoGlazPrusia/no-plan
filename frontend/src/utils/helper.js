import { PUBLIC_PATH } from '../config/env.config.js'

export function navigateTo(path) {
  window.location.replace(PUBLIC_PATH + path)
}

export function getAge(birthdate) {
  const today = new Date()

  let diff = (today.getTime() - birthdate.getTime()) / 1000
  diff /= 60 * 60 * 24
  return Math.abs(Math.round(diff / 365.25))

  // [ ] Revisar el cálculo de la edad porque no es perfecto
}

export function timeFromNow(time) {
  // Function made with vanilla JS
  const date = new Date(time)
  const now = new Date()
  const seconds = Math.floor((now - date) / 1000)
  const minutes = Math.floor(seconds / 60)
  const hours = Math.floor(minutes / 60)
  const days = Math.floor(hours / 24)

  if (days > 0) {
    return `${days} ${days > 1 ? 'days' : 'day'} ago`
  } else if (hours > 0) {
    return `${hours} ${hours > 1 ? 'hours' : 'hour'} ago`
  } else {
    return `${minutes} ${minutes > 1 ? 'minutes' : 'minute'} ago`
  }
}

export function getMonthName(month) {
  const months = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
  ]
  return months[month]
}
