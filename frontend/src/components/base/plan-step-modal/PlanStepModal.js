import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import TextInput from '../text-input/TextInput.js'
import TextAreaInput from '../text-area-input/TextAreaInput.js'
import TimeInput from '../time-input/TimeInput.js'

class PlanStepModal extends PlainComponent {
  constructor() {
    super(
      'p-plan-step-modal',
      `${BASE_COMPONENTS_PATH}plan-step-modal/PlanStepModal.css`
    )
  }

  // [ ] Añadir validadores para los campos
  template() {
    return `
        <dialog class="modal">
            <span class="modal-header">Add Step</span>
            <div class="modal-body">

                <!-- TITLE -->
                <p-text-input 
                    class="input" 
                    id="title" 
                    name="title" 
                    label="Title" 
                    type="text" 
                    maxlength="30">
                </p-text-input>

                <!-- DESCRIPTION -->
                <p-text-area-input
                    class="input"
                    id="description"
                    name="description"
                    label="Description"
                    maxlength="50">
                </p-text-area-input>   

                <!-- TIME -->
                <p-time-input 
                  class="input" 
                  id="time" 
                  name="time" 
                  label="Time">
                </p-date-input>

            </div>
            <div class="button-wrapper">
                <p-button class="cancel-step" type="secondary">Close</p-button>
                <p-button class="submit" type="primary">Add</p-button>
            </div>
        </dialog>
    `
  }

  listeners() {
    this.$('.submit').onclick = () => this.addStep()
    this.$('.cancel-step').onclick = () => this.close()
  }

  open() {
    this.$('.modal').showModal()
    this.animateEntry()
  }

  close() {
    this.$('.modal').close()
    this.reset()
  }

  addStep() {
    // [ ] Validar todos los campos
    if (!this.validateFields()) return

    this.parentComponent.addStep({
      title: this.$('#title').inputValue.getState(),
      description: this.$('#description').inputValue.getState(),
      time: this.$('#time').inputValue.getState()
    })

    this.close()
    const toast = this.parentComponent.getToast()
    toast.showSuccess('Added new step to the plan.')
  }

  validateFields() {
    // [ ] Validar todos los campos
    return true
  }

  reset() {
    this.$('#title').inputValue.setState('')
    this.$('#description').inputValue.setState('')
    this.$('#time').inputValue.setState('')
  }

  animateEntry() {
    this.$('.modal').classList.add('entry')
  }
}

export default window.customElements.define('p-plan-step-modal', PlanStepModal)
