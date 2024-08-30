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

export async function fetchAllPlans() {
  const url = API_ENDPOINTS.FETCH_ALL_PLANS
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while fetching the plans.')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}

export async function createPlan(planData) {
  const url = API_ENDPOINTS.CREATE_PLAN
  const body = new FormData()

  Object.entries(planData).forEach((key, value) => {
    switch (key) {
      case 'timeline':
        value.forEach((step) => {
          body.append('timeline[]', step)
        })
        break
      case 'categories':
        value.forEach((category) => {
          body.append('categories[]', category)
        })
        break
      default:
        body.append(key, value)
        break
    }
  })

  console.log(body)
  return // [ ] Testear como se conforma el body antes de enviarlo

  try {
    const response = await fetch(url, {
      method: 'POST',
      body: body
    })

    if (!response.ok) {
      throw new Error('Something went wrong while creating the plan')
    }

    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}
