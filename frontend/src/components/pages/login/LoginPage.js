import {
  PlainComponent,
  PlainContext
} from '../../../../node_modules/plain-reactive/src/index.js'
import {
  PUBLIC_PATH,
  PAGES_PATH,
  PAGE_ROUTES
} from '../../../config/env.config.js'

/* SERVICES */
import * as apiAuth from '../../../services/api.auth.js'

/* UTILS */
import * as auth from '../../../utils/authenticator.js'
import * as helper from '../../../utils/helper.js'

/* COMPONENTS */
import LoginForm from '../../mid/login-form/LoginForm.js'

class LoginPage extends PlainComponent {
  constructor() {
    super('p-login-page', `${PAGES_PATH}login/LoginPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'login' })

    auth.checkAuthentication(
      ['user', 'admin'],
      () => helper.navigateTo(PAGE_ROUTES.PLANNER),
      null
    )
  }

  template() {
    return `
            <p-login-form></p-login-form>
            <p-navbar></p-navbar>
            <span class="sign-up-link">Don't you have an account? <a class="to-signup">Sign Up</a></span>
        `
  }

  listeners() {
    this.$('.to-signup').onclick = () => helper.navigateTo(PAGE_ROUTES.SIGNUP)
  }
}

export default window.customElements.define('p-login-page', LoginPage)
