import { log } from 'services/logger';
const apiPath = process.env.REACT_APP_API_URL;

export type ApiError = {
  code: 0,
  extra: {
    [key: string]: {
      message: string
    }
  }
  message: string
}

export class ApiErrorResponse {
  constructor (
    public readonly status: number,
    public readonly url: string,
    public readonly error: ApiError,
  ) {
  }
}

const handleResponseErrors = async (response: Response) => {
  if (!response.ok) {
    const { error } = await response.json();

    throw new ApiErrorResponse(
      response.status,
      response.url,
      error
    );
  }
}

async function http(path: string, config: RequestInit) {
  const request = new Request(`${apiPath}${path}`, {
    ...config,
    credentials: 'include',
  });

  const response = await fetch(request, config);
  await handleResponseErrors(response);

  return response.json().catch(() => ({}));
}

export async function get<T>(path: string, config?: RequestInit): Promise<T> {
  const init: RequestInit = { method: 'GET', ...config };

  return await http(path, init);
}

export async function post<U>(path: string, body: Object = {}, config?: RequestInit): Promise<U> {
  const init: RequestInit = {
    ...config,
    method: 'post',
    body: JSON.stringify(body),
    headers: { 'Content-Type': 'application/json' },
  };

  return await http(path, init);
}
