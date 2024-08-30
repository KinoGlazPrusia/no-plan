import { PUBLIC_PATH } from '../config/env.config.js'

export function navigateTo(path) {
  window.location.replace(PUBLIC_PATH + path)
}
