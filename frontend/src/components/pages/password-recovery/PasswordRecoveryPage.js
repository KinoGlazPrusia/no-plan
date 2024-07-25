import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

class PasswordRecoveryPage extends PlainComponent {
  constructor () {
    super('p-password-recovery-page', `${PAGES_PATH}password-recovery/PasswordRecoveryPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'password-recovery' })
  }

  template () {
    return `
            <h1>Password Recovery Page</h1>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-password-recovery-page', PasswordRecoveryPage)
