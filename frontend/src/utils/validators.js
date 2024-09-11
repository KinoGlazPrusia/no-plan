import { imageValidFormats } from '../constants/imageValidFormats.js'
import { emailExists as apiEmailExists } from '../services/api.auth.js'

/* Este objeto sirve de ENUM para recuperar los nombres de las funciones
de validación, que pasaremos en un atributo a los componentes input para
poder cargar las funciones */
export const VALIDATORS = {
  EMAIL: 'validateEmail',
  DATE: 'validateDate',
  PASSWORD: 'validatePassword',
  PASSWORD_CONFIRMATION: 'validatePasswordConfirmation',
  NAME: 'validateName',
  DESCRIPTION: 'validatePlanDescription',
  PHONE_NUMBER: 'validatePhoneNumber',
  AVATAR_IMAGE_FILE: 'validateAvatarImage',
  NOT_EMPTY: 'validateNotEmpty'
}

export function validateEmail(email) {
  /* eslint-disable */
  const regexEmailFormat = new RegExp(/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/gi)
  /* eslint-enable */

  const validityMessage = validate([
    {
      condition: () => email.length > 0,
      message: 'This field is required'
    },
    {
      condition: () => regexEmailFormat.test(email),
      message: 'Email format is not valid'
    }
  ])

  return validityMessage
}

export async function validateEmailDontExists(email) {
  if (!email || email.length === 0) return []

  /* eslint-disable */
  const emailExists = await apiEmailExists(email)
  /* eslint-enable */

  const validityMessage = validate([
    {
      condition: () => !emailExists.data[0],
      message: 'This email already exists'
    }
  ])

  return validityMessage
}

export function validateDate(rawDate) {
  const [year, month, day] = rawDate.split('-')
  const date = {
    year,
    month,
    day,
    raw: rawDate
  }

  const planDate = new Date(rawDate)
  const today = new Date()
  today.setDate(today.getDate() - 1) // Contamos desde ayer, ya que se complica comparar con hoy mismo y hoy si que pueden publicarse planes

  const validityMessage = validate([
    {
      condition: () =>
        date.year.length === 4 &&
        date.month.length === 2 &&
        date.day.length === 2,
      message: 'Invalid date'
    },
    {
      condition: () => planDate > today,
      message: 'Date must be in the future'
    }
  ])

  return validityMessage
}

export function validateNotEmpty(value) {
  const validityMessage = validate([
    {
      condition: () => value.length > 0,
      message: 'This field is required'
    }
  ])

  return validityMessage
}

export function validatePassword(password) {
  const regexHasUppercase = /[A-Z]{1,}/g
  const regexHasLowercase = /[a-z]{1,}/g
  const regexHasSpecialChar = /[^A-z\s\d][\\\^]?/g
  const regexHasDigit = /[\d]{1,}/g

  const validityMessage = validate([
    {
      condition: () => password.length >= 8,
      message: 'Min. 8 characters'
    },
    {
      condition: () => regexHasUppercase.test(password),
      message: 'At least one uppercase'
    },
    {
      condition: () => regexHasLowercase.test(password),
      message: 'At least one lowercase'
    },
    {
      condition: () => regexHasSpecialChar.test(password),
      message: 'At least one special character'
    },
    {
      condition: () => regexHasDigit.test(password),
      message: 'At least one digit'
    }
  ])

  return validityMessage
}

export function validatePasswordConfirmation(password, confirmation) {
  const validityMessage = validate([
    {
      condition: () => password === confirmation,
      message: "Passwords don't match"
    }
  ])

  return validityMessage
}

export function validateName(name) {
  const validityMessage = validate([
    {
      condition: () => name.length > 0 && name.length < 20,
      message: 'Between 1 and 20 characters'
    }
  ])

  return validityMessage
}

export function validatePlanDescription(description) {
  const validityMessage = validate([
    {
      condition: () => description.length > 0 && description.length <= 100,
      message: 'Between 1 and 100 characters'
    }
  ])

  return validityMessage
}

export function validatePhoneNumber(phone) {
  const validityMessage = validate([
    {
      condition: () => phone.length > 8 && phone.length < 20,
      message: 'The phone length is not valid'
    }
  ])

  return validityMessage
}

export function validateAvatarImage(file) {
  let type = null
  let size = null

  if (file) {
    type = file.type
    size = file.size
  }

  const validityMessage = validate([
    {
      condition: () => file,
      message: 'This field is required'
    },
    {
      condition: () => imageValidFormats.type.includes(type),
      message: 'This image type is not accepted'
    },
    {
      condition: () => size <= imageValidFormats.maxSize,
      message: `The image is too big (max. size is ${imageValidFormats.maxSize / 1000000}Mb)`
    }
  ])

  return validityMessage
}

/* Esta función genérica permite pasar un input value y una función como condición,
si la función no retorna true, un mensaje de error se añade al array de validityMessage.
Si el validityMessage tiene un tamaño mayor a 0, significa que se ha retornado algún error
de validación */
function validate(conditions) {
  const validityMessage = []

  conditions.forEach((condition) => {
    if (!condition.condition()) {
      validityMessage.push(condition.message)
    }
  })

  return validityMessage
}
