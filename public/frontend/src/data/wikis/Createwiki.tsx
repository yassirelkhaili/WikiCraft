import React, {useEffect, useState} from 'react'
import Toast from '../../utils/ToastComponent';
import Spinner from '../../utils/Spinner';

interface Category {
id: string;
name: string;
description: string;
}

interface ResponseProps {
        status: string;
        message: string;
        content?: Array<Category>;
}

export type Tag = string;

interface Wiki {
    title: string;
    content: string;
    categoryID: string;
}

const Createwiki = () => {
    const [wikiInfo, setwikiInfo] = useState<Wiki | undefined>();
    const [categories, setcategories] = useState<Array<Category>>();
    const [tags, settags] = useState<Array<Tag>>([]);
    const [isLoading, setisLoading] = useState<boolean>(false);
    const [toast, settoast] = useState<React.ReactNode>(<></>);
    const [inputValue, setInputValue] = useState<string>('');
    const [isSubmitted, setisSubmitted] = useState<boolean>(false);

    const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
      setInputValue(event.target.value);
    };
  
    const handleKeyPress = (event: React.KeyboardEvent<HTMLInputElement>) => {
      const checkDuplicateTag = (tofind: Tag) => tags.some((tag: Tag) => tofind === tag);
      if (!checkDuplicateTag(inputValue.trim())) {
        if (event.key === 'Enter' && inputValue.trim() !== '') {
            settags((prevTags: Array<Tag>) => {
                return prevTags && [...prevTags, inputValue.trim()]
              });
            setInputValue('');
          }
      } else {
        settoast(<Toast message="Tags must be unique for each wiki" type='warning'></Toast>)
      }
    };

    const fetchCategories = async(): Promise<ResponseProps> => {
        const endpoint: string = process.env.REACT_APP_HOST_NAME + '/fetchcategories';
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

      //handle wiki creation

      const handleChange = (event: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>): void => {
        const { name, value } = event.target;
      
    setwikiInfo((prevwikiInfo: Wiki | undefined) => { 
            return prevwikiInfo !== undefined ? {...prevwikiInfo, [name]: value} : {
                title: name === 'title' ? value : '',
                content: name === 'content' ? value : '',
                categoryID: name === 'categoryID' ? value : '1',
              };
          });
      };
      

      const postWikiInfo = async(): Promise<ResponseProps> => {
        const endpoint: string = process.env.REACT_APP_HOST_NAME + '/postwiki';
        const formData = new URLSearchParams();
        if (wikiInfo) {
              formData.append('title', wikiInfo.title);
              formData.append('content', wikiInfo.content);
              formData.append('categoryID', wikiInfo.categoryID.toString());
              if (tags && tags.length > 0) {
                tags.forEach(tag => {
                    formData.append('tags[]', tag);
                });
            }
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

      const deleteTag = (tofind: Tag): void => settags(tags.filter((tag: Tag) => tag !== tofind));

      const handleFormSubmission = (event: React.MouseEvent<HTMLButtonElement>): void => {
        event.preventDefault();
        setisLoading(true);
        setisSubmitted(true);
        postWikiInfo().then((response: ResponseProps) => {
         switch(response.status) {
          case 'success':
          console.log("Wiki created successfuly");
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
        setcategories(response.content);
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
      <h2 className="mb-4 text-xl font-bold text-[#3B82F6]">Add Wiki</h2>
      <form>
          <div className="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div className="sm:col-span-2">
                  <label htmlFor="title" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                  <input type="text" name="title" id="title" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:outline-none" placeholder="Wiki title here" required onChange={handleChange}>
                  </input>
              </div>
              <div>
                  <label htmlFor="category" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                  <select name='categoryID' id="category" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:outline-none" onChange={handleChange} defaultValue='1'>
                {categories && categories.map((category: Category, index: number) => <option value={category.id} key={index}>{category.name}</option>)}
                  </select>
</div>
<div>
                  <label htmlFor="item-weight" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white" id="tagsContainer">Tags</label>
                  <div>
                  <div className="p-2.5 rounded-lg flex flex-wrap justify-start items-center bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-primary-500 focus:border-primary-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:outline-none">
                    {tags && tags.map((tag: Tag, index: number) => {
                        return (
                            <div className='px-1' key={index}>
                                    <div className='dark:bg-primary-900 flex justify-center items-center rounded gap-1 py-1 px-2 text-primary-300 mt-1'>
                                    <span className="text-xs font-medium text-primary-300">{tag}</span>
                                    <button type="button" onClick={() => deleteTag(tag)}>
                                    <svg className="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    </button>
                                    </div>
                                </div>
                        )
                    })}
                  <input type="text" name="item-weight" id="item-weight" className="ml-1 rounded-lg outline-none focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Add Tags here" required value={inputValue} onChange={handleInputChange} onKeyDown={handleKeyPress}>
                    </input>
                  </div>
              </div>
              </div>
              <div className="sm:col-span-2">
                  <label htmlFor="description" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                  <textarea maxLength={5000} name="content" id="description" rows={8} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:outline-none" placeholder="Wiki content here" onChange={handleChange}></textarea>
              </div>
          </div>
          <div className='mt-4 sm:mt-6'>
          {isLoading ? <Spinner /> : <button type="button" className={`inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg ${isSubmitted ? 'bg-gray-600' : 'bg-primary-600 hover:bg-primary-700 focus:ring-primary-800 focus:ring-4 focus:outline-none'}`} onClick={handleFormSubmission}>
              Add Wiki
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