export interface User {
  id: string
  firstname: string
  lastname: string
  email: string
  isAdmin: boolean
  createdAt: string
  updatedAt: string
}

export interface UserLite {
  id: string
  name: string
}