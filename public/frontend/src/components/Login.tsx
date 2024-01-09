import React from 'react'
import brandlogo from "../images/brandlogo.webp";

const Login = () => {
  return (
    <>
    <section className="h-screen pt-40">
  <div className="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
  <a href="/" className="flex items-center mb-6 text-2xl font-semibold">
          <img className="h-8 w-28 mr-4" src={brandlogo} alt="logo"></img>
      </a>
      <div className="w-full rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 bg-gray-800 border-gray-700">
          <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 className="text-xl font-bold leading-tight tracking-tight text-slate-50 md:text-2xltext-slate-50">
                  Sign in to your account
              </h1>
              <form className="space-y-4 md:space-y-6">
                  <div>
                      <label htmlFor="email" className="block mb-2 text-sm font-medium text-slate-50">Email</label>
                      <input type="email" name="email" id="email" className="sm:text-sm rounded-lg block w-full p-2 focus:outline-none focus:ring focus:border-primary-600 bg-gray-700 border-gray-600 placeholder-gray-400 text-slate-50" placeholder="name@company.com" required autoComplete="on">
                      </input>
                  </div>
                  <div>
                      <label htmlFor="password" className="block mb-2 text-sm font-medium text-slate-50">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" className="sm:text-sm rounded-lg block w-full p-2 focus:outline-none focus:ring focus:border-primary-600 bg-gray-700 border-gray-600 placeholder-gray-400 text-slate-50" required autoComplete="current-password">
                      </input>
                  </div>
                  <div className="flex items-center justify-between">
                      <div className="flex items-start">
                          <div className="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3border-gray-600 focus:ring-primary-600 ring-offset-gray-800" required>
                            </input>
                          </div>
                          <div className="ml-3 text-sm">
                            <label htmlFor="remember" className="text-gray-400">Remember me</label>
                          </div>
                      </div>
                      <a href="/recovery" className="text-sm font-medium hover:underline text-primary-500">Forgot password?</a>
                  </div>
                  <button type="submit" className="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center focus:ring-primary-800">Sign in</button>
                  <p className="text-sm font-light text-gray-400">
                      Don’t have an account yet? <a href="/register" className="font-medium text-primary-500 hover:underline ">Register</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>
    </>
  )
}

export default Login