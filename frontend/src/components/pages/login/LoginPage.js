import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js';
import { PAGES_PATH } from '../../../config/env.config.js';

class LoginPage extends PlainComponent {
    constructor() {
        super('p-login-page', `${PAGES_PATH}login/LoginPage.css`)
    }

    template() {
        return `
            <h1>Login Page</h1>
        `
    }
}

export default window.customElements.define('p-login-page', LoginPage)