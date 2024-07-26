import { API_ENDPOINTS } from "../config/env.config.js";

export async function isAuthenticated() {
  return false;
}

export async function login(email, password) {  
  const url = API_ENDPOINTS.LOGIN + '?email=' + email + '&password=' + password
  // const url = API_ENDPOINTS.LOGIN
  /* const body = new FormData()

  body.set('email', email)
  body.set('password', password) */

  try {
    /* const response = await fetch(url, {
      method: 'POST',
      body: body
    }) */
    const response = await fetch(url)
  
    if (!response.ok) {
      throw new Error('Something went wrong while loggin in')
    }
  
    const data = await response.json()
    return data
  } 
  catch (error) {
    throw error
  }
}