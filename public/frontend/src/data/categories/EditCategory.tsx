import React, {useEffect, useState} from 'react'
import Toast from '../../utils/ToastComponent';
import Spinner from '../../utils/Spinner';

interface Category {
name: string;
description: string;
}

interface ResponseProps {
status: string;
message: string;
content?: Array<Category>;
}

const Createwiki = () => {
    const [categories, setcategories] = useState<Category>();
    const [isLoading, setisLoading] = useState<boolean>(false);
    const [toast, settoast] = useState<React.ReactNode>(<></>);
    const [isSubmitted, setisSubmitted] = useState<boolean>(false);
    const path = window.location.pathname;
    const parts = path.split('/');
    const id = parts[parts.length - 1];

    const fetchCategories = async(): Promise<ResponseProps> => {
        const endpoint: string = process.env.REACT_APP_HOST_NAME + '/fetchcategory/' + id;
    const options: {
      method: string;
      credentials: RequestCredentials;
  } = {
      method: 'GET',
      credentials: 'include',
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

      //handle category creation

      const handleChange = (event: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>): void => {
        const { name, value } = event.target;
      
    setcategories((prevCategoryInfo: Category | undefined) => { 
            return prevCategoryInfo !== undefined ? {...prevCategoryInfo, [name]: value} : {
                name: name === 'name' ? value : '',
                description: name === 'description' ? value : '',
              };
          });
      };
      

      const postCategoryInfo = async(): Promise<ResponseProps> => {
        const endpoint: string = process.env.REACT_APP_HOST_NAME + '/editcategoryroute/' + id;
        const formData = new URLSearchParams();
        if (categories) {
              formData.append('name', categories.name);
              formData.append('description', categories.description);
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


      const handleFormSubmission = (event: React.MouseEvent<HTMLButtonElement>): void => {
        event.preventDefault();
        setisLoading(true);
        setisSubmitted(true);
        postCategoryInfo().then((response: ResponseProps) => {
         switch(response.status) {
          case 'success':
          settoast(<Toast message={response.message} type='success'></Toast>);
          setTimeout(() => window.location.href = process.env.REACT_APP_HOST_NAME + '/craftwiki' as string, 1000);
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

      useEffect(() => {
        setisLoading(true);
    fetchCategories().then((response: ResponseProps) => {
        response.content && setcategories(response.content[0]);
        switch(response.status) {
            case 'success':
            settoast(<Toast message={response.message} type='success'></Toast>);
            break;
            default:
            settoast(<Toast message={response.message} type='warning'></Toast>);
            break;
           }
    }).catch((error) => settoast(<Toast message={`An error has occured ${error}`} type='danger'/>)).finally(() => setisLoading(false));
      }, [])
      
  return (
    <>
        <section>
  <div className="py-8 px-4 mx-auto max-w-2xl lg:py-16">
      <h2 className="mb-4 text-xl font-bold text-[#3B82F6]">Edit category</h2>
      <form>
          <div className="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div className="sm:col-span-2">
                  <label htmlFor="title" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                  <input type="text" name="name" id="title" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:outline-none" placeholder="Category name here" value={categories?.name} required onChange={handleChange}>
                  </input>
              </div>
              <div className="sm:col-span-2">
                  <label htmlFor="description" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                  <textarea name="description" id="description" rows={8} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:outline-none" placeholder="Category description here" value={categories?.description} onChange={handleChange}></textarea>
              </div>
          </div>
          <div className='mt-4 sm:mt-6'>
          {isLoading ? <Spinner /> : <button type="button" className={`inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg ${isSubmitted ? 'bg-gray-600' : 'bg-primary-600 hover:bg-primary-700 focus:ring-primary-800 focus:ring-4 focus:outline-none'}`} onClick={handleFormSubmission}>
              Edit Category
          </button>}
          </div>
      </form>
  </div>
  {toast}
</section>
    </>
  )
}

export default Createwiki