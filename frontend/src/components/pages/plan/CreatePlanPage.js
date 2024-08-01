import { PlainComponent, PlainContext, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH, PAGES_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import CreatePlanForm from '../../mid/create-plan-form/CreatePlanForm.js'
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
/* eslint-enable */

/* UTILS */
import * as authenticator from '../../../utils/authenticator.js'

class CreatePlanPage extends PlainComponent {
  constructor () {
    super('p-create-plan-page', `${PAGES_PATH}plan/CreatePlanPage.css`)

    /* CONTEXTS */
    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'plan/create' })

    /* STATES */
    this.userIsAuthenticated = new PlainState(false, this)
  }

  template () {
    this.checkAuthentication()

    if (!this.userIsAuthenticated.getState()) {
      return `
        <p-loading-spinner></p-loading-spinner>
      `
    } 

    return `
            <p-create-plan-form class="create-plan-form"></p-create-plan-form>
            <p-navbar></p-navbar>
        `
  }

  async checkAuthentication () {
    const isAuthenticated = await authenticator.permissionGate(['user', 'admin'])
    if (!isAuthenticated) {
      this.navigateTo('login')
    } else {
      this.userIsAuthenticated.setState(true)
    }
  }

  navigateTo (path) {
    window.location.replace(PUBLIC_PATH + path)
  }
}

export default window.customElements.define('p-create-plan-page', CreatePlanPage)
