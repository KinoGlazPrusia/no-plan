import { imageValidFormats } from '../constants/imageValidFormats.js'

/* Este objeto sirve de ENUM para recuperar los nombres de las funciones
de validación, que pasaremos en un atributo a los componentes input para
poder cargar las funciones */
export const VALIDATORS = {
    EMAIL: 'validateEmail',
    STRING: 'validateString',
    DATE: 'validateDate',
    AVATAR_IMAGE_FILE: 'validateAvatarImage'
}

export function validateEmail(email) {
    const regexEmailFormat = new RegExp(/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/gi)

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

// TERMINAR LA IMPLEMENTACIÓN
export function validateDate(rawDate) {
    const [year, month, day] = rawDate.split('-')
    const date = {
        year: year,
        month: month,
        day: day,
        raw: rawDate
    }

    console.table(date)
}

export function validateAvatarImage(file) {
    const { type, size } = file

    const validityMessage = validate([
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
    let validityMessage = []

    conditions.forEach(condition => {
        if (!condition.condition()) {
            validityMessage.push(condition.message)
        } 
    })

    return validityMessage
}