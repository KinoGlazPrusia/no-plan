import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

class SignUpPage extends PlainComponent {
  constructor () {
    super('p-signup-page', `${PAGES_PATH}signup/SignUpPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'signup' })
  }

  template () {
    return `
            <h1>Sign Up Page</h1>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-signup-page', SignUpPage)
