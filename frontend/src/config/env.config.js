// Las rutas son relativas al archivo desde donde son llamadas
// En este caso desde el archivo App.js que es llamado desde index.html
// Por lo tanto las rutas son relativas al archivo index.html

export const BASE_PATH = 'http://localhost/no-plan/frontend/'

export const PUBLIC_PATH = BASE_PATH + 'public/'
export const SRC_PATH = BASE_PATH + 'src/'

export const PAGES_PATH = SRC_PATH + 'components/pages/'
export const BASE_COMPONENTS_PATH = SRC_PATH + 'components/base/'
export const MID_COMPONENTS_PATH = SRC_PATH + 'components/mid/'
export const COMPLEX_COMPONENTS_PATH = SRC_PATH + 'components/complex/'
