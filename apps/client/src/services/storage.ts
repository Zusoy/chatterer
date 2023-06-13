import Cookies, { CookieSetOptions } from 'universal-cookie'

const cookies = new Cookies()

export const save = (key: string, value: any, options?: CookieSetOptions): Promise<boolean> => {
  return new Promise((resolve, reject) => {
    try {
      cookies.set(key, value, options)
      resolve(true)
    } catch (e) {
      reject(e)
    }
  })
}

export default cookies
