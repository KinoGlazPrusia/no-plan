import * as apiAuth from '../services/api.auth.js'

export async function permissionGate(validRoles) {
  const authentication = await apiAuth.isAuthenticated()

  if (authentication.status !== 'success') return false

  if (!authentication.data[0]) return false

  authentication.data[1].roles.forEach((role) => {
    if (!validRoles.includes(role)) return false
  })

  return true
}

export async function checkAuthentication(permittedRoles, callback, fallback) {
  const isAuthenticated = await permissionGate(permittedRoles)
  if (isAuthenticated) {
    callback && callback()
  } else {
    fallback && fallback()
  }
}

export async function fetchLoggedUserDataInContext(context) {
  if (!context.getData('user')) {
    const response = await apiAuth.fetchLoggedUserData()
    if (response.status === 'success') {
      context.setData({ user: response.data }, false)
    } else {
      throw new Error('Something went wrong while fetching user data')
    }
  }
}
