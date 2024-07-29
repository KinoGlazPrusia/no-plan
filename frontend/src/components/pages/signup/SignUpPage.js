import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

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
            <span class="sign-up-link">Already have an account? <a href="#">Log In</a></span>
        `
  }
}

export default window.customElements.define('p-signup-page', SignUpPage)
