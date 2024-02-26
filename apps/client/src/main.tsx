import React from 'react'
import ReactDOM from 'react-dom/client'
import App from 'App'
import { store } from 'app/store'
import { Provider as StoreProvider } from 'react-redux'
import 'style.css'

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <StoreProvider store={store}>
      <App />
    </StoreProvider>
  </React.StrictMode>,
)
