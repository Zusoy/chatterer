import React from 'react';
import Firewall from 'features/Firewall';
import { BrowserRouter, Route, Routes } from 'react-router-dom';

const App: React.FC = () =>
  <BrowserRouter>
    <Routes>
      <Route path='*' element={ <></> } />
    </Routes>
    <Firewall>
    </Firewall>
  </BrowserRouter>

export default App;
