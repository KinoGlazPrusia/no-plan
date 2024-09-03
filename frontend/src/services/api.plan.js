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

export async function fetchAllPlans(page = 1, itemsPerPage = 10) {
  const url = API_ENDPOINTS.FETCH_ALL_PLANS.replace('{page}', page).replace('{items}', itemsPerPage)
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

export async function fetchPlanData(id) {
  const url = API_ENDPOINTS.FETCH_PLAN_DATA.replace('{id}', id)
  console.log(url)
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while fetching the plan data.')
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

  Object.entries(planData).forEach(([key, value]) => {
    switch (key) {
      case 'timeline':
        value.forEach((step) => {
          body.append('timeline[]', JSON.stringify(step))
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

// [ ] Testear la implementación de updatePlan
export async function updatePlan(planId, planData) {
  const url = API_ENDPOINTS.UPDATE_PLAN
  const body = new FormData()

  body.append('id', planId)

  console.log(planData)

  Object.entries(planData).forEach(([key, value]) => {
    switch (key) {
      case 'timeline':
        value.forEach((step) => {
          body.append('timeline[]', JSON.stringify(step))
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

  try {
    const response = await fetch(url, {
      method: 'POST',
      body: body
    })

    if (!response.ok) {
      throw new Error('Something went wrong while updating the plan')
    }

    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}
