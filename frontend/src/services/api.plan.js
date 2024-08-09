import { API_ENDPOINTS } from '../config/env.config.js'

// [ ] Testear este servicio
export async function fetchAllCategories() {
  const url = API_ENDPOINTS.FETCH_ALL_CATEGORIES
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while fetching categories')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}
