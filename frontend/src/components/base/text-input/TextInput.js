import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import FormFeedback from '../form-feedback/FormFeedback.js'
/* eslint-enable */

/* SERVICES */
import * as validators from '../../../services/validators.js'

class TextInput extends PlainComponent {
  constructor () {
    super('p-text-input', `${BASE_COMPONENTS_PATH}text-input/TextInput.css`)

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState({
      isValid: true,
      messages: []
    }, this)

    this.inputValue = new PlainState('', this)
  }

  template () {
    return `
            <label class="label">${this.getAttribute('label')}</label>

            <input 
            class="input" 
            name="${this.getAttribute('name')}" 
            type="${this.getAttribute('type')}" 
            value="${this.inputValue.getState()}"
            maxlength="${this.hasAttribute('maxlength') ? this.getAttribute('maxlength') : 200}"
            placeholder="${this.hasAttribute('placeholder') ? this.getAttribute('placeholder') : ''}">
            
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
    this.inputValue.setState(this.$('.input').value, false)
  }

  validate () {
    const value = this.$('.input').value

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

export default window.customElements.define('p-text-input', TextInput)
