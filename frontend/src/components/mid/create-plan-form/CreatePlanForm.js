import { PlainComponent, PlainState, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../services/validators.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
import DateInput from '../../base/date-input/DateInput.js'
import SelectInput from '../../base/select-input/SelectInput.js'
import FileInput from '../../base/file-input/FileInput.js'
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
/* eslint-enable */

class CreatePlanForm extends PlainComponent {
  constructor () {
    super('p-create-plan-form', `${MID_COMPONENTS_PATH}create-plan-form/CreatePlanForm.css`)

    this.isLoading = new PlainState(false, this)
    this.isError = new PlainState(false, this)

    this.userContext = new PlainContext('user', this, false)
  }

  template () {
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

                    <!-- CATEGORIES -->
                    <p-select-input
                    class="input" 
                    id="categories"
                    name="categories" 
                    label="Categories">
                    </p-select-input>

                    <!-- PLAN IMAGE -->
                    <p-file-input
                    class="plan-img"
                    id="plan-img"
                    name="plan-img"
                    label="Plan Image"
                    accept="image/*">
                    <p-file-input>

                </div>

                <div class="fade-bottom"></div>

                <div class="button-wrapper">
                    <p-button class="add-step" type="secondary" icon="add">Add Step</p-button>
                    <p-button class="submit" type="primary">Publish</p-button>
                </div>

            </form>
        `
  }
}

export default window.customElements.define('p-create-plan-form', CreatePlanForm)
