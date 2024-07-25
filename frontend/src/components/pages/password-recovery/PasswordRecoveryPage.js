import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js';
import { PAGES_PATH } from '../../../config/env.config.js';

class PasswordRecoveryPage extends PlainComponent {
    constructor() {
        super('p-password-recovery-page', `${PAGES_PATH}password-recovery/PasswordRecoveryPage.css`)
    }

    template() {
        return `
            <h1>Password Recovery Page</h1>
        `
    }
}

export default window.customElements.define('p-password-recovery-page', PasswordRecoveryPage)