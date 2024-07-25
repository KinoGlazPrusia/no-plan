import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js';
import { PAGES_PATH } from '../../../config/env.config.js';

class PlannerPage extends PlainComponent {
    constructor() {
        super('p-planner-page', `${PAGES_PATH}planner/PlannerPage.css`)
    }

    template() {
        return `
            <h1>Planner Page</h1>
        `
    }
}

export default window.customElements.define('p-planner-page', PlannerPage)