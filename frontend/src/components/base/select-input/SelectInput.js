import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../utils/validators.js'

/* CONSTANTS */
import { userGenres } from '../../../constants/userGenres.js'

class SelectInput extends PlainComponent {
  constructor () {
    super('p-select-input', `${BASE_COMPONENTS_PATH}select-input/SelectInput.css`)

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState({
      isValid: true,
      messages: []
    }, this)

    this.inputValue = new PlainState('', this)
  }

  // [ ] Crear dropdown personalizado
  template () {
    return `
            <label class="label">${this.getAttribute('label')}</label>
            
            <select 
            class="input" 
            name="${this.getAttribute('name')}" 
            value="${this.inputValue.getState()}">
                <option default hidden>Select an option</option>
                ${Object.entries(userGenres).map(([key, value]) =>
                    `<option value="${key}">${value}</option>`
                )}
            </select>

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

  }
}

export default window.customElements.define('p-select-input', SelectInput)
