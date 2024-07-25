import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js';
import { PAGES_PATH } from '../../../config/env.config.js';

// Este componente chequea si el usuario está logueado y redirige:
// - LoginPage (si NO lo está)
// - HomePage (si lo está)
// El chequeo lo hará llamando a un método de la api
class IndexPage extends PlainComponent {
    constructor() {
        super('p-index-page', `${PAGES_PATH}index/IndexPage.css`)

        this.redirectTo('login');
    }

    redirectTo(path) {
        window.location.replace(path)
    }

    template() {
        return ``
    }
}

export default window.customElements.define('p-index-page', IndexPage)