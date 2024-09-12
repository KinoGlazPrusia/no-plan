import {
  PlainComponent,
  PlainState,
  PlainContext
} from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

/* UTILS */
import * as helper from '../../../utils/helper.js'
import * as auth from '../../../utils/authenticator.js'

/* CONSTANTS */
import { planFilters } from '../../../constants/planFilters.js'

/* COMPONENTS */
import EditPlanModal from '../../mid/edit-plan-modal/EditPlanModal.js'

class UserPlansPage extends PlainComponent {
  constructor() {
    super('p-user-plans-page', `${PAGES_PATH}user/UserPlansPage.css`)

    auth.checkAuthentication(['user', 'admin'], null, () =>
      helper.navigateTo(PAGE_ROUTES.LOGIN)
    )

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'user/plans' })

    this.userContext = new PlainContext('user', this, false)
    this.userContext.setData(this.userData, false)
    auth.fetchLoggedUserDataInContext(this.userContext)

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)

    this.currentTab = new PlainState(planFilters.CREATED, this)
    this.currentPage = new PlainState(1, this)
  }

  template() {
    return `
            <!-- LOGOUT BUTTON -->
            <p-logout-button></p-logout-button>

            <!-- PLAN CAROUSEL -->
            <p-plan-carousel filter="${this.currentTab.getState()}"></p-plan-carousel>
      
            <!-- FADES -->
            <span class="fade-left"></span>
            <span class="fade-right"></span>

            <div class="controls">
            
              <!-- PLAN TABS -->
              <div class="plan-tabs">
                <span class="tab ${this.currentTab.getState() === planFilters.CREATED ? 'selected' : ''}" id="created"><span class="material-symbols-outlined">edit_note</span></span>
                <span class="tab ${this.currentTab.getState() === planFilters.ACCEPTED ? 'selected' : ''}" id="accepted"><span class="material-symbols-outlined">check_circle</span></span>
                <span class="tab ${this.currentTab.getState() === planFilters.REJECTED ? 'selected' : ''}" id="rejected"><span class="material-symbols-outlined">close</span></span>
                <span class="tab ${this.currentTab.getState() === planFilters.PENDING ? 'selected' : ''}" id="pending"><span class="material-symbols-outlined">mail</span></span>
              </div>

              <!-- PAGE SELECTOR -->
              <div class="button-wrapper paginator">
                <button class="left-button disabled">
                  <span class="icon material-symbols-outlined">chevron_left</span>
                </button>

                <span class="page-number">${this.currentPage.getState() && this.currentPage.getState()}</span>

                <button class="right-button">
                  <span class="icon material-symbols-outlined">chevron_right</span>
                </button>
              </div>
            </div>

            <!-- EDIT PLAN MODAL -->
            <p-edit-plan-modal></p-edit-plan-modal>

            <!-- PAGE SELECTOR -->
            <p-navbar></p-navbar>
        `
  }

  listeners() {
    this.$('.left-button').onclick = () => this.prevPage()
    this.$('.right-button').onclick = () => this.nextPage()

    const tabs = this.$$('.tab')
    tabs.forEach((tab) => {
      tab.onclick = () => this.changeTab(tab)
    })
  }

  openEditor(data) {
    this.$('p-edit-plan-modal').open()
    this.$('p-edit-plan-modal').setPlanData(data)
  }

  closeEditor() {
    this.$('p-edit-plan-modal').close()
  }

  changeTab(tab) {
    const tabs = this.$$('.tab')
    tabs.forEach((tab) => {
      tab.classList.remove('selected')
    })

    tab.classList.add('selected')

    this.currentTab.setState(tab.id)
  }

  getPage() {
    // [ ] Esto va fuera, habrá que elevar el estado a este componente de página
    const carousel = this.$('p-plan-carousel')
    return carousel.currentPage.getState()
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

  enablePaginator() {
    this.$('.paginator').style.display = 'flex'
  }

  disablePaginator() {
    this.$('.paginator').style.display = 'none'
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

export default window.customElements.define('p-user-plans-page', UserPlansPage)
