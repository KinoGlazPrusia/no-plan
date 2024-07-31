import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
import LogoutButton from '../../base/logout-button/LogoutButton.js'
/* eslint-enable */

class PlannerPage extends PlainComponent {
  constructor () {
    super('p-planner-page', `${PAGES_PATH}planner/PlannerPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'planner' }, true)
  }

  template () {
    return `
            <p-logout-button></p-logout-button>
            <p-loading-spinner class="spinner"></p-loading-spinner>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-planner-page', PlannerPage)
