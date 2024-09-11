// Las rutas son relativas al archivo desde donde son llamadas
// En este caso desde el archivo App.js que es llamado desde index.html
// Por lo tanto las rutas son relativas al archivo index.html

const MODE = 'dev' // 'dev' o 'prod'
const DEV_HOST = 'http://localhost/no-plan/'
const PROD_HOST = 'http://147.83.7.155/no-plan/'

export const APP_URL =
  MODE === 'dev' ? `${DEV_HOST}app/public/` : `${PROD_HOST}app/public/`

export const BASE_PATH =
  MODE === 'dev' ? `${DEV_HOST}frontend/` : `${PROD_HOST}frontend/`

export const PUBLIC_PATH = BASE_PATH + 'public/'
export const SRC_PATH = BASE_PATH + 'src/'

export const PAGES_PATH = SRC_PATH + 'components/pages/'
export const BASE_COMPONENTS_PATH = SRC_PATH + 'components/base/'
export const MID_COMPONENTS_PATH = SRC_PATH + 'components/mid/'
export const COMPLEX_COMPONENTS_PATH = SRC_PATH + 'components/complex/'

export const API_ENDPOINTS = {
  LOGIN: APP_URL + 'login',
  LOGOUT: APP_URL + 'logout',
  REGISTER: APP_URL + 'register',
  EMAIL_EXISTS: APP_URL + 'email-exists',
  IS_AUTHENTICATED: APP_URL + 'is-authenticated',
  FETCH_ALL_CATEGORIES: APP_URL + 'categories',
  FETCH_ALL_PLANS: APP_URL + 'plans/?page={page}&items_per_page={items}',
  FETCH_ALL_CREATED_PLANS:
    APP_URL + 'plans/created/?page={page}&items_per_page={items}',
  FETCH_ALL_ACCEPTED_PLANS:
    APP_URL + 'plans/accepted/?page={page}&items_per_page={items}',
  FETCH_ALL_REJECTED_PLANS:
    APP_URL + 'plans/rejected/?page={page}&items_per_page={items}',
  FETCH_ALL_PENDING_PLANS:
    APP_URL + 'plans/pending/?page={page}&items_per_page={items}',
  CREATE_PLAN: APP_URL + 'create-plan',
  UPDATE_PLAN: APP_URL + 'update-plan',
  FETCH_PLAN_DATA: APP_URL + 'plan/?id={id}',
  PARTICIPATE_IN_PLAN: APP_URL + 'participate/?plan_id={planId}',
  UNPARTICIPATE_IN_PLAN: APP_URL + 'cancel-participation/?plan_id={planId}',
  GET_PENDING_PARTICIPATIONS:
    APP_URL + 'pending-participations/?plan_id={planId}',
  GET_ACCEPTED_PARTICIPATIONS:
    APP_URL + 'accepted-participations/?plan_id={planId}',
  GET_REJECTED_PARTICIPATIONS:
    APP_URL + 'rejected-participations/?plan_id={planId}',
  GET_UNREAD_NOTIFICATIONS: APP_URL + 'notifications/unread',
  SET_NOTIFICATION_AS_READ: APP_URL + 'notifications/set-read/?id={id}',
  ACCEPT_PARTICIPATION:
    APP_URL +
    'accept-participation/?user_id={userId}&participant_id={participantId}&plan_id={planId}',
  REJECT_PARTICIPATION:
    APP_URL + 'reject-participation/?user_id={userId}&plan_id={planId}',
  USER_DATA: APP_URL + 'user-data',
  PLANS_COUNT: APP_URL + 'plans-count',
  PLANS_COUNT_CREATED: APP_URL + 'plans-count/created',
  PLANS_COUNT_ACCEPTED: APP_URL + 'plans-count/accepted',
  PLANS_COUNT_REJECTED: APP_URL + 'plans-count/rejected',
  PLANS_COUNT_PENDING: APP_URL + 'plans-count/pending'
}

export const PAGE_ROUTES = {
  INDEX: '',
  LOGIN: 'login',
  SIGNUP: 'signup',
  PASSWORD_RECOVERY: 'password-recovery',
  PLANNER: 'planner',
  USER_PROFILE: 'user/profile',
  USER_PLANS: 'user/plans',
  CREATE_PLAN: 'plan/create'
}
