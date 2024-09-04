import { PlainComponent} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* UTILS */
import * as helper from '../../../utils/helper.js'

class NavbarButton extends PlainComponent {
  constructor () {
    super('p-navbar-button', `${BASE_COMPONENTS_PATH}navbar-button/NavbarButton.css`)
  }

  template () {
    return `
            <button class="button ${this.getAttribute('selected') ? 'selected' : ''}">
                <span class="material-symbols-outlined">${this.getAttribute('icon')}</span>
            </button>
        `
  }

  listeners () {
    this.$('.button').onclick = () => {
      this.handleClick()
      helper.navigateTo(this.getAttribute('path'))
    }
  }

  handleClick () {
    this.animateClick()
  }

  animateClick () {
    this.wrapper.classList.add('clicked')
    this.wrapper.onanimationend = () => this.wrapper.classList.remove('clicked')
  }
}

export default window.customElements.define('p-navbar-button', NavbarButton)
