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
import PlanCarousel from '../../mid/plan-carousel/PlanCarousel.js'
import PlanCard from '../../base/plan-card/PlanCard.js'

class PlannerPage extends PlainComponent {
  constructor() {
    super('p-planner-page', `${PAGES_PATH}planner/PlannerPage.css`)

    // [ ] Reactivar esto
    /* auth.checkAuthentication(['user', 'admin'], null, () =>
      helper.navigateTo(PAGE_ROUTES.LOGIN)
    )*/ 

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'planner' }, true)

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    this.data = new PlainState(null, this)
  }

  template() {
    return `
            <p-logout-button></p-logout-button>
            <p-plan-card></p-plan-card>
            <p-plan-carousel></p-plan-carousel>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-planner-page', PlannerPage)
