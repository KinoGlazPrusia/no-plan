import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH} from '../../../config/env.config.js'

class Button extends PlainComponent {
  constructor () {
    super('p-button', `${BASE_COMPONENTS_PATH}button/Button.css`)
  }

  template () {
    // Los botones pueden ser de 3 tipos: primary, secondary y tertiary
    return `
            <button class="button ${this.getAttribute('type')} ${this.hasAttribute('disabled') ? 'disabled' : ''}">
                ${this.getAttribute('icon')
                    ? `<span class="material-symbols-outlined">${this.getAttribute('icon')}</span>`
                    : this.textContent
                }
            </button>
        `
  }

  listeners () {
    this.$('.button').onclick = () => {
      this.handleClick()
    }
  }

  handleClick () {
    this.animateClick()
  }

  animateClick () {
    this.wrapper.classList.add('clicked')
    this.wrapper.onanimationend = () => this.wrapper.classList.remove('clicked')
  }

  enable () {
    if (this.$('.button').classList.contains('disabled')) {
      this.$('.button').classList.remove('disabled')
    }
  }

  disable() {
    if (!this.$('.button').classList.contains('disabled')) {
      this.$('.button').classList.add('disabled')
    }
  }
}

export default window.customElements.define('p-button', Button)
