import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH, BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import * as apiAuth from '../../../services/api.auth.js'

class LogoutButton extends PlainComponent {
  constructor () {
    super('p-logout-button', `${BASE_COMPONENTS_PATH}logout-button/LogoutButton.css`)

    this.userContext = new PlainContext('user', this, false)

    this.checkAuthentication()
  }

  template () {
    return `
            <button class="button">
                <span class="material-symbols-outlined">power_settings_new</span>
            </button>
        `
  }

  async checkAuthentication () {
    const isAuthenticated = await apiAuth.isAuthenticated()
    this.wrapper.classList.toggle('disabled', !isAuthenticated.data[0])
  }

  listeners () {
    this.$('.button').onclick = () => this.handleClick()
  }

  async handleClick () {
    this.animateClick()

    const response = await apiAuth.logout()
    this.handleResponse(response)
  }

  handleResponse (response) {
    if (response.status === 'success') {
      this.userContext.clear()
      this.navigateTo('')
    }
  }

  animateClick () {
    this.wrapper.classList.add('clicked')
    this.wrapper.onanimationend = () => this.wrapper.classList.remove('clicked')
  }

  navigateTo (path) {
    window.location.replace(PUBLIC_PATH + path)
  }
}

export default window.customElements.define('p-logout-button', LogoutButton)
