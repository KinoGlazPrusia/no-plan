import { API_ENDPOINTS } from "../config/env.config.js";

export async function isAuthenticated() {
  return false;
}

export async function login(email, password) {  
  const url = API_ENDPOINTS.LOGIN
  const body = new FormData()

  body.append('email', email)
  body.append('password', password)

  try {
    const response = await fetch(url, {
      method: 'POST',
      body: body
    })
  
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