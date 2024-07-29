import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../services/validator.js'

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
    this.inputValue.setState(this.$('.input').value.replace(/\D/g, ''), false)
    this.$('.input').value = `+${this.inputValue.getState()}`
  }

  validate () {

  }
}

export default window.customElements.define('p-phone-input', PhoneInput)
