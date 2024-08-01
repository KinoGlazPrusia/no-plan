import { PlainComponent, PlainState } from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

/* COMPONENTS */
/* eslint-disable */
import FormFeedback from '../form-feedback/FormFeedback.js'
/* eslint-enable */

/* SERVICES */
import * as validators from '../../../utils/validators.js'

class FileInput extends PlainComponent {
  constructor () {
    super('p-file-input', `${BASE_COMPONENTS_PATH}file-input/FileInput.css`)

    this.validator = validators[this.getAttribute('validator')]
    this.validity = new PlainState({
      isValid: true,
      messages: []
    }, this)

    this.inputValue = new PlainState(null, this)
  }

  template () {
    // Añadiendo el atributo 'multiple' en el input se pueden subir varios archivos
    return `
            <label class="label">
                ${this.getAttribute('label')} 
                <span class="valid-extensions">
                    (PNG, JPEG or JPG)
                </span>
            </label>

            <input 
            class="input" 
            type="file" 
            name="${this.getAttribute(name)}" 
            accept="${this.getAttribute('accept')}"
            hidden>

            <div class="input-frame">
                <span class="file-input-icon material-symbols-outlined">cloud_upload</span>  
            </div>

            <p-form-feedback class="feedback"></p-form-feedback>
        `
  }

  listeners () {
    this.wrapper.onclick = () => this.openFileBrowser()
    this.$('.input').onchange = (e) => this.handleFileSelect(e)
  }

  openFileBrowser () {
    this.$('.input').click()
  }

  handleFileSelect (e) {
    this.inputValue.setState(e.target.files[0], false)
    this.validator && this.validate()
  }

  onFileDeselected () {
    this.inputValue.setState(null, false)
    this.$('.input').value = ''
    this.validate()
  }

  validate () {
    const value = this.inputValue.getState()

    let isValid = null
    const validityMessage = this.validator(value)

    validityMessage.length > 0
      ? isValid = false
      : isValid = true

    !isValid
      ? !this.wrapper.classList.contains('is-invalid') && this.wrapper.classList.add('is-invalid')
      : this.wrapper.classList.contains('is-invalid') && this.wrapper.classList.remove('is-invalid')

    this.validity.setState({
      isValid,
      messages: validityMessage
    }, false)

    // Re-renderizamos el componente de feedback para mostrar errores o mensajes
    this.$('.feedback').errors.setState(validityMessage)
    isValid ? 
        this.$('.feedback').messages.setState([value.name])
        :
        this.$('.feedback').messages.setState([])
  }

  reset () {
    this.$('input').value = ''
    this.wrapper.classList.remove('is-invalid')
    this.wrapper.classList.remove('is-valid')
  }
}

export default window.customElements.define('p-file-input', FileInput)
