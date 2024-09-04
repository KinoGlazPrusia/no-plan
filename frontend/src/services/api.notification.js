import { API_ENDPOINTS } from '../config/env.config.js'

export async function getUnreadNotifications() {
  const url = API_ENDPOINTS.GET_UNREAD_NOTIFICATIONS
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while getting unread notifications')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}

export async function setNotificationAsRead(notificationId) {
  const url = API_ENDPOINTS.SET_NOTIFICATION_AS_READ.replace('{id}', notificationId)
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error('Something went wrong while setting notification as read')
    }
    const data = await response.json()
    return data
  } catch (error) {
    throw error
  }
}