import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js';
import { PAGES_PATH } from '../../../config/env.config.js';

class CreatePlanPage extends PlainComponent {
    constructor() {
        super('p-create-plan-page', `${PAGES_PATH}plan/CreatePlanPage.css`)
    }

    template() {
        return `
            <h1>Create Plan Page</h1>
        `
    }
}

export default window.customElements.define('p-create-plan-page', CreatePlanPage)