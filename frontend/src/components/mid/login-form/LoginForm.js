import { PlainComponent, PlainState, PlainContext } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH, MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../services/validators.js'
import * as apiAuth from '../../../services/api.auth.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
import LoadingSpinner from '../../base/loading-spinner/LoadingSpinner.js'
/* eslint-enable */

class LoginForm extends PlainComponent {
  constructor () {
    super('p-login-form', `${MID_COMPONENTS_PATH}login-form/LoginForm.css`)

    // [ ] Implementar isLoading
    this.isLoading = new PlainState(false, this)

    // [ ] Implementar isError
    this.isError = new PlainState(false, this)

    this.userContext = new PlainContext('user', this, false)
  }

  template () {
    if (this.isLoading.getState()) {
      return `
        <form class="login-form" name="login-form">
            <h1 class="greetings">Welcome!</h1>

            <p-loading-spinner
              class="spinner"
              success-message="Welcome"
              success-detail="You're logged in">
            </p-loading-spinner>

        </form>
      `
    }

    return `
        <form class="login-form" name="login-form">
            <h1 class="greetings">Welcome!</h1>

              <p-text-input 
                class="input" 
                id="email-input"
                name="email" 
                label="Email" 
                type="text"
                validator="${VALIDATORS.EMAIL}">
              </p-text-input>

              <p-text-input 
                class="input" 
                id="password-input"
                name="password" 
                label="Password" 
                type="password">
              </p-text-input>

              <p-button class="submit" type="primary">Log In</p-button>
        </form>
        `
  }

  listeners () {
    try {
      this.$('.submit').onclick = () => this.handleSubmit()
    } catch (error) {
      // [ ] Implementar manejo de errores
    }
  }

  async handleSubmit () {
    if (!this.validateFields()) return

    const email = this.$('#email-input').inputValue.getState()
    const password = this.$('#password-input').inputValue.getState()

    this.isLoading.setState(true)
    try {
      const response = await apiAuth.login(email, password)
      this.handleResponse(response)
    } catch (error) {
      // [ ] Implementar manejo de errores
      // Aqui se activa el isError
    }
  }

  handleResponse (response) {
    // [ ] Eliminar los console logs
    console.log(response)
    if (response.status === 'success') {
      this.$('.spinner').success()
      this.userContext.setData({ user: response.data[0] })
      this.redirectAfterLogin()
    }
    // [ ] Implementar manejo de errores cuando la response.status === 'error'
  }

  validateFields () {
    this.$('#email-input').validate()

    const validity = this.$('#email-input').validity.getState().isValid // && otroInput.validity && etc

    return validity
  }

  redirectAfterLogin () {
    setTimeout(() => {
      window.location.replace(PUBLIC_PATH + 'planner')
    }, 1500)
  }
}

export default window.customElements.define('p-login-form', LoginForm)
