import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH, PAGES_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import SignUpForm from '../../mid/signup-form/SignUpForm.js'
/* eslint-enable */

class SignUpPage extends PlainComponent {
  constructor () {
    super('p-signup-page', `${PAGES_PATH}signup/SignUpPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'signup' })
  }

  template () {
    return `
            <p-signup-form></p-signup-form>
            <p-navbar></p-navbar>
            <span class="login-link">Already have an account? <a class="to-login">Log In</a></span>
        `
  }

  listeners() {
    this.$('.to-login').onclick = () => this.navigateTo('login')
  }

  navigateTo (path) {
    window.location.replace(PUBLIC_PATH + path)
  }
}

export default window.customElements.define('p-signup-page', SignUpPage)
