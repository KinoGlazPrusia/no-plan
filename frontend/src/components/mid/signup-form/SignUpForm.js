import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS, validateEmailDontExists, validatePasswordConfirmation } from '../../../services/validators.js'
import { register as apiUserRegister } from '../../../services/api.user.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
import DateInput from '../../base/date-input/DateInput.js'
import PhoneInput from '../../base/phone-input/PhoneInput.js'
import SelectInput from '../../base/select-input/SelectInput.js'
import FileInput from '../../base/file-input/FileInput.js'
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
import { emailExists } from '../../../services/api.auth.js'
/* eslint-enable */

class SignUpForm extends PlainComponent {
  constructor () {
    super('p-signup-form', `${MID_COMPONENTS_PATH}signup-form/SignUpForm.css`)

    this.isLoading = new PlainState(false, this)
    this.isError = new PlainState(false, this)
  }

  // [x] Mejorar la implementación isLoading
  // [ ] Implementar isError
  template () {
    if (this.isLoading.getState()) {
      return `
        <form class="signup-form" name="signup-form">
            <h1 class="greetings">Register!</h1>
            <div class="overflow-wrapper">
              <p-loading-spinner
                class="spinner"
                success-message="You've been registered"
                success-detail="Validate your account in your email">
              </p-loading-spinner>
            </div>
        </form>
      `
    }

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
                            no-calendar
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

                    <p-button class="submit" type="primary" disabled="true">Sign Up</p-button>
                </div>
            </form>
        `
  }

  listeners () {
    try {
      const tabButtons = [
        this.$('.tab-btn#tab-1'),
        this.$('.tab-btn#tab-2'),
        this.$('.tab-btn#tab-3')
      ]

      tabButtons.forEach(button => {
        button.onclick = () => this.changeTabOnClick(button, tabButtons)
      })

      this.$('.submit').onclick = () => this.handleSubmit()
    } catch (error) {
      // console.log(error)
      // [ ] Revisar el manejo de esta excepción cuando se invocan los listeners pero no se han cargado los elementos
    }
  }

  changeTabOnValidation (targetTab) {
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
    this.toogleSubmitButton(currentTabButton.textContent)
  }

  toogleSubmitButton (currentTab) {
    console.log(currentTab)
    // Si estamos en el último tab activamos el botón de submit
    const submitButton = this.$('.submit')
    if (currentTab === '3' && submitButton.getAttribute('disabled')) {
      submitButton.enable() // Llamamos a funciones propias del componente
    } else if (!submitButton.classList.contains('disabled')) {
      submitButton.disable()
    }
  }

  async handleSubmit () {
    // Si el submit está deshabilitado salimos
    if (this.$('.submit').getAttribute('disabled') === true) return

    // Validamos el formulario
    const isValid = await this.validateFields()
    if (!isValid) return

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

    this.isLoading.setState(true)
    try {
      const response = await apiUserRegister(userData)
      this.handleResponse(response)
    } catch (error) {
      // [ ] Implementar manejo de errores cuando no hay conexión a internet
      /* this.isLoading.setState(true)
      this.$('.spinner').error() */
    }
  }

  handleResponse (response) {
    // [ ] Eliminar los console logs
    console.log(response)
    if (response.status === 'success') {
      this.$('.spinner').success()
    }
    // [ ] Implementar manejo de errores cuando la response.status === 'error'
  }

  async validateFields () {
    // Se validan todos con sus funciones propias menos la confirmación de password
    this.$('#email-input').validate()
    this.$('#password-input').validate()
    // this.$('#conf-password-input').validate()
    this.$('#name').validate()
    this.$('#lastname').validate()
    // this.$('#birth-date').validate()
    this.$('#phone').validate()
    // this.$('#genre').validate()
    this.$('#avatar-img').validate()

    // Validamos si el email existe
    // [x] Implementar el checkeo de si el email existe al validar el input de email
    const emailExistsValidityMessage = await validateEmailDontExists(this.$('#email-input').inputValue.getState())
    if (emailExistsValidityMessage.length > 0) {
      this.$('#email-input').validity.setState({
        isValid: false,
        messages: this.$('#email-input').validity.getPrevState().messages.concat(emailExistsValidityMessage)
      }, false)
      this.$('#email-input').updateFeedback()
    }

    // Validamos la confirmación de password
    // [x] Integrar validación de confirmación de password
    const passwordConfirmation = this.$('#conf-password-input').inputValue.getState()
    const password = this.$('#password-input').inputValue.getState()
    const passwordConfirmationValidityMessage = validatePasswordConfirmation(password, passwordConfirmation)
    if (passwordConfirmationValidityMessage.length > 0) {
      this.$('#conf-password-input').validity.setState({
        isValid: false,
        messages: this.$('#conf-password-input').validity.getPrevState().messages.concat(passwordConfirmationValidityMessage)
      }, false)
      this.$('#conf-password-input').updateFeedback()
    } else {
      this.$('#conf-password-input').validity.setState({
        isValid: true,
        messages: []
      }, false)
      this.$('#conf-password-input').updateFeedback()
    }

    // Cambiamos el tab de manera automática según en donde esté el error
    if (
      !this.$('#email-input').validity.getState().isValid ||
      !this.$('#password-input').validity.getState().isValid ||
      !this.$('#conf-password-input').validity.getState().isValid
    ) {
      this.changeTabOnValidation(1)
      this.toogleSubmitButton(1)
    } else if (
      !this.$('#name').validity.getState().isValid ||
      !this.$('#lastname').validity.getState().isValid ||
      !this.$('#birth-date').validity.getState().isValid
    ) {
      this.changeTabOnValidation(2)
      this.toogleSubmitButton(2)
    } else if (
      !this.$('#phone').validity.getState().isValid ||
      !this.$('#genre').validity.getState().isValid ||
      !this.$('#avatar-img').validity.getState().isValid
    ) {
      this.changeTabOnValidation(3)
    }

    // Guardamos la validez del formulario en una variable para devolverla
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
