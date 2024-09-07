import {
  PlainComponent,
  PlainContext,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import NavbarButton from '../../base/navbar-button/NavbarButton.js'
import NotificationModal from '../../base/notification-modal/NotificationModal.js'

/* SERVICES */
import * as apiNotification from '../../../services/api.notification.js'

class Navbar extends PlainComponent {
  constructor() {
    super('p-navbar', `${MID_COMPONENTS_PATH}navbar/Navbar.css`)

    this.navigationContext = new PlainContext('navigation', this)

    this.notifications = new PlainState(null, this)
  }

  async connectedCallback() {
    await this.loadNotifications()
    super.connectedCallback()
  }

  async loadNotifications(reRender = true) {
    const unreadNotifications = await apiNotification.getUnreadNotifications()
    this.notifications.setState(unreadNotifications.data, reRender)

    // Mantenemos la actualización de las notificaciones en un bucle infinito
    /* setTimeout(async () => {
      await this.loadNotifications(false)
    }, 1000) */
  }

  // [ ] Implementar deshabilitación de botones dependiendo del estado de autenticación del usuario
  template() {
    this.wrapper.classList.add('hidden')
    const notificationChip = () => {
      return this.notifications.getState().length > 0
        ? `<span class="notification-chip pop">${this.notifications.getState().length}</span>`
        : ''
    }

    const unfoldMenuButton = () => {
      return `
          <button class="unfold-menu ${!this.wrapper.classList.contains('hidden') ? 'hidden' : ''}" type="button">
            <span class="material-symbols-outlined">menu</span>
          </button>
        `
    }

    return `
            ${unfoldMenuButton()}
            <p-navbar-button icon="person" path="user/profile" ${this.navigationContext.getData('currentPage') === 'user/profile' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="event" path="user/plans" ${this.navigationContext.getData('currentPage') === 'user/plans' ? 'selected="true"' : ''}"></p-navbar-button>
            <p-navbar-button icon="add" path="plan/create" ${this.navigationContext.getData('currentPage') === 'plan/create' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="roofing" path="planner" ${this.navigationContext.getData('currentPage') === 'planner' ? 'selected="true' : ''}"></p-navbar-button>
            <p-navbar-button icon="search" path="finder" ${this.navigationContext.getData('currentPage') === 'finder' ? 'selected="true' : ''}"></p-navbar-button>
            ${notificationChip()}
            <p-notification-modal class="notification-modal" data='${JSON.stringify(this.notifications.getState())}'></p-notification-modal>
        `
  }

  listeners() {
    if (this.$('.notification-chip')) {
      this.$('.notification-chip').onanimationend = () => {
        this.$('.notification-chip').classList.remove('pop')
      }

      this.$('.notification-chip').onclick = () => {
        this.openNotificationModal()
      }
    }

    this.$('.unfold-menu').onclick = () => {
      this.toogleMenu()
    }
  }

  openNotificationModal() {
    this.$('p-notification-modal').open()
  }

  toogleMenu() {
    this.wrapper.classList.toggle('hidden')
    this.$('.unfold-menu').classList.toggle('hidden')

    setTimeout(() => {
      this.wrapper.classList.toggle('hidden')
      this.$('.unfold-menu').classList.toggle('hidden')
    }, 3000)
  }

  // [ ] Habría que revisar las responsabilidades de este componente y del notificationModal y rehacer la estructura (de momento no hay tiempo)
  notificationRead(notificationId) {
    let newNotifications = this.notifications
      .getState()
      .filter((notification) => {
        return notification.id != notificationId
      })

    this.notifications.setState(newNotifications, false)

    // [ ] Esto es un parche para modificar los estilos. Debería trasladarse esto a un componente externo y re-renderizarlo cuando se cambie el estado.
    if (this.notifications.getState().length === 0) {
      this.$('.notification-chip').style.display = 'none'
    }

    this.$('.notification-chip').textContent =
      this.notifications.getState().length
  }
}

export default window.customElements.define('p-navbar', Navbar)
