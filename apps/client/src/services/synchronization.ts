import { eventChannel, type EventChannel } from 'redux-saga'
import { type Nullable } from 'utils'

export enum Type {
  Insert = 'push.insert',
  Update = 'push.update',
  Delete = 'push.delete'
}

export enum Context {
  Station = 'station',
  Channel = 'channel',
  Message = 'message'
}

export type Push<T> = {
  identifier: string
  type: Type
  context: Context
  topic: string[]
  payload: Nullable<T>
}

export function createSynchronizationChannel<T>(source: EventSource): EventChannel<Push<T>> {
  return eventChannel(emitter => {
    const messageHandler  = (event: MessageEvent): void => {
      const data = (JSON.parse(event.data)) as Push<T>
      emitter(data)
    }

    const errorHandler = (error: Event): void => {
      console.error(`EventError: ${error}`)
    }

    source.addEventListener('message', messageHandler)
    source.addEventListener('error', errorHandler)

    const unsubscribe = (): void => {
      source.close()
    }

    return unsubscribe
  })
}

export const extractSourceLinkHeader = (header: string, rel: string): Nullable<string> => {
  const linkRegex = /<([^>]+)>;\s*rel="([^"]+)"/g
  let match

  while ((match = linkRegex.exec(header)) !== null) {
    const [, link, currentRel] = match;

    if (currentRel === rel) {
      return link;
    }
  }

  return null
}

export type StreamSources = Nullable<{url: string, topic: string}>
export const getStreamSources = (header: string): StreamSources => {
  const url = extractSourceLinkHeader(header, 'mercure')
  const topic = extractSourceLinkHeader(header, 'self')

  return url && topic ? { url, topic } : null
}
