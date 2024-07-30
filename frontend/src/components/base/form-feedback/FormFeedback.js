import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

class FormFeedback extends PlainComponent {
    constructor() {
        super('p-form-feedback', `${BASE_COMPONENTS_PATH}form-feedback/FormFeedback.css`)

        this.messages = new PlainState([], this)
        this.errors =  new PlainState([], this)
    }

    template() {
        return `
            <div class="error-list">
                ${this.errors.getState().map(error => {
                    return `
                        <div class="error-wrapper">
                        <span class="error-icon material-symbols-outlined">error</span>
                        <span class="error">${error}</span>
                        </div>
                    `
                }).join('')}
            </div>
            <div class="message-list">
                ${this.messages.getState().map(message => {
                    return `
                        <div class="message-wrapper">
                        <span class="message-icon material-symbols-outlined">check</span>
                        <span class="message">${message}</span>
                        </div>
                    `
                }).join('')}
            </div>
        `
    }
}

export default window.customElements.define('p-form-feedback', FormFeedback)