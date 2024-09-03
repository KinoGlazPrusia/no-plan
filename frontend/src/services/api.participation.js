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

export async function getPlanParticipations(planId) {
  const urls = {
    pending: API_ENDPOINTS.GET_PENDING_PARTICIPATIONS.replace('{planId}', planId),
    accepted: API_ENDPOINTS.GET_ACCEPTED_PARTICIPATIONS.replace('{planId}', planId),
    rejected: API_ENDPOINTS.GET_REJECTED_PARTICIPATIONS.replace('{planId}', planId)
  }

  const participations = {}
  
  try {
    Object.entries(urls).forEach(async (entry) => {
      const key = entry[0]
      const url = entry[1]

      const response = await fetch(url)

      if (!response.ok) {
        throw new Error('Something went wrong while getting plan participations')
      }

      const data = await response.json()
      participations[key] = data.data
    })

    return participations
  } catch(error) {
    throw error
  }
}
