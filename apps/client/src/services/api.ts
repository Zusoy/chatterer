import { get as storageGet } from 'services/storage'
import { Nullable } from 'utils'
import { getStreamSources } from 'services/synchronization'

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

async function withBearer(config: RequestInit): Promise<RequestInit> {
  const authToken: Nullable<string> = await storageGet('token')

  const init = authToken ? {
    ...config,
    headers: {
      ...config?.headers,
      'Authorization': `Bearer ${ authToken }`
    }
  } : config

  return Promise.resolve(init)
}

async function http(path: string, config: RequestInit) {
  const init = await withBearer(config)

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

export type StreamResponse<T> = [ Promise<T>, Nullable<EventSource> ]
export type ApiGetAndStream = <T>(path: string, config?: RequestInit) => Promise<StreamResponse<T>>
export const getAndStream: ApiGetAndStream = async (path, config) => {
  const init = await withBearer({
    ...config,
    method: 'get'
  })

  const request = new Request(`http://127.0.0.1:8081${path}`, init)
  const response = await fetch(request)

  await handleResponseErrors(response)

  const data = response.json().catch(() => {})
  const sourceLink = response.headers.get('Link')
  const sources = sourceLink ? getStreamSources(sourceLink) : null

  if (!sources) {
    return [ data, null ]
  }

  const url = new URL(sources.url)
  url.searchParams.append('topic', sources.topic)

  const eventSource = new EventSource(url)

  return [ data, eventSource ]
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
