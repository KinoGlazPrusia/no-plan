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
    auth.checkAuthentication(['user', 'admin'], null, () =>
      helper.navigateTo(PAGE_ROUTES.LOGIN)
    )

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'planner' }, true)

    this.userContext = new PlainContext('user', this, false)
    this.userContext.setData(this.userData, false)
    auth.fetchLoggedUserDataInContext(this.userContext)

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    this.data = new PlainState(null, this)

    this.currentPage = new PlainState(1, this)
  }

  template() {
    return `
            <!-- LOGOUT BUTTON -->
            <p-logout-button></p-logout-button>

            <!-- PLAN CAROUSEL -->
            <p-plan-carousel></p-plan-carousel>
      
            <!-- FADES -->
            <span class="fade-left"></span>
            <span class="fade-right"></span>

            <!-- PAGE SELECTOR -->
            <div class="button-wrapper">
              <button class="left-button disabled">
                <span class="icon material-symbols-outlined">chevron_left</span>
              </button>

              <span class="page-number">${this.currentPage.getState()}</span>

              <button class="right-button">
                <span class="icon material-symbols-outlined">chevron_right</span>
              </button>
            </div>

            <!-- NAVBAR -->
            <p-navbar></p-navbar>
        `
  }

  getPage() {
    // [ ] Esto va fuera, habrá que elevar el estado a este componente de página
    const carousel = this.$('p-plan-carousel')
    return carousel.currentPage.getState()
  }

  listeners() {
    this.$('.left-button').onclick = () => this.prevPage()
    this.$('.right-button').onclick = () => this.nextPage()
  }

  enableRight() {
    this.$('.right-button').classList.remove('disabled')
  }

  disableRight() {
    // [ ] Estos métodos deshabilitaran los botones de paso de página
    this.$('.right-button').classList.add('disabled')
  }

  enableLeft() {
    this.$('.left-button').classList.remove('disabled')
  }

  disableLeft() {
    this.$('.left-button').classList.add('disabled')
  }

  nextPage() {
    const carousel = this.$('p-plan-carousel')
    carousel.nextPage()
    this.currentPage.setState(this.currentPage.getState() + 1, false)
    this.$('.page-number').textContent =
      Number(this.$('.page-number').textContent) + 1
    // [ ] Esto se podría evitar creando un componente a parte o con VirtualDom para renderizar solo el
    // elemento que estamos actualizando.
  }

  prevPage() {
    const carousel = this.$('p-plan-carousel')
    carousel.prevPage()
    this.currentPage.setState(this.currentPage.getState() - 1, false)
    this.$('.page-number').textContent =
      Number(this.$('.page-number').textContent) - 1
  }
}

export default window.customElements.define('p-planner-page', PlannerPage)
