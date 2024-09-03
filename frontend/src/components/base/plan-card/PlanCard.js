import {
  PlainComponent,
  PlainContext,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH, APP_URL } from '../../../config/env.config.js'

/* COMPONENTS */
import FormFeedback from '../form-feedback/FormFeedback.js'
import PlanTimeline from '../plan-timeline/PlanTimeline.js'

/* SERVICES */
import * as apiParticipation from '../../../services/api.participation.js'

/* UTILS */
import * as helper from '../../../utils/helper.js'

class PlanCard extends PlainComponent {
  static get observedAttributes() {
    return ['applied']
  }

  constructor() {
    super('p-plan-card', `${BASE_COMPONENTS_PATH}plan-card/PlanCard.css`)

    this.userContext = new PlainContext('user', this, false)

    this.isLoading = new PlainState(true, this)
    this.error = new PlainState(null, this)
    /* this.planData = new PlainState(
      {
        id: 4,
        title: 'Tarde de hiking',
        description:
          'Haremos hiking por los senderos de la montaña de Montserrat.',
        datetime: '2026-05-07 00:00:00',
        location: null,
        max_participation: 7,
        status_id: 2,
        status: {
          id: 2,
          status: 'published'
        },
        created_by_id: '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5',
        created_by: null,
        plan_img_url: 'assets/images/plan/1725265542998.jpeg',
        timeline: [
          {
            id: 1,
            plan_id: 1,
            title: 'Encuentro',
            description: 'Quedamos delante de mi puerta',
            time: '11:15:00'
          },
          {
            id: 2,
            plan_id: 1,
            title: 'Nos vamos',
            description: 'Cojemos el autobús juntos',
            time: '11:15:00'
          },
          {
            id: 1,
            plan_id: 1,
            title: 'Empezamos',
            description: 'Subiremos por la primera ruta',
            time: '11:15:00'
          },
          {
            id: 1,
            plan_id: 1,
            title: 'Desayuno',
            description: 'Pararemos a desayunar (traed comida)',
            time: '11:15:00'
          },
          {
            id: 1,
            plan_id: 1,
            title: 'Despedida',
            description: 'Nos vamos a casa',
            time: '11:15:00'
          }
        ],
        categories: [
          {
            id: 21,
            name: 'Social Gatherings',
            description: 'General meetups, hangouts, and social events'
          },
          {
            id: 22,
            name: 'Outdoor Activities',
            description: 'Hiking, picnics, beach days, etc.'
          }
        ]
      },
      this
    ) */ // Cambiar esto a null y hacer fetch desde el componente padre (en este caso el carousel)
    console.log(JSON.parse(this.getAttribute('plan-data')))
    this.planData = new PlainState(JSON.parse(this.getAttribute('plan-data')), this)

    this.acceptedParticipations = new PlainState(null, this)
    this.rejectedParticipations = new PlainState(null, this)
    this.pendingParticipations = new PlainState(null, this)

    this.isApplied = new PlainState(false, this) // El usuario ha aplicado al plan
    this.isAccepted = new PlainState(false, this) // El usuario ha sido aceptado en el plan
    this.isRejected = new PlainState(false, this) // El usuario ha sido rechazado en el plan
    this.isFocused = new PlainState(true, this)
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue !== newValue) {
      this.render()
      this.loadPlanTimeline()
    }
  }

  async connectedCallback() {
    await this.loadPlanParticipations()
    this.checkUserParticipation()
    super.connectedCallback()
    this.loadPlanTimeline()
  }

  loadPlanData(planData) {
    this.planData.setState(planData)
  }

  async loadPlanParticipations() {
    await this.loadAcceptedParticipations()
    await this.loadRejectedParticipations()
    await this.loadPendingParticipations()
  }

  async loadAcceptedParticipations() {
    const accepted = await apiParticipation.getAcceptedPlanParticipations(
      this.planData.getState().id
    )

    console.log(accepted)

    this.acceptedParticipations.setState(accepted)
  }

  async loadRejectedParticipations() {
    const rejected = await apiParticipation.getRejectedPlanParticipations(
      this.planData.getState().id
    )

    this.rejectedParticipations.setState(rejected)
  }

  async loadPendingParticipations() {
    const pending = await apiParticipation.getPendingPlanParticipations(
      this.planData.getState().id
    )

    this.pendingParticipations.setState(pending)
  }

  checkUserParticipation() {
    const loggedUserId = this.userContext.getData('user').id
    const userApplied = this.checkIfUserAppliedToPlan(loggedUserId)
    const userAccepted = this.checkIfUserIsAcceptedInPlan(loggedUserId)
    const userRejected = this.checkIfUserIsRejectedInPlan(loggedUserId)

    if (userRejected) {
      this.isRejected.setState(true, false)
      return
    }

    if (userAccepted) {
      this.isAccepted.setState(true, false)
      return
    }

    if (userApplied) {
      this.toggleApplication()
      return
    }
  }

  checkIfUserIsRejectedInPlan(loggedUserId) {
    const isRejected = this.rejectedParticipations
      .getState()
      .find((user) => {
        return user.user_id === loggedUserId
      })

    return isRejected
  }

  checkIfUserIsAcceptedInPlan(loggedUserId) {
    const isAccepted = this.acceptedParticipations
      .getState()
      .find((user) => {
        return user.user_id === loggedUserId
      })

    return isAccepted
  }

  checkIfUserAppliedToPlan(loggedUserId) {
    const isApplied = this.pendingParticipations
      .getState()
      .find((user) => {
        return user.user_id === loggedUserId
      })

    return isApplied
  }

  async loadPlanTimeline() {
    this.planData.getState().timeline.forEach((step) => {
      const time = new Date(`01/01/2000 ${step.time}`)
      const hours =
        time.getHours().toString().length > 1
          ? time.getHours()
          : '0' + time.getHours()
      const minutes =
        time.getMinutes().toString().length > 1
          ? time.getMinutes()
          : '0' + time.getMinutes()
      step.time = `${hours}:${minutes}`
      this.addStep(step)
    })
  }

  template() {
    const userAge = helper.getAge(new Date(this.userContext.getData('user').birth_date))
    const planDate = new Date(this.planData.getState().datetime)
    const participations = this.acceptedParticipations
      .getState()
      .map((participation, index) => {
        return `
          <div class="participation-user-img" style="background-image: url(${APP_URL}${participation.userData.profile_img_url}); z-index: ${index * 10};">
              <span class="tooltiptext">${participation.userData.name} ${participation.userData.lastname}</span>
          </div>
      `
      })

    const getButton = () => {
      if (this.isRejected.getState()) {
        return `
          <button class="apply-button rejected pop-in" disabled>
            <span class="material-symbols-outlined">close</span>
          </button>
        `
      }

      if (this.isAccepted.getState()) {
        return `
          <button class="apply-button accepted pop-in" disabled>
            <span class="material-symbols-outlined">check_circle</span>
          </button>
        `
      }

      if (this.isApplied.getState()) {
        return `
          <button class="apply-button applied pop-in">
            <span class="material-symbols-outlined">mail</span>
          </button>
        `
      }

      return `
        <button class="apply-button unapplied pop-in">
          <span class="material-symbols-outlined">input_circle</span>
        </button>
      `
    }

    return `
        <div class="user-avatar">
          <div class="user-img" style="background-image: url(${APP_URL}${this.userContext.getData('user').profile_img_url})">
          </div>
          <div class="user-info">
            <span class="user-name">${this.userContext.getData('user').name}</span>
            <span class="user-age">${userAge} y/o</span>
          </div>
        </div>
        <div class="plan">
          <div class="plan-categories">Categorias
          </div>
          <div class="plan-img" style="background-image: url(${APP_URL}${this.planData.getState().plan_img_url})"></div>
          <div class="plan-info">
            <div class="plan-title">${this.planData.getState().title}</div>
            <div class="plan-description">${this.planData.getState().description}</div>
            <div class="plan-date">${planDate.getDay()} ${helper.getMonthName(planDate.getMonth())} ${planDate.getFullYear()}</div>
          </div>
        </div>
        <div class="plan-timeline-wrapper">
          <p-plan-timeline class="plan-timeline"></p-plan-timeline>
          <div class="fade-bottom"></div>
        </div>
        <div class="plan-participations">
          ${participations.join('')}
        </div>
        <div class="apply-button-wrapper">
          ${getButton()}
        </div>
    `
  }

  listeners() {
    this.$('.apply-button').onclick = () => this.toggleApplication()
  }

  toggleApplication() {
    this.isApplied.setState(!this.isApplied.getState(), false)
    this.toggleAttribute('applied', this.isApplied.getState())
  }

  addStep(step) {
    this.$('p-plan-timeline').addStep(step)
  }

  async applyToPlan(planId) {
    // const response = await apiParticipation.applyToPlan(planId)
    const response = {
      status: 'success'
    }

    if (response.status === 'success') {
      this.handleResponse(response)
    } else {
      this.handleError(response)
    }
  }

  handleResponse(response) {
    this.toggleApplication()
  }

  handleError(response) {
    console.log(response)
  }

  toggleFocus() {
    this.isFocused.setState(!this.isFocused.getState(), false)
    this.$('.apply-button').classList.toggle(
      'out-of-focus',
      !this.isFocused.getState()
    )
  }
}

export default window.customElements.define('p-plan-card', PlanCard)
