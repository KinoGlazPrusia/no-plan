import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../utils/validators.js'

class SelectInput extends PlainComponent {
  constructor() {
    super(
      'p-select-input',
      `${BASE_COMPONENTS_PATH}select-input/SelectInput.css`
    )

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState(
      {
        isValid: true,
        messages: []
      },
      this
    )

    // El argumento se le ha de pasar con un JSON.stringify(object)
    this.options = new PlainState(
      JSON.parse(this.getAttribute('options')),
      this
    )

    this.inputValue = new PlainState(
      this.hasAttribute('multiple') ? [] : '',
      this
    )
  }

  template() {
    return `
          <label class="label">${this.getAttribute('label')}</label>
          <div class="overflow-wrapper">
              <select 
              class="input ${this.hasAttribute('multiple') && 'multiple'}"
              name="${this.getAttribute('name')}" 
              value="${this.inputValue.getState()}"
              ${this.hasAttribute('multiple') && 'multiple'}>
                  <option default hidden>Select an option</option>
                  ${Object.entries(this.options.getState()).map(
                    ([key, value]) => `<option value="${key}">${value}</option>`
                  )}
              </select>

          </div>
          <p-form-feedback class="feedback"></p-form-feedback>
        `
  }

  listeners() {
    this.$('.input').oninput = (e) => {
      // Actualización del input value
      this.updateValue()
    }

    this.$('.input').onblur = () => {
      // Validación
      this.validator && this.validate()
    }
  }

  updateValue() {
    if (this.hasAttribute('multiple')) {
      const selectedOptions = Array.from(this.$('.input').selectedOptions).map(
        (option) => option.value
      )
      this.inputValue.setState(selectedOptions, false)
    } else {
      this.inputValue.setState(this.$('.input').value, false)
    }
    console.log(this.inputValue.getState())
  }

  selectOption(key) {
    this.$(`.input option[value="${key}"]`).selected = true

    if (!this.hasAttribute('multiple')) {
      this.inputValue.setState(key, false)
      return
    }

    const prevInput = this.inputValue.getState()
    prevInput.push(key)

    this.inputValue.setState(prevInput, false)
  }

  validate() {
    const value = this.$('.input').selectedOptions

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

export default window.customElements.define('p-select-input', SelectInput)
