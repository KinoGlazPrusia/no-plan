import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import * as apiPlan from '../../../services/api.plan.js'

/* CONSTANTS */
import { planFilters } from '../../../constants/planFilters.js'

class PlanCarousel extends PlainComponent {
  constructor() {
    super(
      'p-plan-carousel',
      `${MID_COMPONENTS_PATH}plan-carousel/PlanCarousel.css`
    )

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    this.data = new PlainState(null, this)
    this.cards = new PlainState(null, this)

    this.currentPage = new PlainState(1, this) // [ ] Elevar estos estados al componente de página
    this.itemsPerPage = new PlainState(3, this)
    this.maxPages = new PlainState(0, this)
  }

  async connectedCallback() {
    super.connectedCallback()
    await this.fetchData()
    this.centerSelectedCard()
  }

  template() {
    return `
      ${this.cards.getState() ? this.cards.getState().join('') : ''}
    `
  }

  listeners() {
    const cards = this.wrapper.querySelectorAll('.card-wrapper')
    cards.forEach((card) => {
      card.onclick = () => {
        cards.forEach((card) => this.deselectCard(card))
        this.selectCard(card)
        this.centerSelectedCard()
        // Aqui volvemos a llamar a la función de centrar el card
        // porque hay algún error que hace que el card no se centre completamente
        // hasta que se vuelve a ejecutar la función.
        // [ ] Revisar bug
        setTimeout(() => {
          this.centerSelectedCard()
        }, 310)
      }
    })
  }

  async fetchData() {
    await this.fetchPlans(this.getAttribute('filter'))
    await this.setMaxPages(this.getAttribute('filter'))
    await this.loadCards(this.getAttribute('filter'))
  }

  async fetchPlans(filter) {
    let plans
    switch (filter) {
      case planFilters.CREATED:
        plans = await apiPlan.fetchAllCreatedPlans(
          this.currentPage.getState(),
          this.itemsPerPage.getState()
        )
        break
      case planFilters.ACCEPTED:
        plans = await apiPlan.fetchAllAcceptedPlans(
          this.currentPage.getState(),
          this.itemsPerPage.getState()
        )
        break
      case planFilters.REJECTED:
        plans = await apiPlan.fetchAllRejectedPlans(
          this.currentPage.getState(),
          this.itemsPerPage.getState()
        )
        break
      case planFilters.PENDING:
        plans = await apiPlan.fetchAllPendingPlans(
          this.currentPage.getState(),
          this.itemsPerPage.getState()
        )
        break
      default:
        plans = await apiPlan.fetchAllPlans(
          this.currentPage.getState(),
          this.itemsPerPage.getState()
        )
        break
    }

    this.data.setState(plans.data, false)
  }

  async setMaxPages(filter) {
    let planCount

    switch (filter) {
      case planFilters.CREATED:
        planCount = await apiPlan.countAllCreatedPlans()
        break
      case planFilters.ACCEPTED:
        planCount = await apiPlan.countAllAcceptedPlans()
        break
      case planFilters.REJECTED:
        planCount = await apiPlan.countAllRejectedPlans()
        break
      case planFilters.PENDING:
        planCount = await apiPlan.countAllPendingPlans()
        break
      default:
        planCount = await apiPlan.countAllNotCreatedPlans()
        break
    }

    const maxPages = Math.ceil(planCount / this.itemsPerPage.getState())
    this.maxPages.setState(maxPages, false)

    if (maxPages <= 1) {
      this.parentComponent.disablePaginator()
    } else {
      this.parentComponent.enablePaginator()
    }
  }

  async loadCards(filter) {
    const cards = this.data.getState().map((planData, index) => {
      const card =
        index === 0
          ? `
          <div class="card-wrapper selected-card">
            <p-plan-card 
              plan-data='${JSON.stringify(planData)}' 
              plan-id="${planData.id}"
              ${filter === 'created' ? 'editable="true"' : ''}>
            </p-plan-card>
          </div>
        `
          : `
          <div class="card-wrapper">
            <p-plan-card 
              plan-data='${JSON.stringify(planData)}' 
              plan-id="${planData.id}"
              ${filter === 'created' ? 'editable="true"' : ''}>
            </p-plan-card>
          </div>
        `
      return card
    })

    this.cards.setState(cards)
  }

  selectCard(card) {
    card.classList.add('selected-card')
  }

  deselectCard(card) {
    card.classList.remove('selected-card')
  }

  centerSelectedCard() {
    const selectedCard = this.$('.selected-card')

    if (!selectedCard) return

    requestAnimationFrame(() => {
      const wrapperRect = this.wrapper.getBoundingClientRect()
      const selectedCardRect = selectedCard.getBoundingClientRect()

      let offset = selectedCardRect.left - wrapperRect.left
      offset -= wrapperRect.width / 2
      offset += selectedCardRect.width / 2

      requestAnimationFrame(() => {
        this.wrapper.style.transform = `translateX(${-offset}px)`
      })
    })
  }

  async nextPage() {
    const currentPage = this.currentPage.getState()

    if (currentPage < this.maxPages.getState()) {
      this.currentPage.setState(this.currentPage.getState() + 1, false)
      if (this.currentPage.getState() > 1) this.parentComponent.enableLeft()
      if (this.currentPage.getState() === this.maxPages.getState())
        this.parentComponent.disableRight()

      await this.fetchData()
      this.centerSelectedCard()
    } else {
      this.parentComponent.disableRight()
    }
  }

  async prevPage() {
    const currentPage = this.currentPage.getState()

    if (currentPage > 1) {
      this.parentComponent.enableLeft()
      this.currentPage.setState(this.currentPage.getState() - 1, false)
      if (this.currentPage.getState() < this.maxPages.getState())
        this.parentComponent.enableRight()
      if (this.currentPage.getState() === 1) this.parentComponent.disableLeft()

      await this.fetchData()
      this.centerSelectedCard()
    } else {
      this.parentComponent.disableLeft()
    }
  }
}

export default window.customElements.define('p-plan-carousel', PlanCarousel)
