import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* UTILS */
import * as helper from '../../../utils/helper.js'

class NotificationModal extends PlainComponent {
  constructor() {
    super(
      'p-notification-modal',
      `${BASE_COMPONENTS_PATH}notification-modal/NotificationModal.css`
    )

    this.notifications = new PlainState(
      JSON.parse(this.getAttribute('data')),
      this
    )
  }

  template() {
    const notifications = () => {
      if (!this.notifications.getState()) return null
      return this.notifications.getState().map((notification) => {
        const createdAt = helper.timeFromNow(notification.created_at)
        const notificationCategory = {
          1: 'message',
          2: 'participation_request',
          3: 'participation_accepted',
          4: 'participation_rejected',
          5: 'participation_cancelled',
          6: 'plan_rated',
          7: 'rated',
          8: 'followed',
          9: 'info'
        }

        if (notification.notification_type_id === 2) {
          return `
                <li class="notification">
                    <div class="notification-wrapper ${notificationCategory[notification.notification_type_id]}">
                        <span class="notification-message">${notification.content}</span>
                        <div class="notification-actions">
                            <button class="accept">Accept</button>
                            <button class="reject">Reject</button>
                        </div>
                    </div>
                    <span class="notification-time">${createdAt}</span>
                </li>
            `
        }

        return `
            <li class="notification">
                <div class="notification-wrapper ${notificationCategory[notification.notification_type_id]}">
                    <span class="notification-message">${notification.content}</span>
                    <button class="read-button">
                        <span class="material-symbols-outlined notification-actions">close</span>
                    </button>
                </div>
                <span class="notification-time">${createdAt}</span>
            </li>
      `
      })
    }

    return `
        <dialog class="modal">
            <div class="content">
                <ul class="notification-list">
                    ${notifications() && notifications().join('')}
                </ul>
            </div>
            <div class="button-wrapper">
                <p-button class="close" type="secondary">Close</p-button>
            </div>
        </dialog>
    `
  }

  listeners() {
    this.$('.close').onclick = () => this.close()
  }

  open() {
    this.$('.modal').showModal()
    this.animateEntry()
  }

  close() {
    this.$('.modal').close()
    this.reset()
  }

  animateEntry() {
    this.$('.modal').classList.add('entry')
  }
}

export default window.customElements.define(
  'p-notification-modal',
  NotificationModal
)
