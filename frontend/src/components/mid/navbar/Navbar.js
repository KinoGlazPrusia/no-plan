import { PlainComponent, PlainContext, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import NavbarButton from '../../base/navbar-button/NavbarButton.js'

/* SERVICES */
import * as apiNotification from '../../../services/api.notification.js'

class Navbar extends PlainComponent {
  constructor () {
    super('p-navbar', `${MID_COMPONENTS_PATH}navbar/Navbar.css`)

    this.navigationContext = new PlainContext('navigation', this)

    this.notifications = new PlainState(0, this)
  }

   async connectedCallback () {
    super.connectedCallback()
    await this.loadNotifications()
  }
   
  async loadNotifications () {
    const unreadNotifications = await apiNotification.getUnreadNotifications()
    this.notifications.setState(unreadNotifications.data.length)
  }

  // [ ] Implementar deshabilitación de botones dependiendo del estado de autenticación del usuario
  template () {
    const notificationChip = () => {
      const notificationNum = this.notifications.getState()
      return notificationNum > 0 
        ? `<span class="notification-chip pop">${notificationNum}</span>`
        : ''
    }
    return `
            <p-navbar-button icon="person" path="user/profile" ${this.navigationContext.getData('currentPage') === 'user/profile' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="event" path="user/plans" ${this.navigationContext.getData('currentPage') === 'user/plans' ? 'selected="true"' : ''}"></p-navbar-button>
            <p-navbar-button icon="add" path="plan/create" ${this.navigationContext.getData('currentPage') === 'plan/create' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="roofing" path="planner" ${this.navigationContext.getData('currentPage') === 'planner' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="search" path="finder" ${this.navigationContext.getData('currentPage') === 'finder' ? 'selected="true' : ''}"></p-navbar-button>
            ${notificationChip()}
        `
  }

  listeners () {
    if (this.$('.notification-chip')) {
      this.$('.notification-chip').onanimationend = () => {
        this.$('.notification-chip').classList.remove('pop')
      }
    }
  }
}

export default window.customElements.define('p-navbar', Navbar)
