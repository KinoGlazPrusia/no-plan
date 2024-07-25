import { PlainComponent } from '../../../../node_modules/plain-reactive/src/index.js'
import { PUBLIC_PATH } from '../../../config/env.config.js'
import * as apiAuth from '../../../services/api.auth.js'

// Este componente chequea si el usuario está logueado y redirige:
// - LoginPage (si NO lo está)
// - HomePage (si lo está)
// El chequeo lo hará llamando a un método de la api
class IndexPage extends PlainComponent {
  constructor () {
    super('p-index-page')

    apiAuth.isAuthenticated() ? this.navigateTo('planner') : this.navigateTo('login')
  }

  template () {
    return ''
  }

  navigateTo (path) {
    window.location.replace(PUBLIC_PATH + path)
  }
}

export default window.customElements.define('p-index-page', IndexPage)
