export type Nullable<T> = T|null

declare const opaqueProp: unique symbol
export type Opaque<T, K> = T & { [opaqueProp]: K }
