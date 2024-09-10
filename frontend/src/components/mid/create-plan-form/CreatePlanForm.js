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

    // this.fillData(1) // [ ] Esta función será llamada para poner el formulario en modo edición

    // [ ] Quizás se podría sustituir el select multiple por un div lleno de check chips como en un filtro
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
                  maxlength="100">
                </p-text-area-input>

                <!-- PLAN DATE -->
                <p-date-input
                  class="input"
                  id="plan-date"
                  name="plan-date"
                  label="Plan Date">
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
                <p-button class="submit" type="primary">Publish</p-button>
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

  async fillData(planId) {
    const plan = await apiPlan.fetchPlanData(planId)
    const data = plan.data[0]

    this.$('#title').inputValue.setState(data.title)
    this.$('#description').inputValue.setState(data.description)

    const date = new Date(data.datetime)
    const year = date.getFullYear()
    const month =
      date.getMonth().toString().length > 1
        ? date.getMonth()
        : '0' + date.getMonth()
    const day =
      date.getDay().toString().length > 1 ? date.getDay() : '0' + date.getDay()

    this.$('#plan-date').inputValue.setState(`${year}-${month}-${day}`)
    this.$('#max-participants').inputValue.setState(data.max_participation)

    //this.$('#categories').inputValue.setState(data.categories) // [ ] Implementar la carga de categorias
    data.categories.forEach((category) => {
      this.$('#categories').selectOption(category.id)
    })

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

    this.editMode.setState(planId, false)
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

  /* HANDLERS */
  validateFields() {
    // [ ] Implementar las validaciones pertinentes para el formulario completo
    return true
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
}

export default window.customElements.define(
  'p-create-plan-form',
  CreatePlanForm
)
