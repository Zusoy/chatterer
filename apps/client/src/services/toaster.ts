import { toast as toastify } from 'react-toastify'

export enum ToastType {
  Success = 'success',
  Warning = 'warning',
  Error = 'error',
  Info = 'info',
  Default = 'default'
}

export type ToastProps = {
  content: React.ReactNode,
  type: ToastType,
  delay?: number
}

const toast = ({ content, type, delay }: ToastProps) =>
  toastify(content, {
    delay,
    type: type || ToastType.Default,
    position: 'bottom-right'
  })

export default toast
