import { API_ENDPOINTS } from '../config/env.config.js'

export async function isAuthenticated () {
  const url = API_ENDPOINTS.IS_AUTHENTICATED
  const response = await fetch(url)

  if (!response.ok) {
    throw new Error('Something went wrong while checking authentication')
  }

  const data = await response.json()
  return data
}

export async function login (email, password) {
  const url = API_ENDPOINTS.LOGIN
  const body = new FormData()

  body.append('email', email)
  body.append('password', password)

  const response = await fetch(url, {
    method: 'POST',
    body
  })

  if (!response.ok) {
    throw new Error('Something went wrong while loggin in')
  }

  const data = await response.json()
  return data
}

export async function emailExists (email) {
  const url = `${API_ENDPOINTS.EMAIL_EXISTS}?email=${email}`

  const response = await fetch(url)

  if (!response.ok) {
    throw new Error('Something went wrong while checking email existence')
  }

  const data = await response.json()
  return data
}
