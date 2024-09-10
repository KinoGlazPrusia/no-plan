import { PlainComponent, PlainState } from "../../../../node_modules/plain-reactive/src/index.js";
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* CONSTANTS */
import {toastTypes} from '../../../constants/toastTypes.js'

class Toast extends PlainComponent {
    constructor() {
        super('p-toast', `${BASE_COMPONENTS_PATH}toast/Toast.css`)

        this.message = new PlainState(null, this)
        this.type = new PlainState(null, this)
        this.ttl = new PlainState(3000, this) //ms

        this.disable()
    }

    showError(error) {
        this.message.setState(error, false)
        this.setType(toastTypes.ERROR)
        this.enable()
    }

    showMessage(message) {
        this.message.setState(message, false)
        this.setType(toastTypes.MESSAGE)
        this.enable()
    }

    showInfo() {
        this.message.setState(info, false)
        this.setType(toastTypes.INFO)
        this.enable()
    }

    showSuccess() {
        this.message.setState(success, false)
        this.setType(toastTypes.SUCCESS)
        this.enable()
    }

    setType(type) {
        this.wrapper.classList = 'p-toast-wrapper'
        this.wrapper.classList.add(type)
        this.type.setState(type)
    } 

    enable() {
        this.wrapper.classList.remove('disabled')
        this.wrapper.classList.add('enabled')
        this.wrapper.classList.add('entry')

        setTimeout(() => {
            this.disable()
        }, this.ttl.getState()) 
    }

    disable() {
        this.wrapper.classList.add('disabled')
        this.wrapper.classList.remove('enabled')
    }

    template() {
        return `
            <div class='message-wrapper'>
                ${this.message.getState()}
                <span class="material-symbols-outlined">error</span>
            </div>
        `
    }

    listeners() {
        this.wrapper.onanimationend = (e) => {
            e.target.classList.remove('entry')
        }
    }
}

export default window.customElements.define('p-toast', Toast)