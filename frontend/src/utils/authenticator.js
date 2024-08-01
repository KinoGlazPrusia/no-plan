import * as apiAuth from '../services/api.auth.js'

export async function permissionGate(validRoles) {    
    const authentication = await apiAuth.isAuthenticated()

    if (!authentication.data[0]) return false

    authentication.data[1].forEach(role => {
        if(!validRoles.includes(role)) return false
    })

    return true
}