import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { stringify } from 'query-string';
import { Observable, throwError } from 'rxjs';
import { catchError, share } from 'rxjs/operators';

@Injectable()
export class ApiClient {
  private static readonly API_URL = 'http://127.0.0.1:8081';

  constructor(
    private http: HttpClient
  ) {
  }

  public get<T>(path: string, queries: Record<string, any> = {}, headers: Record<string, any> = {}): Observable<T> {
    return this.http.get<T>(`${ApiClient.API_URL}/${path}?${stringify(<any>queries)}`, { headers }).pipe(
      share(),
      catchError(this.handleError.bind(this))
    );
  }

  public post<T>(path: string, body: Record<string, any> = {}): Observable<T> {
    return this.http.post<T>(`${ApiClient.API_URL}/${path}`, body).pipe(
      catchError(this.handleError.bind(this))
    );
  }

  public put<T>(path: string, body: Record<string, any> = {}): Observable<T> {
    return this.http.put<T>(`${ApiClient.API_URL}/${path}`, body).pipe(
      catchError(this.handleError.bind(this))
    );
  }

  public delete<T>(path: string, body: Record<string, any> = {}): Observable<T> {
    return this.http.delete<T>(`${ApiClient.API_URL}/${path}`, { ...body }).pipe(
      catchError(this.handleError.bind(this))
    );
  }

  private handleError(response: HttpErrorResponse): Observable<any> {
    if (response.error instanceof ErrorEvent || response.status === 500) {
      return throwError({ error: ['An error has occurred'] });
    }

    return throwError(response.error);
  }
}
