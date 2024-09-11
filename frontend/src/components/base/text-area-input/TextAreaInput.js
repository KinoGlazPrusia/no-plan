// [x] Crear componente TextArea
import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../utils/validators.js'

class TextAreaInput extends PlainComponent {
  constructor() {
    super(
      'p-text-area-input',
      `${BASE_COMPONENTS_PATH}text-area-input/TextAreaInput.css`
    )

    this.maxChar = this.getAttribute('maxlength')

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState(
      {
        isValid: true,
        messages: []
      },
      this
    )

    this.charCounter = new PlainState(0, this)
    this.inputValue = new PlainState('', this)
  }

  template() {
    return `
            <label class="label">${this.getAttribute('label')}</label>

            <span class="counter">${this.charCounter.getState()} / ${this.maxChar}</span>

            <textarea 
            class="input" 
            name="${this.getAttribute('name')}" 
            maxlength="${this.maxChar}"
            id="${this.getAttribute('id')}">${this.inputValue.getState()}</textarea>

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
    this.updateCounter()
  }

  updateCounter() {
    // Esto debería manejarse desde otro componente y renderizando cada vez que cambia el estado
    // Por motivos de rapidez lo hago desde aquí
    this.charCounter.setState(this.inputValue.getState().length, false)
    this.$('.counter').textContent =
      `${this.charCounter.getState()} / ${this.maxChar}`
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

  reset() {
    this.wrapper.classList.remove('is-invalid')
    this.wrapper.classList.remove('is-valid')
    this.inputValue.setState('', false)
    this.$('.text-area').value = ''
  }

  updateFeedback() {
    // Re-renderizamos el componente de feedback para mostrar errores o mensajes
    this.$('.feedback').errors.setState(this.validity.getState().messages)
  }
}

export default window.customElements.define('p-text-area-input', TextAreaInput)
