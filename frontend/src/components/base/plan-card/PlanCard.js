import {
  PlainComponent,
  PlainContext,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH, APP_URL } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'

/* SERVICES */
import * as validators from '../../../utils/validators.js'
import * as helper from '../../../utils/helper.js'

class PlanCard extends PlainComponent {
  constructor() {
    super('p-plan-card', `${BASE_COMPONENTS_PATH}plan-card/PlanCard.css`)

    this.userContext = new PlainContext('user', this, false)

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    this.data = new PlainState(
      {
        plan_img_url: 'assets/images/plan/1725265542998.jpeg'
      },
      this
    ) // Cambiar esto a null y hacer fetch desde el componente padre (en este caso el carousel)
  }

  template() {
    const userAge = helper.getAge(
      new Date(this.userContext.getData('user').birth_date)
    )
    return `
        <div class="user-avatar">
            <div class="user-img"
            style="background-image: url(${APP_URL}${this.userContext.getData('user').profile_img_url})">
            </div>
            <span class="user-name">${this.userContext.getData('user').name}</span>
            <span class="user-age">${userAge} y/o</span>
            <img src="${APP_URL}${this.data.getState().plan_img_url}">
    `
  }
}

export default window.customElements.define('p-plan-card', PlanCard)
