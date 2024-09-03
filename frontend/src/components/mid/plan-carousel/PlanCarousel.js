import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

class PlanCarousel extends PlainComponent {
  constructor() {
    super(
      'p-plan-carousel',
      `${MID_COMPONENTS_PATH}plan-carousel/PlanCarousel.css`
    )

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    this.data = new PlainState(null, this)
  }

  connectedCallback() {
    super.connectedCallback()

    this.fetchPlans()
    this.loadCards()
  }

  template() {}

  async fetchPlans() {
    // Llamamos a la api
  }

  loadCards() {
    const cards = this.data.getState().map((planData) => {
      const card = document.createElement('p-plan-card')
      card.planData.loadPlanData(planData)

      return card
    })

    cards.forEach((card) => this.$('.card-wrapper').appendChild(card))
  }
}

export default window.customElements.define('p-plan-carousel', PlanCarousel)
