import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

class TextInput extends PlainComponent {
  constructor () {
    super('p-text-input', `${BASE_COMPONENTS_PATH}text-input/TextInput.css`)
  }

  template () {
    return `
            <label class="label">${this.getAttribute('label')}</label>
            <input name="${this.getAttribute('name')}" type="${this.getAttribute('type')}" placeholder="${this.getAttribute('placeholder')}">
            <span class="error"></span>
            <span class="error-icon material-symbols-outlined">alert</span>
        `
  }
}

export default window.customElements.define('p-text-input', TextInput)
