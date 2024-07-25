import { PlainComponent, PlainRouter } from '../node_modules/plain-reactive/src/index.js'
import { SRC_PATH } from './config/env.config.js'

/* PAGES */
import IndexPage from './components/pages/index/IndexPage.js'
import LoginPage from './components/pages/login/LoginPage.js'

class pApp extends PlainComponent {
    constructor() {
        super('p-app', `${SRC_PATH}App.css`)

        this.router = new PlainRouter('http://localhost/no-plan/frontend/public/')
    }

    template() {
        return `
            ${this.router.route({
                '':                     '<p-index-page></p-index-page>',
                'login':                '<p-login-page></p-login-page>',
                'signup':               '<h2>SignUpPage</h2>',
                'password-recovery':    '<h2>PwdRecoveryPage</h2>',
                'planner':              '<h2>PlannerPage</h2>',
                'user/profile':         '<h2>UserProfilePage</h2>',
                'user/plans':           '<h2>UserPlansPage</h2>',
                'plan/create':          '<h2>PlanCreationPage</h2>',
                '*':                    '<h2>Not Found</h2>'
            })}
        `
    }
}

export default window.customElements.define('p-app', pApp)