export type User = {
  id: string
  firstname: string
  lastname: string
  email: string
  isAdmin: boolean
  createdAt: string
  updatedAt: string
}

export type UserLite = {
  id: string
  name: string
}
