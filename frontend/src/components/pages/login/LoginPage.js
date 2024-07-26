import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import LoginForm from '../../mid/login-form/LoginForm.js'
/* eslint-enable */

class LoginPage extends PlainComponent {
  constructor () {
    super('p-login-page', `${PAGES_PATH}login/LoginPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'login' })
  }

  template () {
    return `
            <p-login-form></p-login-form>
            <p-navbar></p-navbar>
            <span class="sign-up-link">Don't you have an account? <a href="#">Sign Up</a></span>
        `
  }
}

export default window.customElements.define('p-login-page', LoginPage)
