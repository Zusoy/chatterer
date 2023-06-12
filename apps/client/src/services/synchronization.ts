import { eventChannel, EventChannel } from 'redux-saga'
import { Nullable } from 'utils'

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

export interface Push {
  readonly type: Type
  readonly context: Context
  readonly identifier: string
  readonly topic: string[]
  readonly payload: Nullable<Record<string, any>>
}

export function createSynchronizationChannel(eventSource: EventSource): EventChannel<Push> {
  return eventChannel(emitter => {
    const messageHandler = (event: MessageEvent) => {
      const data = (JSON.parse(event.data)) as Push
      emitter(data)
    }

    const errorHandler = (error: Event) => {
      console.error(`EventError: ${ error }`)
    }

    eventSource.addEventListener('message', messageHandler)
    eventSource.addEventListener('error', errorHandler)

    const unsubscribe = () => {
      eventSource.close()
    }

    return unsubscribe
  })
}

export const extractSourceLinkHeader = (header: string, rel: string): Nullable<string> => {
  const linkRegex = /<([^>]+)>;\s*rel="([^"]+)"/g;
  let match;

  while ((match = linkRegex.exec(header)) !== null) {
    const [, link, currentRel] = match;

    if (currentRel === rel) {
      return link;
    }
  }

  return null;
}

export type StreamSources = Nullable<{ url: string, topic: string }>
export const getStreamSources = (header: string): StreamSources => {
  const url = extractSourceLinkHeader(header, 'mercure')
  const topic = extractSourceLinkHeader(header, 'self')

  return url && topic ? { url, topic } : null
}
