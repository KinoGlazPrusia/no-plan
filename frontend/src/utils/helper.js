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
