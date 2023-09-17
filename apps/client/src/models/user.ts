export interface IUser {
  id: string
  firstname: string
  lastname: string
  email: string
  isAdmin: boolean
  createdAt: string
  updatedAt: string
}

export interface IUserLite {
  id: string
  name: string
}
