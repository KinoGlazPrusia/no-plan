import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../services/validators.js'

/* CONSTANTS */
import { phonePrefixes } from '../../../constants/phonePrefixes.js'

class PhoneInput extends PlainComponent {
  constructor () {
    super('p-phone-input', `${BASE_COMPONENTS_PATH}phone-input/PhoneInput.css`)

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState({
      isValid: true,
      messages: []
    }, this)

    this.inputValue = new PlainState('', this)
    this.phonePrefix = new PlainState('', this)
  }

  template () {
    return `
            <label class="label">${this.getAttribute('label')}</label>
            
            <input 
            class="input" 
            name="${this.getAttribute('name')}" 
            type="tel" 
            value="${this.inputValue.getState()}"
            list="phone-codes"
            maxlength="15"
            placeholder="Phone Number">

            <datalist id="phone-codes">
                ${Object.entries(phonePrefixes).map(([country, data]) =>
                    `<option value="${data.prefix}">${country}</option>`
                )}
            </datalist>

            <p-form-feedback class="feedback"></p-form-feedback>
        `
  }

  listeners () {
    this.$('.input').oninput = (e) => {
      // Actualización del input value
      this.updateValue()

      // Validación
      this.validator && this.validate()
    }
  }

  updateValue () {
    // this.inputValue.setState(this.formatValue(), false)
    this.inputValue.setState(this.$('.input').value.replace(/[\D]/g, ''), false)
    this.$('.input').value = `+${this.inputValue.getState()}`
  }

  formatValue() {
    // Pendiente de implementar
    const value = this.$('.input').value
    return value.replace(phonePrefixes.Spain.pattern, '$1 $2 $3 $4')
  }

  validate () {
    const value = this.inputValue.getState()

    let isValid = null
    const validityMessage = this.validator(value)

    validityMessage.length > 0
      ? isValid = false
      : isValid = true

    !isValid
      ? !this.wrapper.classList.contains('is-invalid') && this.wrapper.classList.add('is-invalid')
      : this.wrapper.classList.contains('is-invalid') && this.wrapper.classList.remove('is-invalid')

    this.validity.setState({
      isValid,
      messages: validityMessage
    }, false)

    // Re-renderizamos el componente de feedback para mostrar errores o mensajes
    this.$('.feedback').errors.setState(validityMessage)
  }
}

export default window.customElements.define('p-phone-input', PhoneInput)
