import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

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
        <form name="login-form">
            <p-text-input name="email" label="Email" type="email"></p-text-input>
            <p-text-input name="password" label="Password" type="password"></p-text-input>
            <p-button type="primary">Log In</p-button>
        </form>
        `
  }
}

export default window.customElements.define('p-login-form', LoginForm)
