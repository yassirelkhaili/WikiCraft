import React, {useState} from 'react'
import brandlogo from '../images/brandlogo.webp';
import Spinner from '../utils/Spinner';
import Toast from '../utils/ToastComponent';

interface RegisterProps {
username: string;
email: string;
password: string;
confirmPassword: string;
terms: boolean;
}

export interface ResponseProps {
  status: string;
  message: string;
  content?: object;
}

const Register = () => {
    const [registerInfo, setRegisterInfo] = useState<RegisterProps | undefined>();
    const [isChecked, setisChecked] = useState<boolean>(false);
    const [isLoading, setisLoading] = useState<boolean>(false);
    const [isSubmitted, setisSubmitted] = useState<boolean>(false);
    const [toast, settoast] = useState<React.ReactNode>(<></>);

    const handleCheckbox = (): void => setisChecked(!isChecked);

    const handleChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
      const { name, value } = event.target;
      setRegisterInfo((prevRegisterInfo: RegisterProps | undefined) => {
        if (!prevRegisterInfo) {
          return {
            username: name === 'username' ? value : '',
            email: name === 'email' ? value : '',
            password: name === 'password' ? value : '',
            confirmPassword: name === 'confirmPassword' ? value : '',
            terms: false,
          };
        }
        return { ...prevRegisterInfo, [name]: value };
      });
    };    

    const postRegisterInfo = async(): Promise<ResponseProps> => {
      const endpoint: string = process.env.REACT_APP_HOST_NAME + '/registeruser';
      const formData = new URLSearchParams();
  if (registerInfo) {
    Object.entries(registerInfo).forEach(([key, value]) => {
      formData.append(key, value);
    });
  }
  const options: {
    method: string;
    credentials: RequestCredentials; 
    headers: {
        'Content-Type': string;
    };
    body: string;
} = {
    method: 'POST',
    credentials: 'include',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: formData.toString(),
};
      try {
        const response: Response = await fetch (endpoint, options);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data: ResponseProps = await response.json();
        return data;
      } catch (error) {
        throw new Error ("An Error has occured: " + error);
      }
    }

    const handleRegister = (event: React.FormEvent<HTMLFormElement>): void => {
        event.preventDefault();
        setisLoading(true);
        setisSubmitted(true);
        if(registerInfo) registerInfo.terms = isChecked; //update terms
        postRegisterInfo().then((response: ResponseProps) => {
         switch(response.status) {
          case 'success':
          settoast(<Toast message={response.message} type='success'></Toast>);
          setTimeout(() => window.location.href = process.env.REACT_APP_HOST_NAME + '/' as string, 1000);
          break;
          case 'insert':
          settoast(<Toast message={response.message} type='danger'></Toast>);
          setisSubmitted(false);
          break;
          default:
          settoast(<Toast message={response.message} type='warning'></Toast>);
          setisSubmitted(false);
          break;
         }
        }).catch((error) => console.error(error)).finally(() => setisLoading(false));
    }
    
    
  return (
    <>
      <section className="h-screen pt-40">
  <div className="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
  <a href="/" className="flex items-center mb-6 text-2xl font-semibold">
          <img className="h-8 w-56 mr-4" src={brandlogo} alt="logo"></img>
      </a>
      <div className="w-full rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 bg-gray-800 border-gray-700">
          <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 className="text-xl font-bold leading-tight tracking-tight text-slate-50 md:text-2xltext-slate-50">
                  Register an account
              </h1>
              <form className="space-y-4 md:space-y-6" onSubmit={handleRegister}>
              <div>
                      <label htmlFor="name" className="block mb-2 text-sm font-medium text-slate-50">Username</label>
                      <input type="text" name="username" id="name" className="sm:text-sm rounded-lg block w-full p-2 focus:outline-none focus:ring focus:border-primary-600 bg-gray-700 border-gray-600 placeholder-gray-400 text-slate-50" placeholder="John doe" onChange={handleChange} required autoComplete="on">
                      </input>
                  </div>
                  <div>
                      <label htmlFor="email" className="block mb-2 text-sm font-medium text-slate-50">Email</label>
                      <input type="email" name="email" id="email" className="sm:text-sm rounded-lg block w-full p-2 focus:outline-none focus:ring focus:border-primary-600 bg-gray-700 border-gray-600 placeholder-gray-400 text-slate-50" placeholder="name@company.com" onChange={handleChange} required autoComplete="on">
                      </input>
                  </div>
                  <div>
                      <label htmlFor="password" className="block mb-2 text-sm font-medium text-slate-50">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" className="sm:text-sm rounded-lg block w-full p-2 focus:outline-none focus:ring focus:border-primary-600 bg-gray-700 border-gray-600 placeholder-gray-400 text-slate-50" onChange={handleChange} required autoComplete="current-password">
                      </input>
                  </div>
                  <div>
                      <label htmlFor="confirmPassword" className="block mb-2 text-sm font-medium text-slate-50">Confirm password</label>
                      <input type="password" name="confirmPassword" id="confirmPassword" placeholder="••••••••" className="sm:text-sm rounded-lg block w-full p-2 focus:outline-none focus:ring focus:border-primary-600 bg-gray-700 border-gray-600 placeholder-gray-400 text-slate-50" onChange={handleChange} required autoComplete="current-password">
                      </input>
                  </div>
                  <div className="flex items-start">
                      <div className="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" name='terms' type="checkbox" className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" checked={isChecked} onChange={handleCheckbox}></input>
                      </div>
                      <div className="ml-3 text-sm">
                        <label htmlFor="terms" className="font-light text-gray-500 dark:text-gray-300">I accept the <a className="font-medium text-primary-600 hover:underline dark:text-primary-500" href="/terms">Terms and Conditions</a></label>
                      </div>
                  </div>
                  {isLoading ? <Spinner /> : <button type="submit" className={`w-full text-white ${isSubmitted ? 'bg-gray-600' : 'bg-primary-600 hover:bg-primary-700 focus:ring-primary-800 focus:ring-4 focus:outline-none'} font-medium rounded-lg text-sm px-5 py-2.5 text-center`} disabled={isSubmitted}>Create an account</button>}
                  <p className="text-sm font-light text-gray-400">
                      Already have an account? <a href="/login" className="font-medium text-primary-500 hover:underline ">Login here</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
  {toast}
</section>
    </>
  )
}

export default Register