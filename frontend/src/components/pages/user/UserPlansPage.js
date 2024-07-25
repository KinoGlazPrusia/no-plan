import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PAGES_PATH } from '../../../config/env.config.js'

class UserPlansPage extends PlainComponent {
  constructor () {
    super('p-user-plans-page', `${PAGES_PATH}user/UserPlansPage.css`)

    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'user/plans' })
  }

  template () {
    return `
            <h1>User Plans Page</h1>
            <p-navbar></p-navbar>
        `
  }
}

export default window.customElements.define('p-user-plans-page', UserPlansPage)
