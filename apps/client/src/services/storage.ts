import Cookies from 'universal-cookie'
import { Nullable } from 'utils'

const cookies = new Cookies()

export type Save = (key: string, value: any) => Promise<boolean>
export const save: Save = (key: string, value: any): Promise<boolean> => {
  return new Promise((resolve, reject) => {
    try {
      cookies.set(key, value, { path: '/' })
      resolve(true)
    } catch (e) {
      reject(e)
    }
  })
}

export type Remove = (key: string) => Promise<boolean>
export const remove: Remove = (key: string): Promise<boolean> => {
  return new Promise((resolve, reject) => {
    try {
      cookies.remove(key, { path: '/' })
      resolve(true)
    } catch (e) {
      reject(e)
    }
  })
}

export type Get = (key: string) => Promise<Nullable<any>>
export const get: Get = (key: string): Promise<any> => {
  return new Promise((resolve, reject) => {
    try {
      resolve(cookies.get(key) || null)
    } catch (e) {
      reject(e)
    }
  })
}
