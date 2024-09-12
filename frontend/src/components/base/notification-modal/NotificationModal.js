import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import * as apiParticipation from '../../../services/api.participation.js'
import * as apiNotification from '../../../services/api.notification.js'

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

    const notifications = () => {
      if (!this.notifications.getState()) return null
      return this.notifications.getState().map((notification) => {
        const createdAt = helper.timeFromNow(notification.created_at)

        if (notification.notification_type_id === 2) {
          const userId = notification.user_id

          const participantId = notification.content
            .match(/{participantId=([a-f0-9\-]+)}/)[0]
            .split('=')[1]
            .replace('}', '')

          const planId = notification.content
            .match(/{planId=\d*}/)[0]
            .split('=')[1]
            .replace('}', '')

          return `
                <li class="notification ${notification.read ? 'read' : ''}">
                    <div class="notification-wrapper ${notificationCategory[notification.notification_type_id]}">
                      <div class="content-wrapper">
                          <span class="notification-title">
                            ${notificationCategory[
                              notification.notification_type_id
                            ].replace('_', ' ')}
                          </span>
                        <span class="notification-message">${notification.content.replace(/{planId=\d*}/, '').replace(/{participantId=([a-f0-9\-]+)}/, '')}</span>
                      </div>
                      <div class="notification-actions request">
                        <button class="accept" id="${notification.id}" plan-id="${planId}" user-id="${userId}" participant-id="${participantId}">
                            <span class="material-symbols-outlined">thumb_up</span>
                        </button>
                        <button class="reject" id="${notification.id}" plan-id="${planId}" user-id="${userId}" participant-id="${participantId}">
                            <span class="material-symbols-outlined">thumb_down</span>
                        </button>
                      </div>
                    </div>
                    <span class="notification-time">${createdAt}</span>
                </li>
            `
        }

        return `
            <li class="notification">
                <div class="notification-wrapper ${notificationCategory[notification.notification_type_id]}">
                    <div class="content-wrapper">
                      <span class="notification-title">
                        ${notificationCategory[
                          notification.notification_type_id
                        ].replace('_', ' ')}
                      </span>
                      <span class="notification-message">${notification.content}</span>
                    </div>
                    <button class="read-button" id="${notification.id}">
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
                    <li class="notification no-more read">
                      <div class="notification-wrapper ${notificationCategory[1]} no-more">
                          <span class="notification-message">No more notifications...</span>
                      </div>
                  </li>
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

    if (this.$('.accept')) {
      const button = this.$('.accept')
      button.onclick = (e) => {
        this.animateClick(button)
        this.acceptParticipation(
          button.id,
          button.getAttribute('user-id'),
          button.getAttribute('participant-id'),
          button.getAttribute('plan-id')
        )
      }
    }

    if (this.$('.reject')) {
      const button = this.$('.reject')
      button.onclick = (e) => {
        this.animateClick(button)
        this.rejectParticipation(
          button.id,
          button.getAttribute('user-id'),
          button.getAttribute('participant-id'),
          button.getAttribute('plan-id')
        )
      }
    }

    this.wrapper.querySelectorAll('.read-button').forEach((button) => {
      button.onclick = async () => {
        this.animateClick(button)
        await this.readNotification(button.id)
      }
    })
  }

  animateClick(button) {
    button.classList.add('clicked')
    button.onanimationend = () => button.classList.remove('clicked')
  }

  open() {
    this.$('.modal').showModal()
    this.animateEntry()
  }

  close() {
    this.$('.modal').close()
  }

  animateEntry() {
    this.$('.modal').classList.add('entry')
  }

  // [ ] Terminar de implementar la función de aceptar o rechazar un participante
  async acceptParticipation(notificationId, userId, participantId, planId) {
    try {
      const response = await apiParticipation.acceptParticipation(
        userId,
        participantId,
        planId
      )

      if (response.status === 'success') {
        await this.readNotification(notificationId)
      }
    } catch (error) {
      throw error
    }
  }

  async rejectParticipation(notificationId, userId, participantId, planId) {
    try {
      const response = await apiParticipation.rejectParticipation(
        userId,
        participantId,
        planId
      )

      if (response.status === 'success') {
        await this.readNotification(notificationId)
      }
    } catch (error) {
      throw error
    }
  }

  async readNotification(notificationId) {
    try {
      const response =
        await apiNotification.setNotificationAsRead(notificationId)
      if (response.status === 'success') {
        this.parentComponent.notificationRead(notificationId)
        this.$(
          `.notification:has(button[id="${notificationId}"])`
        ).classList.add('read')
      }

      if (this.parentComponent.notifications.getState().length === 0) {
        this.$('.no-more').classList.remove('read')
      }
    } catch (error) {
      throw error
    }
  }
}

export default window.customElements.define(
  'p-notification-modal',
  NotificationModal
)
