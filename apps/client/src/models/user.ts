import { type Opaque } from 'utils'

export type UserId = Opaque<'UserId', string>

export type User = {
  id: UserId
  firstname: string
  lastname: string
  email: string
  isAdmin: boolean
  createdAt: string
  updatedAt: string
}

export type UserLite = {
  id: UserId
  name: string
}
