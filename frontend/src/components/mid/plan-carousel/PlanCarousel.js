import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import * as apiPlan from '../../../services/api.plan.js'

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
    this.offsets = new PlainState(null, this)
  }

  async connectedCallback() {
    super.connectedCallback()
    await this.fetchData()
    this.centerSelectedCard()
  }

  template() {
    return `
      ${this.cards.getState() && this.cards.getState().join('')}
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
    await this.fetchPlans()
    await this.loadCards()
  }

  async fetchPlans() {
    const plans = await apiPlan.fetchAllPlans()
    this.data.setState(plans.data, false)
    console.log(plans.data)
  }

  async loadCards() {
    const cards = this.data.getState().map((planData, index) => {
      const card =
        index === 0
          ? `
        <div class="card-wrapper selected-card">
          <p-plan-card plan-data='${JSON.stringify(planData)}'></p-plan-card>
        </div>
      `
          : `
        <div class="card-wrapper">
          <p-plan-card plan-data='${JSON.stringify(planData)}'></p-plan-card>
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
}

export default window.customElements.define('p-plan-carousel', PlanCarousel)
