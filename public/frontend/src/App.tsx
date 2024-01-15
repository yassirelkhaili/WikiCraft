import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from "./components/Home";
import Login from './components/Login';
import Register from './components/Register';
import Dashboard from './components/Dashboard';
import Craftwiki from './components/Craftwiki';
import Createwiki from './components/Createwiki';
import Editwiki from './components/Editwiki';
import Createcategory from './components/Createcat';

function App() {
  return (
    <BrowserRouter>
    <Routes>
      <Route path='/' Component={Home}/>
      <Route path='/login' Component={Login}/>
      <Route path='/register' Component={Register}/>
      <Route path='/dashboard' Component={Dashboard}/>
      <Route path='/craftwiki' Component={Craftwiki}/>
      <Route path='/createWiki' Component={Createwiki}/>
      <Route path='/createcategory' Component={Createcategory}/>
      <Route path='/edit/:id' Component={Editwiki}/>
    </Routes>
    </BrowserRouter>
  );
}

export default App;
