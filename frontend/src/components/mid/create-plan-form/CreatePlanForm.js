import {
  PlainComponent,
  PlainState,
  PlainContext
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../utils/validators.js'

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
    this.isError = new PlainState(false, this)
    this.categories = new PlainState([], this)

    this.userContext = new PlainContext('user', this, false)

    // [ ] Quizás se podría sustituir el select multiple por un div lleno de check chips como en un filtro
  }

  template() {
    // [ ] Sustituir esto por una llamada a la API para hacer un fetch de todas las categorías
    // [ ] En el select input, pasarle el objeto de categría completo y añadir el id al valor del select para poderlo recoger
    const testCategories = [
      'Social Gatherings',
      'Outdoor Activities',
      'Sports & Fitness',
      'Cultural Events',
      'Food & Drinks',
      'Music & Concerts',
      'Art & Exhibitions',
      'Educational & Workshops',
      'Nightlife & Parties',
      'Travel & Excursions',
      'Wellness & Relaxation',
      'Professional Networking',
      'Volunteering & Charity',
      'Technology & Gaming',
      'Family-Friendly Activities',
      'Shopping & Markets',
      'Movies & Theater',
      'Book Clubs & Literary Events',
      'Pets & Animal Lovers',
      'Hobby & Craft Sessions'
    ]

    // [ ] Sustituir el validador de la imagen por uno nuevo
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

                    <!-- CATEGORIES -->
                    <p-select-input
                      class="input" 
                      id="categories"
                      name="categories" 
                      label="Categories"
                      options='${JSON.stringify(testCategories)}'
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
    this.$('.add-step').onclick = () => this.openStepModal()
  }

  openStepModal() {
    this.$('p-plan-step-modal').open()
  }

  addStep(step) {
    this.$('p-plan-timeline').addStep(step) // Esto se llama desde el modal
  }
}

export default window.customElements.define(
  'p-create-plan-form',
  CreatePlanForm
)
