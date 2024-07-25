import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js';
import { PAGES_PATH } from '../../../config/env.config.js';

class UserPlansPage extends PlainComponent {
    constructor() {
        super('p-user-plans-page', `${PAGES_PATH}user/UserPlansPage.css`)
    }

    template() {
        return `
            <h1>User Plans Page</h1>
        `
    }
}

export default window.customElements.define('p-user-plans-page', UserPlansPage)