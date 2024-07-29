import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { MID_COMPONENTS_PATH } from '../../../config/env.config.js'

/* SERVICES */
import { VALIDATORS } from '../../../services/validator.js'

/* COMPONENTS */
/* eslint-disable */
import Button from '../../base/button/Button.js'
import TextInput from '../../base/text-input/TextInput.js'
import DateInput from '../../base/date-input/DateInput.js'
/* eslint-enable */

class SignUpForm extends PlainComponent {
    constructor() {
        super('p-signup-form', `${MID_COMPONENTS_PATH}signup-form/SignUpForm.css`)
    }

    template() {
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

                        </div>

                        <!-- TAB 2 -->

                        <div class="tab-2">

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

                            <!-- BIRTHDAY -->
                            <p-date-input
                            class="birth-date"
                            id="birth-date"
                            name="birth-date"
                            label="Birth Date">
                            <p-date-input>

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

    listeners() {
        const tabButtons = [
            this.$('.tab-btn#tab-1'),
            this.$('.tab-btn#tab-2'),
            this.$('.tab-btn#tab-3')
        ]
        
        tabButtons.forEach(button => {
            button.onclick = () => this.changeTab(button, tabButtons)
        })
    }

    changeTab(currentTabButton, tabButtons) {
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

    handleSubmit() {

    }

    handleResponse() {

    }

    validateFields() {

    }
}

export default window.customElements.define('p-signup-form', SignUpForm)