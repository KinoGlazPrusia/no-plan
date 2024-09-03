import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

class Button extends PlainComponent {
  static get observedAttributes() {
    return ['type', 'icon', 'disabled']
  }

  constructor() {
    super('p-button', `${BASE_COMPONENTS_PATH}button/Button.css`)
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue !== newValue) {
      this.render()
    }
  }

  template() {
    // Los botones pueden ser de 3 tipos: primary, secondary y tertiary
    const type = this.getAttribute('type') || 'primary'
    const disabled = this.hasAttribute('disabled') ? 'disabled' : ''
    const icon = this.getAttribute('icon')

    return `
      <button class="button ${type} ${disabled}" ${disabled ? 'disabled' : ''}>
        <div class="icon-wrapper">
          ${icon ? this.renderIcon(icon) : ''}
          <span>${this.textContent}</span>
        </div>
      </button>
    `
  }

  renderIcon(icon) {
    return `
        <span class="icon material-symbols-outlined">${icon}</span>
    `
  }

  listeners() {
    this.$('.button').onclick = () => {
      this.handleClick()
    }
  }

  handleClick() {
    this.animateClick()
  }

  animateClick() {
    this.wrapper.classList.add('clicked')
    this.wrapper.onanimationend = () => this.wrapper.classList.remove('clicked')
  }

  enable() {
    this.toggleAttribute('disabled', false)
    this.updateDisabledClass()
  }

  disable() {
    this.toggleAttribute('disabled', true)
    this.updateDisabledClass()
  }

  updateDisabledClass() {
    const button = this.$('.button')
    button.classList.toggle('disabled', this.hasAttribute('disabled'))
  }
}

export default window.customElements.define('p-button', Button)
