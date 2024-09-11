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
import Toast from '../../base/toast/Toast.js'

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
            <p-toast></p-toast>
            <div class="filler"></div>
            <img class="logo" src="${PUBLIC_PATH}assets/icons/logo.svg" width="100px" height="100px" alt="Logo">
            <p-login-form></p-login-form>
            <span class="sign-up-link">Don't you have an account? <a class="to-signup">Sign Up</a></span>
            <p class="caption">Share. Meet. Experience.</p>
            <div class="filler"></div>


        `
  }

  listeners() {
    this.$('.to-signup').onclick = () => helper.navigateTo(PAGE_ROUTES.SIGNUP)
  }

  getToast() {
    return this.$('p-toast')
  }
}

export default window.customElements.define('p-login-page', LoginPage)
