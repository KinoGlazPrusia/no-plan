import {
  PlainComponent,
  PlainContext,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH, PAGE_ROUTES } from '../../../config/env.config.js'

/* UTILS */
import * as helper from '../../../utils/helper.js'
import * as auth from '../../../utils/authenticator.js'

/* COMPONENTS */
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
import LogoutButton from '../../base/logout-button/LogoutButton.js'

class PlannerPage extends PlainComponent {
  constructor() {
    super('p-planner-page', `${PAGES_PATH}planner/PlannerPage.css`)

    auth.checkAuthentication(['user', 'admin'], null, () =>
      helper.navigateTo(PAGE_ROUTES.LOGIN)
    )

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'planner' }, true)

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    this.data = new PlainState(null, this)
  }

  template() {
    return `
            <p-logout-button></p-logout-button>
            <p-loading-spinner class="spinner"></p-loading-spinner>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-planner-page', PlannerPage)
