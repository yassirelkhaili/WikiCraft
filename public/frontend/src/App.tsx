import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from "./components/Home";
import About from './components/About';

function App() {
  return (
    <BrowserRouter>
    <Routes>
      <Route path='/' Component={Home}/>
      <Route path='/books' Component={About}/>
    </Routes>
    </BrowserRouter>
  );
}

export default App;
