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
  }

  async connectedCallback() {
    await this.fetchPlans()
    await this.loadCards()
    super.connectedCallback()
  }

  template() {
    return `
      ${this.cards.getState().join('')}
    `
  }

  async fetchPlans() {
    const plans = await apiPlan.fetchAllPlans()
    this.data.setState(plans.data, false)
  }

  async loadCards() {
    const cards = this.data.getState().map((planData) => {
      return `<p-plan-card plan-data="${JSON.stringify(planData)}"></p-plan-data>`
    })

    this.cards.setState(cards)
  }
}

export default window.customElements.define('p-plan-carousel', PlanCarousel)
