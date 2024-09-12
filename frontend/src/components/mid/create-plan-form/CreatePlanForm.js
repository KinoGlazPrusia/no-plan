import {
  PlainComponent,
  PlainState,
  PlainContext
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../utils/validators.js'
import * as apiPlan from '../../../services/api.plan.js'

/* COMPONENTS */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
import TextAreaInput from '../../base/text-area-input/TextAreaInput.js'
import DateInput from '../../base/date-input/DateInput.js'
import SelectInput from '../../base/select-input/SelectInput.js'
import FileInput from '../../base/file-input/FileInput.js'
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
import PlanTimeline from '../../base/plan-timeline/PlanTimeline.js'
import PlanStepModal from '../../base/plan-step-modal/PlanStepModal.js'

class CreatePlanForm extends PlainComponent {
  constructor() {
    super(
      'p-create-plan-form',
      `${MID_COMPONENTS_PATH}create-plan-form/CreatePlanForm.css`
    )

    this.isLoading = new PlainState(false, this)
    this.error = new PlainState(null, this)
    this.categories = new PlainState(this.fetchCategories(), this)
    this.editMode = new PlainState(null, this) // Si estamos en modo edición, guardamos el id del plan que vamos a editar

    this.userContext = new PlainContext('user', this, false)
  }

  template() {
    // [ ] Sustituir el validador de la imagen por uno nuevo
    if (this.isLoading.getState()) {
      return `
        <form class="create-plan-form" name="create-plan-form">
            <div class="overflow-wrapper is-loading">
              <p-loading-spinner
                class="spinner"
                success-message="${this.editMode.getState() ? 'Plan updated' : 'Plan created'}"
                success-detail="${this.editMode.getState() ? 'Your updated plan is published' : 'Your new plan is published'}">
              </p-loading-spinner>
            </div>
        </form>
      `
    }

    return `
        <p-toast></p-toast>
        <form class="create-plan-form" name="create-plan-form">
            <div class="overflow-wrapper">
                <!-- PLAN TITLE -->
                <p-text-input 
                  class="input" 
                  id="title"
                  name="title" 
                  label="Plan Title" 
                  type="text"
                  maxlength="30"
                  validator="${VALIDATORS.NAME}">
                </p-text-input>

                <!-- PLAN DESCRIPTION -->
                <p-text-area-input
                  class="input"
                  id="description"
                  name="description"
                  label="Description"
                  maxlength="100"
                  validator="${VALIDATORS.DESCRIPTION}">
                </p-text-area-input>

                <!-- PLAN DATE -->
                <p-date-input
                  class="input"
                  id="plan-date"
                  name="plan-date"
                  label="Plan Date"
                  validator="${VALIDATORS.DATE}">
                </p-date-input>

                <!-- MAX PARTICIPANTS -->
                <p-text-input 
                  class="input" 
                  id="max-participants"
                  name="max-participants" 
                  label="Max. Participants" 
                  type="number"
                  maxlength="3">
                </p-text-input>

                <!-- CATEGORIES -->
                <p-select-input
                  class="input" 
                  id="categories"
                  name="categories" 
                  label="Categories"
                  options='${JSON.stringify(this.categories.getState())}'
                  multiple>
                </p-select-input>

                <!-- PLAN IMAGE -->
                <p-file-input
                  class="plan-img"
                  id="plan-img"
                  name="plan-img"
                  label="Plan Image"
                  accept="image/*"
                  validator="${VALIDATORS.AVATAR_IMAGE_FILE}">
                </p-file-input>

                <!-- PLAN TIMELINE -->
                <p-plan-timeline></p-plan-timeline>

            </div>

            <div class="fade-bottom"></div>

            <div class="button-wrapper">
                <p-button class="add-step" type="secondary" icon="add">Add Step</p-button>
                <p-button class="submit" type="primary">${this.editMode.getState() ? 'Update' : 'Publish'}</p-button>
            </div>

        </form>
        <p-plan-step-modal></p-plan-step-modal>
        `
  }

  listeners() {
    if (!this.isLoading.getState()) {
      this.$('.add-step').onclick = () => this.openStepModal()
      this.$('.submit').onclick = () => this.handleSubmit()
    }
  }

  fillData(planId, data) {
    this.editMode.setState(planId, false)

    /* TITULO */
    this.$('#title').inputValue.setState(data.title)

    /* DESCRIPCIÓN */
    this.$('#description').inputValue.setState(data.description)

    /* FECHA */
    const date = new Date(data.datetime)
    const year = date.getFullYear()
    console.log('MES', (date.getMonth() + 1).toString().length)
    const month =
      (date.getMonth() + 1).toString().length > 1
        ? date.getMonth() + 1
        : '0' + (date.getMonth() + 1).toString()
    const day =
      date.getDate().toString().length > 1
        ? date.getDate()
        : '0' + date.getDate()

    this.$('#plan-date').inputValue.setState(`${year}-${month}-${day}`)

    /* PARTICIPANTES */
    this.$('#max-participants').inputValue.setState(data.max_participation)

    /* CATEGORIAS */
    data.categories.forEach((category) => {
      this.$('#categories').selectOption(category.id)
    })

    /* TIMELINE */
    this.clearTimeline()
    data.timeline.forEach((step) => {
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

  async fetchCategories() {
    const categories = await apiPlan.fetchAllCategories()
    const categoriesData = {}
    categories.data.forEach((category) => {
      categoriesData[category.id] = category.name
    })
    this.categories.setState(categoriesData)
  }

  openStepModal() {
    this.$('p-plan-step-modal').open()
  }

  addStep(step) {
    this.$('p-plan-timeline').addStep(step) // Esto se llama desde el modal
  }

  clearTimeline() {
    this.$('p-plan-timeline').clear()
  }

  /* HANDLERS */
  validateFields() {
    this.$('#title').validate()
    this.$('#description').validate()
    this.$('#plan-date').validate()

    const validity =
      this.$('#title').validity.getState().isValid &&
      this.$('#description').validity.getState().isValid &&
      this.$('#plan-date').validity.getState().isValid

    return validity
  }

  async handleSubmit() {
    // Validamos el formulario
    const isValid = this.validateFields()
    if (!isValid) return

    // Recogemos todos los datos para pasarlos a la función de la api
    const planData = {
      title: this.$('#title').inputValue.getState(),
      description: this.$('#description').inputValue.getState(),
      datetime: this.$('#plan-date').inputValue.getState(),
      max_participation: this.$('#max-participants').inputValue.getState(),
      categories: this.$('#categories').inputValue.getState(),
      timeline: this.$('p-plan-timeline').timeline.getState(),
      image: this.$('#plan-img').inputValue.getState()
    }

    this.isLoading.setState(true)

    try {
      let response = null

      if (!this.editMode.getState()) {
        response = await apiPlan.createPlan(planData)
      } else {
        response = await apiPlan.updatePlan(this.editMode.getState(), planData)
      }

      this.handleResponse(response)
    } catch (error) {
      throw error
    }
  }

  handleResponse(response) {
    console.log(response)
    if (response.status === 'success') {
      this.$('.spinner').success()
    } else if (response.error) {
      const toast = this.parentComponent.getToast()
      toast.showError(response.error.details)
      this.isLoading.setState(false)
    }
  }

  getToast() {
    return this.$('p-toast')
  }
}

export default window.customElements.define(
  'p-create-plan-form',
  CreatePlanForm
)
