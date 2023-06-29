import { toast, ToastContent, Id } from 'react-toastify'

export type Success = (content: ToastContent) => Promise<Id>
export const success: Success = content => {
  return new Promise((resolve, reject) => {
    try {
      const id = toast.success(content, { position: toast.POSITION.TOP_RIGHT })
      resolve(id)
    } catch (e) {
      reject(e)
    }
  })
}

export type Error = (content: ToastContent) => Promise<Id>
export const error: Error = content => {
  return new Promise((resolve, reject) => {
    try {
      const id = toast.error(content, { position: toast.POSITION.TOP_RIGHT })
      resolve(id)
    } catch (e) {
      reject(e)
    }
  })
}
