import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

class LoadingSpinner extends PlainComponent {
  constructor() {
    super(
      'p-loading-spinner',
      `${BASE_COMPONENTS_PATH}loading-spinner/LoadingSpinner.css`
    )

    this.ttl = 1000 * 30 // 30s
    this.isError = new PlainState(false, this)
    this.isSuccess = new PlainState(false, this)
  }

  template() {
    setTimeout(() => {
      !this.isSuccess.getState() && this.error()
    }, this.ttl)

    if (this.isError.getState()) {
      return `
                <div class="error-wrapper">
                    <span class="sorry">Sorry!</span>
                    <span class="error-message">The server is not responding</span>
                    <span class="error-detail">Wait a moment and reload the page.</span>
                </div>
            `
    } else if (this.isSuccess.getState()) {
      return `
                <div class="success-wrapper">
                    <span class="success-icon material-symbols-outlined">check_circle</span>
                    <span class="error-message">${this.getAttribute('success-message')}</span>
                    <span class="error-detail">${this.getAttribute('success-detail')}</span>
                </div>
            `
    }

    return `
            <div class="left"></div>
            <div class="center"></div>
            <div class="right"></div>
        `
  }

  error() {
    this.isError.setState(true)
  }

  success() {
    this.isSuccess.setState(true)
  }
}

export default window.customElements.define('p-loading-spinner', LoadingSpinner)
