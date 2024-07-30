import { API_ENDPOINTS } from "../config/env.config.js";

export async function register(userData) {  
    const url = API_ENDPOINTS.REGISTER
    const body = new FormData()

    console.table(userData)

    Object.entries(userData).forEach((key, value) => {
        body.append(key, value)
    })

    /* try {
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
    } */
  }