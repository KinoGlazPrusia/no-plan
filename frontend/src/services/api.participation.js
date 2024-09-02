import { API_ENDPOINTS } from '../config/env.config.js'

export async function applyToPlan(planId) {
  const url = API_ENDPOINTS.PARTICIPATE_IN_PLAN.replace('{planId}', planId)
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while applying to the plan')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}
