import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH} from '../../../config/env.config.js'

class LoadingSpinner extends PlainComponent {
    constructor() {
        super('p-loading-spinner', `${BASE_COMPONENTS_PATH}loading-spinner/LoadingSpinner.css`)
    }

    template() {
        return `
            <div class="left"></div>
            <div class="center"></div>
            <div class="right"></div>
        `
    }
}

export default window.customElements.define('p-loading-spinner', LoadingSpinner)