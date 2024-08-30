import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH, PAGES_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'

/* SERVICES */
import * as apiAuth from '../../../services/api.auth.js'

/* UTILS */
import * as authenticator from '../../../utils/authenticator.js'

class IndexPage extends PlainComponent {
  constructor() {
    super('p-index-page', `${PAGES_PATH}index/IndexPage.css`)

    this.checkAuthentication()
  }

  template() {
    return `
      <p-loading-spinner></p-loading-spinner>
    `
  }

  async checkAuthentication() {
    const isAuthenticated = await authenticator.permissionGate([
      'user',
      'admin'
    ])
    isAuthenticated ? this.navigateTo('planner') : this.navigateTo('login')
  }

  navigateTo(path) {
    window.location.replace(PUBLIC_PATH + path)
  }
}

export default window.customElements.define('p-index-page', IndexPage)
