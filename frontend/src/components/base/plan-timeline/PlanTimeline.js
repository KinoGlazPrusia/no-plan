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
    this.timeline = new PlainState(
      [
        {
          time: '14:52',
          title: 'Encuentro',
          description:
            'Nos reunimos delante de la puerta de atrás del edificio del ayuntamiento.'
        },
        {
          time: '15:00',
          title: 'Primer bar',
          description: 'Vamos a tomar un vermut a la bodega X'
        },
        {
          time: '15:00',
          title: 'Primer bar',
          description: 'Vamos a tomar un vermut a la bodega X'
        }
      ],
      this
    )
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
                        <span class="title">${step.title}</span>
                        <span class="description">${step.description}</span>
                    </div>
                    <div class="connection-line"></div>
                </div>
            `
          })
          .join('')}
    `
  }

  addStep() {}

  removeStep() {}

  editStep() {}

  sortStep() {
    // [ ] Se ordenarán por hora
  }

  validate() {}
}

export default window.customElements.define('p-plan-timeline', PlanTimeline)
