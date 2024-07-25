import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

class PlannerPage extends PlainComponent {
  constructor () {
    super('p-planner-page', `${PAGES_PATH}planner/PlannerPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'planner' }, true)
  }

  template () {
    return `
            <h1>Planner Page</h1>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-planner-page', PlannerPage)
