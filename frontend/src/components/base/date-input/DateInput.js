import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import * as validators from '../../../services/validator.js'

class DateInput extends PlainComponent {
    constructor() {
        super('p-date-input', `${BASE_COMPONENTS_PATH}date-input/DateInput.css`)

        this.validator = validators[this.getAttribute('validator')]
        this.validity = new PlainState({
        isValid: true,
        messages: []
        }, this)

        this.inputValue = new PlainState('', this)
    }

    template() {
        return `
            <label class="label">${this.getAttribute('label')}</label>
            
            <input 
            class="input" 
            name="${this.getAttribute('name')}" 
            type="date" 
            value="${this.inputValue.getState()}"
            placeholder="DD/MM/YYYY">
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
        console.log(this.inputValue.getState())
    }

    validate() {
        const value = this.$('.input').value
    
        let isValid = null
        const validityMessage = this.validator(value)
    }
}

export default window.customElements.define('p-date-input', DateInput)