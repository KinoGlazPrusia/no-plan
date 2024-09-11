import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../utils/validators.js'

class DateInput extends PlainComponent {
  constructor() {
    super('p-date-input', `${BASE_COMPONENTS_PATH}date-input/DateInput.css`)

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState(
      {
        isValid: true,
        messages: []
      },
      this
    )

    this.inputValue = new PlainState('', this)
  }

  template() {
    return `
            <label class="label">${this.getAttribute('label')}</label>
            
            <input 
            class="input ${this.hasAttribute('no-calendar') && 'no-calendar'}" 
            name="${this.getAttribute('name')}" 
            type="date" 
            value="${this.inputValue.getState()}"
            placeholder="DD/MM/YYYY">

            <p-form-feedback class="feedback"></p-form-feedback>
        `
  }

  listeners() {
    this.$('.input').oninput = (e) => {
      // Actualización del input value
      this.updateValue()

      // Validación
      this.validator && this.validate()
    }
  }

  updateValue() {
    this.inputValue.setState(this.$('.input').value, false)
  }

  validate() {
    const value = this.$('.input').value

    let isValid = null
    const validityMessage = this.validator(value)

    validityMessage.length > 0 ? (isValid = false) : (isValid = true)

    !isValid
      ? !this.wrapper.classList.contains('is-invalid') &&
        this.wrapper.classList.add('is-invalid')
      : this.wrapper.classList.contains('is-invalid') &&
        this.wrapper.classList.remove('is-invalid')

    this.validity.setState(
      {
        isValid,
        messages: validityMessage
      },
      false
    )

    // Re-renderizamos el componente de feedback para mostrar errores o mensajes
    this.updateFeedback()
  }

  updateFeedback() {
    // Re-renderizamos el componente de feedback para mostrar errores o mensajes
    this.$('.feedback').errors.setState(this.validity.getState().messages)
  }
}

export default window.customElements.define('p-date-input', DateInput)
