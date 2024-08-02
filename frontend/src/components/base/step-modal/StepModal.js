import {
  PlainComponent,
  PlainState
} from '../../../../node_modules/plain-reactive/src/index.js'
import { BASE_COMPONENTS_PATH } from '../../../config/env.config.js'

class StepModal extends PlainComponent {
  constructor() {
    super('p-step-modal')
  }

  addStep() {
    // [ ] Esta función llamará a la función del componente 'PlanTimeline'
    // Hay que elevar el estado a CreatePlanForm
  }

  loadStep() {
    // [ ] Esta función nos servirá para cargar los datos de un step ya asignado
  }

  clear() {}
}
