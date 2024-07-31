import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import CreatePlanForm from '../../mid/create-plan-form/CreatePlanForm.js'
/* eslint-enable */

class CreatePlanPage extends PlainComponent {
  constructor () {
    super('p-create-plan-page', `${PAGES_PATH}plan/CreatePlanPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'plan/create' })
  }

  template () {
    return `
            <p-create-plan-form class="create-plan-form"></p-create-plan-form>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-create-plan-page', CreatePlanPage)
