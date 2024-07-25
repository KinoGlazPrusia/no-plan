import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH, BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

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
      this.navigateTo(this.getAttribute('path'))
    }
  }

  handleClick () {
    this.animateClick()
  }

  animateClick () {
    this.wrapper.classList.add('clicked')
    this.wrapper.onanimationend = () => this.wrapper.classList.remove('clicked')
  }

  navigateTo (path) {
    window.location.replace(PUBLIC_PATH + path)
  }
}

export default window.customElements.define('p-navbar-button', NavbarButton)
