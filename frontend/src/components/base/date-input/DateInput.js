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
        this.cursorPosition = new PlainState(0, this)
    }

    template() {
        return `
            <label class="label">${this.getAttribute('label')}</label>
            <input 
            class="input" 
            name="${this.getAttribute('name')}" 
            type="text" 
            value="${this.inputValue.getState()}"
            placeholder="${this.hasAttribute('placeholder') ? this.getAttribute('placeholder') : ''}">
            <div class="error-list">
              ${this.validity.getState().messages.map(error => {
                return `
                  <div class="error-wrapper">
                    <span class="error-icon material-symbols-outlined">error</span>
                    <span class="error">${error}</span>
                  </div>
                `
              }).join('')}
            </div>
        `
    }
}

export default window.customElements.define('p-date-input', DateInput)