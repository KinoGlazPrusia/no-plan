import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../services/validators.js'
import { register as apiUserRegister } from '../../../services/api.user.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
import DateInput from '../../base/date-input/DateInput.js'
import PhoneInput from '../../base/phone-input/PhoneInput.js'
import SelectInput from '../../base/select-input/SelectInput.js'
import FileInput from '../../base/file-input/FileInput.js'
/* eslint-enable */

class SignUpForm extends PlainComponent {
  constructor () {
    super('p-signup-form', `${MID_COMPONENTS_PATH}signup-form/SignUpForm.css`)
  }

  template () {
    return `
            <form class="signup-form" name="signup-form">
                <h1 class="greetings">Register!</h1>

                <div class="overflow-wrapper">
                    <div class="input-wrapper current-tab-1">

                        <!-- TAB 1 -->
                        <div class="tab-1">

                            <!-- EMAIL -->
                            <p-text-input 
                            class="input" 
                            id="email-input"
                            name="email" 
                            label="Email" 
                            type="email"
                            maxlength="45"
                            validator="${VALIDATORS.EMAIL}">
                            </p-text-input>

                            <!-- PASSWORD -->
                            <p-text-input 
                            class="input" 
                            id="password-input"
                            name="password" 
                            label="Password" 
                            type="password"
                            maxlength="60"
                            validator="${VALIDATORS.PASSWORD}">
                            </p-text-input>

                            <!-- CONF PASSWORD -->
                            <p-text-input 
                            class="input" 
                            id="conf-password-input"
                            name="conf-password" 
                            label="Confirm Password" 
                            type="password"
                            maxlength="60">
                            </p-text-input>

                        </div>

                        <!-- TAB 2 -->

                        <div class="tab-2">

                            <!-- NAME -->
                            <p-text-input 
                            class="input" 
                            id="name"
                            name="name" 
                            label="Name" 
                            type="text"
                            maxlength="30"
                            validator="${VALIDATORS.NAME}">
                            </p-text-input>

                            <!-- LASTNAME -->
                            <p-text-input 
                            class="input" 
                            id="lastname"
                            name="lastname" 
                            label="Last Name" 
                            type="text"
                            maxlength="30"
                            validator="${VALIDATORS.NAME}">
                            </p-text-input>

                            <!-- BIRTHDAY -->
                            <p-date-input
                            class="birth-date"
                            id="birth-date"
                            name="birth-date"
                            label="Birth Date"
                            validator="${VALIDATORS.DATE}">
                            <p-date-input>

                        </div>

                        <!-- TAB 3 -->

                        <div class="tab-3">

                            <!-- PHONE NUMBER -->
                            <p-phone-input
                            class="input" 
                            id="phone"
                            name="phone" 
                            label="Phone Number"
                            validator="${VALIDATORS.PHONE_NUMBER}">
                            </p-phone-input>

                            <!-- GENRE -->
                            <p-select-input
                            class="input" 
                            id="genre"
                            name="genre" 
                            label="Genre">
                            </p-select-input>

                            <!-- AVATAR IMAGE -->
                            <p-file-input
                            class="avatar-img"
                            id="avatar-img"
                            name="avatar-img"
                            label="Avatar Image"
                            accept="image/*"
                            validator="${VALIDATORS.AVATAR_IMAGE_FILE}">
                            <p-file-input>

                        </div>

                    </div>

                    <div class="fade-left"></div>
                    <div class="fade-right"></div>

                    <!-- TAB SELECTOR BUTTONS -->
                    <div class="tab-selector-wrapper">
                        <div class="tab-btn selected" id="tab-1">1</div>
                        <div class="tab-btn" id="tab-2">2</div>
                        <div class="tab-btn" id="tab-3">3</div>
                        <div class="dashed-line"></div>
                    </div>

                    <p-button class="submit" type="primary" disabled>Sign Up</p-button>
                    
                </div>
            </form>
        `
  }

  listeners () {
    const tabButtons = [
      this.$('.tab-btn#tab-1'),
      this.$('.tab-btn#tab-2'),
      this.$('.tab-btn#tab-3')
    ]

    tabButtons.forEach(button => {
      button.onclick = () => this.changeTabOnClick(button, tabButtons)
    })

    this.$('.submit').onclick = () => this.handleSubmit()
  }

  changeTabOnValidation(targetTab) {
    const tabButtons = [
      this.$('.tab-btn#tab-1'),
      this.$('.tab-btn#tab-2'),
      this.$('.tab-btn#tab-3')
    ]

    tabButtons.forEach(button => {
      button.classList.remove('selected')
    })

    this.$(`.tab-btn#tab-${targetTab}`).classList.add('selected')

    const inputWrapper = this.$('.input-wrapper')
    inputWrapper.classList = 'input-wrapper'
    inputWrapper.classList.add(`current-tab-${targetTab}`)
  }

  changeTabOnClick (currentTabButton, tabButtons) {
    // Estilamos los botones de selección del tab
    tabButtons.forEach(button => {
      button.classList.remove('selected')
    })

    currentTabButton.classList.add('selected')

    // Movemos el input wrapper
    const inputWrapper = this.$('.input-wrapper')
    inputWrapper.classList = 'input-wrapper'
    inputWrapper.classList.add(`current-tab-${currentTabButton.textContent}`)

    // Si estamos en el último tab activamos el botón de submit
    const submitButton = this.$('.submit')
    if (currentTabButton.textContent === '3') {
      submitButton.enable() // Llamamos a funciones propias del componente
    } else if (!submitButton.classList.contains('disabled')) {
      submitButton.disable()
    }
  }

  async handleSubmit () {
    // Si el submit está deshabilitado salimos
    if (this.$('.submit').hasAttribute('disabled')) return

    // Validamos el formulario
    if (!this.validateFields()) return

    // Recogemos todos los datos para pasarlos a la función de la api
    const userData = {
      email: this.$('#email-input').inputValue.getState(),
      password: this.$('#password-input').inputValue.getState(),
      name: this.$('#name').inputValue.getState(),
      lastname: this.$('#lastname').inputValue.getState(),
      birth_date: this.$('#birth-date').inputValue.getState(),
      genre: this.$('#genre').inputValue.getState(),
      image: this.$('#avatar-img').inputValue.getState()
    }

    const response = await apiUserRegister(userData)
    this.handleResponse(response)
  }

  handleResponse (response) {
    console.table(response)
  }

  validateFields () {
    // Se validan todos con sus funciones propias menos la confirmación de password
    this.$('#email-input').validate()
    this.$('#password-input').validate()
    //this.$('#conf-password-input').validate()
    this.$('#name').validate()
    this.$('#lastname').validate()
    //this.$('#birth-date').validate()
    this.$('#phone').validate()
    //this.$('#genre').validate()
    this.$('#avatar-img').validate()

    if (
      !this.$('#email-input').validity.getState().isValid ||
      !this.$('#password-input').validity.getState().isValid
    ) {
      this.changeTabOnValidation(1)
    } 
    else if (
      !this.$('#name').validity.getState().isValid ||
      !this.$('#lastname').validity.getState().isValid ||
      !this.$('#birth-date').validity.getState().isValid
    ) {
      this.changeTabOnValidation(2)
    }
    else if (
      !this.$('#phone').validity.getState().isValid ||
      !this.$('#genre').validity.getState().isValid ||
      !this.$('#avatar-img').validity.getState().isValid
    ) {
      this.changeTabOnValidation(3)
    }

    const validity = 
      this.$('#email-input').validity.getState().isValid &&
      this.$('#password-input').validity.getState().isValid &&
      this.$('#name').validity.getState().isValid &&
      this.$('#lastname').validity.getState().isValid &&
      this.$('#phone').validity.getState().isValid &&
      this.$('#avatar-img').validity.getState().isValid 

    return validity
  }
}

export default window.customElements.define('p-signup-form', SignUpForm)
