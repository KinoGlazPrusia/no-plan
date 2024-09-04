import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

/* SERVICES */
import * as apiAuth from '../../../services/api.auth.js'

class UserProfilePage extends PlainComponent {
  constructor () {
    super('p-user-profile-page', `${PAGES_PATH}user/UserProfilePage.css`)

    apiAuth.isAuthenticated(['user', 'admin'], null, () =>
      helper.navigateTo(PAGE_ROUTES.LOGIN)
    )

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'user/profile' })
  }

  template () {
    return `
            <h1>User Profile Page</h1>
            <p-logout-button></p-logout-button>	
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-user-profile-page', UserProfilePage)
