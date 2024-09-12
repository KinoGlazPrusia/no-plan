import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
import CreatePlanForm from '../create-plan-form/CreatePlanForm.js'

class EditPlanModal extends PlainComponent {
  constructor() {
    super(
      'p-edit-plan-modal',
      `${MID_COMPONENTS_PATH}edit-plan-modal/EditPlanModal.css`
    )

    this.isLoading = new PlainState(false, this)
    this.error = new PlainState(null, this)
    this.planData = new PlainState(null, this)
  }

  template() {
    return `
        <dialog class="modal">
            <p-create-plan-form></p-create-plan-form>
            <div class="button-wrapper">
                <p-button class="close" type="secondary">Close</p-button>
            </div>
        </dialog>
    `
  }

  listeners() {
    this.$('.close').onclick = () => this.close()
  }

  setPlanData(planData) {
    this.planData.setState(planData, false)
    this.$('p-create-plan-form').editMode.setState(true)
    this.$('p-create-plan-form').fillData(planData.id, planData)
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

  reset() {
    this.$('.modal').classList.remove('entry')
  }
}

export default window.customElements.define('p-edit-plan-modal', EditPlanModal)
