import { PlainComponent, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* eslint-disable */
import NavbarButton from '../../base/navbar-button/NavbarButton.js'
/* eslint-enable */

class Navbar extends PlainComponent {
  constructor () {
    super('p-navbar', `${MID_COMPONENTS_PATH}navbar/Navbar.css`)

    this.navigationContext = new PlainContext('navigation', this)
  }

  template () {
    return `
            <p-navbar-button icon="person" path="user/profile" ${this.navigationContext.getData('currentPage') === 'user/profile' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="event" path="user/plans" ${this.navigationContext.getData('currentPage') === 'user/plans' ? 'selected="true"' : ''}"></p-navbar-button>
            <p-navbar-button icon="add" path="plan/create" ${this.navigationContext.getData('currentPage') === 'plan/create' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="roofing" path="planner" ${this.navigationContext.getData('currentPage') === 'planner' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="search" path="finder" ${this.navigationContext.getData('currentPage') === 'finder' ? 'selected="true' : ''}"></p-navbar-button>
            <!-- <p-navbar-button icon="power_settings_new" path="logout"}"></p-navbar-button> -->
        `
  }
}

export default window.customElements.define('p-navbar', Navbar)
