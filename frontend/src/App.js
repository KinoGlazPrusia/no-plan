import { PlainComponent, PlainRouter, PlainContext } from '../node_modules/plain-reactive/src/index.js'
import { SRC_PATH, PUBLIC_PATH } from './config/env.config.js'

/* eslint-disable */
/* PAGES */
import IndexPage from './components/pages/index/IndexPage.js'
import LoginPage from './components/pages/login/LoginPage.js'
import SignUpPage from './components/pages/signup/SignUpPage.js'
import PasswordRecoveryPage from './components/pages/password-recovery/PasswordRecoveryPage.js'
import PlannerPage from './components/pages/planner/PlannerPage.js'
import UserProfilePage from './components/pages/user/UserProfilePage.js'
import UserPlansPage from './components/pages/user/UserPlansPage.js'
import CreatePlanPage from './components/pages/plan/CreatePlanPage.js'

/* COMPONENTS */
import Navbar from './components/mid/navbar/Navbar.js'
/* eslint-enable */

class pApp extends PlainComponent {
  constructor() {
    super('p-app', `${SRC_PATH}App.css`)

    this.router = new PlainRouter(PUBLIC_PATH)
    this.navigationContext = new PlainContext('navigation', this, false)
    this.navigationContext.setData({ currentPage: 'index' })

    // En este componente guardaremos los contextos generales de la aplicación
    // mientras que en los componentes de las páginas guardaremos los contextos
    // propios de cada página
  }

  template() {
    /* eslint-disable */
    return `
      ${this.router.route({
        '':                     '<p-index-page></p-index-page>',
        'login':                '<p-login-page></p-login-page>',
        'signup':               '<p-signup-page></p-signup-page>',
        'password-recovery':    '<p-password-recovery-page></p-password-recovery-page>',
        'planner':              '<p-planner-page></p-planner-page>',
        'user/profile':         '<p-user-profile-page></p-user-profile-page>',
        'user/plans':           '<p-user-plans-page></p-user-plans-page>',
        'plan/create':          '<p-create-plan-page></p-create-plan-page>',
        '*':                    '<h2>Not Found</h2>'
      })}
    `
    /* eslint-enable */
  }
}

export default window.customElements.define('p-app', pApp)
