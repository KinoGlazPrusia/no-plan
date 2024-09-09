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

export async function unapplyToPlan(planId) {
  const url = API_ENDPOINTS.UNPARTICIPATE_IN_PLAN.replace('{planId}', planId)
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while unapplying to the plan')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}

export async function getPendingPlanParticipations(planId) {
  const url = API_ENDPOINTS.GET_PENDING_PARTICIPATIONS.replace(
    '{planId}',
    planId
  )
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error(
        'Something went wrong while getting pending plan participations'
      )
    }
    const data = await response.json()
    return data.data
  } catch (error) {
    throw error
  }
}

export async function getAcceptedPlanParticipations(planId) {
  const url = API_ENDPOINTS.GET_ACCEPTED_PARTICIPATIONS.replace(
    '{planId}',
    planId
  )
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error(
        'Something went wrong while getting accepted plan participations'
      )
    }
    const data = await response.json()
    return data.data
  } catch (error) {
    throw error
  }
}

export async function getRejectedPlanParticipations(planId) {
  const url = API_ENDPOINTS.GET_REJECTED_PARTICIPATIONS.replace(
    '{planId}',
    planId
  )
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error(
        'Something went wrong while getting rejected plan participations'
      )
    }
    const data = await response.json()
    return data.data
  } catch (error) {
    throw error
  }
}

export async function acceptParticipation(userId, planId) {
  const url = API_ENDPOINTS.ACCEPT_PARTICIPATION.replace(
    '{userId}',
    userId
  ).replace('{planId}', planId)
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while accepting participation')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}

export async function rejectParticipation(userId, planId) {
  const url = API_ENDPOINTS.REJECT_PARTICIPATION.replace(
    '{userId}',
    userId
  ).replace('{planId}', planId)
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while rejecting participation')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}
