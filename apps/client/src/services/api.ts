import storage from 'services/storage'

export type ApiError = {
  code: 0
  extra: {
    [key: string]: {
      message: string
    }
  }
  message: string
  type: string
}

export class ApiErrorResponse {
  constructor(
    public readonly status: number,
    public readonly url: string,
    public readonly error: ApiError
  ) {}
}

const handleResponseErrors = async (response: Response) => {
  if (!response.ok) {
    const { error } = await response.json()

    throw new ApiErrorResponse(
      response.status,
      response.url,
      error
    )
  }
}

async function http(path: string, config: RequestInit) {
  const authToken: string|null = storage.get('token') || null

  const init: RequestInit = authToken ? {
    ...config,
    headers: {
      ...config?.headers,
      'Authorization': `Bearer ${authToken}`
    }
  } : config

  const request = new Request(`http://127.0.0.1:8081${path}`, init)
  const response = await fetch(request)

  await handleResponseErrors(response)

  return response.json().catch(() => {})
}

export type ApiGet = <T>(path: string, config?: RequestInit) => Promise<T>
export const get: ApiGet = (path, config) => {
  const init: RequestInit = { ...config, method: 'get' }

  return http(path, init)
}

export type ApiPost = <T>(path: string, body?: Object, config?: RequestInit) => Promise<T>
export const post: ApiPost = (path, body, config) => {
  const init: RequestInit = {
    ...config,
    method: 'post',
    body: JSON.stringify(body),
    headers: { 'Content-Type': 'application/json' },
  }

  return http(path, init)
}
