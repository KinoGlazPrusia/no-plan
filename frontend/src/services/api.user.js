import { API_ENDPOINTS } from '../config/env.config.js'

export async function register(userData) {
  const url = API_ENDPOINTS.REGISTER
  const body = new FormData()

  // console.table(userData)

  Object.entries(userData).forEach((item) => {
    body.append(item[0], item[1])
  })

  try {
    const response = await fetch(url, {
      method: 'POST',
      body: body
    })

    if (!response.ok) {
      throw new Error('Something went wrong while signin up')
    }

    const data = await response.json()
    console.log(data)
    return data
  } catch (error) {
    throw error
  }
}
