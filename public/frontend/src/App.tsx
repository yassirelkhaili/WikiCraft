import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from "./components/Home";
import Login from './components/Login';
import Register from './components/Register';
import Dashboard from './components/Dashboard';
import Craftwiki from './components/Craftwiki';

function App() {
  return (
    <BrowserRouter>
    <Routes>
      <Route path='/' Component={Home}/>
      <Route path='/login' Component={Login}/>
      <Route path='/register' Component={Register}/>
      <Route path='/dashboard' Component={Dashboard}/>
      <Route path='/craftwiki' Component={Craftwiki}/>
    </Routes>
    </BrowserRouter>
  );
}

export default App;
