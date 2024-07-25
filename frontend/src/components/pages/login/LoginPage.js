import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

class LoginPage extends PlainComponent {
  constructor () {
    super('p-login-page', `${PAGES_PATH}login/LoginPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'login' })
  }

  template () {
    return `
            <h1>Login Page</h1>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-login-page', LoginPage)
