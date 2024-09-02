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
import * as validators from '../../../utils/validators.js'
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
    this.planData = new PlainState(
      {
        id: 1,
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
            title: 'Quedada',
            description: 'Quedamos delante de mi puerta',
            time: '11:15:00'
          },
          {
            id: 2,
            plan_id: 1,
            title: 'Bar',
            description: 'Nos vamos a un bar juntos',
            time: '11:15:00'
          },
          {
            id: 1,
            plan_id: 1,
            title: 'Quedada',
            description: 'Quedamos delante de mi puerta',
            time: '11:15:00'
          },
          {
            id: 1,
            plan_id: 1,
            title: 'Quedada',
            description: 'Quedamos delante de mi puerta',
            time: '11:15:00'
          },
          {
            id: 1,
            plan_id: 1,
            title: 'Quedada',
            description: 'Quedamos delante de mi puerta',
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
    ) // Cambiar esto a null y hacer fetch desde el componente padre (en este caso el carousel)
    this.planParticipations = new PlainState(
      [
        {
          plan_id: 1,
          user_id: '77ce78e7-69ae-4b3d-9b6f-fc88a11defd5',
          userData: {
            email: 'test@example.us',
            name: 'Jon',
            lastname: 'Doe',
            profile_img_url: 'assets/images/avatar/1723051155493.jpg'
          },
          status_id: 2,
          status: 'accepted'
        },
        {
          plan_id: 1,
          user_id: '481fbb71-94e3-44b0-b668-37467499b869s',
          userData: {
            email: 'test@example.us',
            name: 'Jon',
            lastname: 'Doe',
            profile_img_url: 'assets/images/avatar/1723051155492.jpg'
          },
          status_id: 2,
          status: 'accepted'
        }
      ],
      this
    )

    this.isApplied = new PlainState(false, this)
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue !== newValue) {
      this.render()
      this.loadPlanParticipations()
      this.loadPlanTimeline()
    }
  }

  connectedCallback() {
    super.connectedCallback()

    this.loadPlanData()
    this.loadPlanParticipations()
    this.checkIfUserAlreadyAppliedToPlan()
    this.loadPlanTimeline()
  }

  async loadPlanData() {}

  async loadPlanParticipations() {}

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

  checkIfUserAlreadyAppliedToPlan() {
    const isApplied = this.planParticipations.getState().find((user) => {
      return user.user_id === this.userContext.getData('user').id
    })

    isApplied && this.isApplied.setState(true)
  }

  template() {
    const userAge = helper.getAge(
      new Date(this.userContext.getData('user').birth_date)
    )
    const planDate = new Date(this.planData.getState().datetime)
    const participations = this.planParticipations
      .getState()
      .map((participation, index) => {
        return `
          <div class="participation-user-img" style="background-image: url(${APP_URL}${participation.userData.profile_img_url}); z-index: ${index * 10};">
              <span class="tooltiptext">${participation.userData.name} ${participation.userData.lastname}</span>
          </div>
      `
      })

    const applyButton = this.isApplied.getState()
      ? `
        <button class="apply-button unapplied pop-in">
          <span class="material-symbols-outlined">input_circle</span>
        </button>
      `
      : `
        <button class="apply-button applied pop-in">
          <span class="material-symbols-outlined">check_circle</span>
        </button>
      `

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
          ${applyButton}
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
}

export default window.customElements.define('p-plan-card', PlanCard)
