import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../services/validator.js'
import { login as apiLogin } from '../../../services/api.auth.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
/* eslint-enable */

class LoginForm extends PlainComponent {
  constructor () {
    super('p-login-form', `${MID_COMPONENTS_PATH}login-form/LoginForm.css`)
  }

  template () {
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
    this.$('.submit').onclick = () => this.handleSubmit()
  }

  async handleSubmit () {
    const email = this.$('#email-input').inputValue.getState()
    const password = this.$('#password-input').inputValue.getState()

    if (!this.validateFields()) return
    
    // const response = await apiLogin(email, password)
    const response = await apiLogin(email, password)
    this.handleResponse(response)
  }

  handleResponse(response) {
    console.log(response)
  }

  validateFields() {
    this.$('#email-input').validate()

    const validity = this.$('#email-input').validity.getState().isValid // && otroInput.validity && etc

    return validity
  }
}

export default window.customElements.define('p-login-form', LoginForm)
