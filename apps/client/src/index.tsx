import React from 'react';
import { store } from 'app/store'
import theme from 'app/theme'
import { Provider } from 'react-redux'
import { ThemeProvider } from 'styled-components';
import App from './App';
import ReactDOM from 'react-dom/client';
import 'semantic-ui-css/semantic.min.css';

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

root.render(
  <React.StrictMode>
    <Provider store={ store }>
      <ThemeProvider theme={ theme }>
        <App />
      </ThemeProvider>
    </Provider>
  </React.StrictMode>
);
