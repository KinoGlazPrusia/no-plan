import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../services/validator.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
/* eslint-enable */

class SignUpForm extends PlainComponent {
    constructor() {
        super('p-signup-form', `${MID_COMPONENTS_PATH}signup-form/SignUpForm.css`)
    }

    template() {
        return `
            <form class="signup-form" name="signup-form">
                <div class="input-wrapper">

                    <!-- TAB 1 -->

                    <!-- EMAIL -->
                    <p-text-input 
                    class="input" 
                    id="email-input"
                    name="email" 
                    label="Email" 
                    type="email"
                    validator="${VALIDATORS.EMAIL}">
                    </p-text-input>

                    <!-- PASSWORD -->
                    <p-text-input 
                    class="input" 
                    id="password-input"
                    name="password" 
                    label="Password" 
                    type="password">
                    </p-text-input>

                    <!-- CONF PASSWORD -->
                    <p-text-input 
                    class="input" 
                    id="conf-password-input"
                    name="conf-password" 
                    label="Confirm Password" 
                    type="password">
                    </p-text-input>

                    <!-- TAB 2 -->

                    <!-- NAME -->
                    <p-text-input 
                    class="input" 
                    id="name"
                    name="name" 
                    label="Name" 
                    type="text">
                    </p-text-input>

                    <!-- LASTNAME -->
                    <p-text-input 
                    class="input" 
                    id="lastname"
                    name="lastname" 
                    label="Last Name" 
                    type="text">
                    </p-text-input>

                </div>
            </form>
        `
    }
}

export default window.customElements.define('p-signup-form', SignUpForm)