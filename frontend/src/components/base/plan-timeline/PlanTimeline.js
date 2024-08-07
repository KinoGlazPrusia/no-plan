import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

class PlanTimeline extends PlainComponent {
  constructor() {
    super(
      'p-plan-timeline',
      `${BASE_COMPONENTS_PATH}plan-timeline/PlanTimeline.css`
    )

    this.isLoading = new PlainState(false, this)
    this.isError = new PlainState(false, this)
    /*  this.timeline = new PlainState(
      [
        {
          time: '14:52',
          title: 'Encuentro',
          description:
            'nos reunimos delante de la puerta de atrás del edificio del ayuntamiento.'
        },
        {
          time: '15:00',
          title: 'Primer bar',
          description: 'vamos a tomar un vermut a la bodega X.'
        },
        {
          time: '16:25',
          title: 'Segundo bar',
          description:
            'vamos a tomar un vermut al otro bar un poco más adelante.'
        }
      ],
      this
    ) */
    this.timeline = new PlainState([], this)
  }

  template() {
    return `
        ${this.timeline
          .getState()
          .map((step) => {
            return `
                <div class="step-wrapper">
                    <div class="step-time">${step.time}</div>
                    <div class="step-info">
                        <span class="title">
                            ${step.title[0].toUpperCase() + step.title.substring(1)}
                        </span>
                        <span class="description">
                            ${step.description[0].toUpperCase() + step.description.substring(1)}
                        </span>
                    </div>
                    <div class="connection-line"></div>
                </div>
            `
          })
          .join('')}
    `
  }

  addStep(step) {
    /* El step debe ser un objeto con las siguientes claves: 
      time: string (hora)
      title: string (titulo)
      description: string (descripción)
    */
    this.timeline.setState([...this.timeline.getState(), step])
    // [ ] Se debería hacer un sortStep() para ordenar las tareas por hora
  }

  removeStep() {}

  editStep() {}

  sortStep() {
    // [ ] Se ordenarán por hora
  }

  validate() {}
}

export default window.customElements.define('p-plan-timeline', PlanTimeline)
