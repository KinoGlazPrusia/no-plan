import { PUBLIC_PATH } from '../config/env.config.js'

export function navigateTo(path) {
  window.location.replace(PUBLIC_PATH + path)
}

export function getAge(birthdate) {
  const today = new Date()

  // Asegurarnos de que birthdate es un objeto Date
  birthdate = new Date(birthdate)

  let age = today.getFullYear() - birthdate.getFullYear()
  const monthDiff = today.getMonth() - birthdate.getMonth()

  if (
    monthDiff < 0 ||
    (monthDiff === 0 && today.getDate() < birthdate.getDate())
  ) {
    age--
  }

  // Verificación adicional para evitar edades negativas o excesivamente altas
  if (age < 0 || age > 150) {
    console.error('Cálculo de edad inválido. Verifica la fecha de nacimiento.')
    return null
  }

  return age
}

export function timeFromNow(time) {
  // Function made with vanilla JS
  const date = new Date(time)
  const now = new Date()
  const seconds = Math.floor((now - date) / 1000)
  const minutes = Math.floor(seconds / 60)
  const hours = Math.floor(minutes / 60)
  const days = Math.floor(hours / 24)

  console.log('Notification time: ', time)
  console.log('Notification date:', date)
  console.log('Now date:', now)

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
