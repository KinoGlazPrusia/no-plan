import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../utils/validators.js'

class SelectCheckboxInput extends PlainComponent {
    constructor() {
        super('p-select-checkbox-input', `${BASE_COMPONENTS_PATH}select-checkbox-input/SelectCheckboxInput.css`)

        this.validator = validators[this.getAttribute('validator')]
        this.validity = new PlainState({
        isValid: true,
        messages: []
        }, this)

        // El argumento se le ha de pasar con un JSON.stringify(array)
        this.options = new PlainState(
            JSON.parse(this.getAttribute('options')), 
            this
        )

        this.inputValue = new PlainState('', this)
    }

    template() {
        return `
            ${this.options.getState().map(option => {
                return `
                    <input 
                    class="input"
                    name="checkbox-option-${option}" 
                    type="checkbox" 
                    id="checkbox-option-${option}" 
                    value="${option}" />

                    <label for="checkbox-option-${option}">${option}</label>
                `
            })}
        `
    }
} 

export default window.customElements.define('p-select-checkbox-input', SelectCheckboxInput)