import {
  PlainComponent,
  PlainContext,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import {
  PUBLIC_PATH,
  PAGES_PATH,
  PAGE_ROUTES
} from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import CreatePlanForm from '../../mid/create-plan-form/CreatePlanForm.js'
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
import LogoutButton from '../../base/logout-button/LogoutButton.js'
/* eslint-enable */

/* UTILS */
import * as auth from '../../../utils/authenticator.js'
import * as helper from '../../../utils/helper.js'

class CreatePlanPage extends PlainComponent {
  constructor() {
    super('p-create-plan-page', `${PAGES_PATH}plan/CreatePlanPage.css`)

    auth.checkAuthentication(['user', 'admin'], null, () =>
      helper.navigateTo(PAGE_ROUTES.LOGIN)
    )

    /* CONTEXTS */
    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'plan/create' })
  }

  template() {
    return `
            <p-toast></p-toast>
            <p-logout-button></p-logout-button>
            <p-create-plan-form class="create-plan-form"></p-create-plan-form>
            <p-navbar></p-navbar>
        `
  }

  getToast() {
    return this.$('p-toast')
  }
}

export default window.customElements.define(
  'p-create-plan-page',
  CreatePlanPage
)
