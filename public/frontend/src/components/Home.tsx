import React, {useEffect, useState} from "react"
import Spinner from "../utils/Spinner";

interface Wiki {
  id: number;
  title: string;
  content: string;
  category: string;
  author: string;
  tags: string;
}

interface ResponseProps {
  status: string;
  message: string;
  content?: Array<Wiki>;
}

interface CategoryResponseProps {
  status: string;
  message: string;
  content?: Array<Category>;
}

interface Category {
  id: string;
  name: string;
  description: string;
}

const Home = () => {
  const [wikis, setwikis] = useState<Array<Wiki>>();
    const [isLoading, setisLoading] = useState<boolean>(false);
    const [categories, setcategories] = useState<Array<Category>>();
    const [searchInput, setsearchInput] = useState<string>('');
    const [searchCategory, setsearchCategory] = useState<string>('');
    const [searchQuery, setSearchQuery] = useState<string>('');

    const fetchCategories = async(): Promise<CategoryResponseProps> => {
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
        const data: CategoryResponseProps = await response.json();
        return data;
      } catch (error) {
        throw new Error ("An Error has occured: " + error);
      }
    }

    const fetchWikis = async(): Promise<ResponseProps> => {
      const endpoint: string = process.env.REACT_APP_HOST_NAME + '/fetchwikis';
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

  const toggleCategories = () => {
    const dropdownMenu = document.getElementById("dropdown") as HTMLUListElement;
    dropdownMenu && dropdownMenu.classList.toggle('hidden');
  };

  const updateWikis = (): void => {
    setisLoading(true);
    fetchWikis().then((response: ResponseProps) => {
        setwikis(response.content);
    }).catch((error) => console.error(`An error has occured ${error}`)).finally(() => setisLoading(false));
  }

  useEffect(() => {
    setisLoading(true);
    fetchWikis().then((response: ResponseProps) => {
        setwikis(response.content);
        console.log(response.message);
    }).catch((error) => console.error(`An error has occured ${error}`)).finally(() => setisLoading(false));
    fetchCategories().then((response: CategoryResponseProps) => {
        setcategories(response.content);
    }).catch((error) => console.error(`An error has occured ${error}`));
  }, [])

  const setSearchCategory = (searchCategory: string): void => {
    setsearchCategory(searchCategory);
    toggleCategories();
    //change category button label
    const dropdownBtn = document.getElementById("dropdown-button-text") as HTMLSpanElement;
    dropdownBtn.textContent = searchCategory === '' ? 'All categories' : searchCategory;
  }

  const displaySearchResults = (): void => {
    const searchDropDown = document.getElementById("search-result") as HTMLDivElement;
    searchDropDown && searchDropDown.classList.toggle('hidden');
  }

  const removeSearchResult = (): void => {
    const searchDropDown = document.getElementById("search-result") as HTMLDivElement;
    (searchDropDown && !searchDropDown.classList.contains("hidden")) && searchDropDown.classList.add('hidden');
  }

  const filteredWikis = wikis
  ? wikis.filter((wiki: Wiki) => {
      const isCategoryMatch: boolean = searchCategory === '' ? true : searchCategory === wiki.category;
      const isNameMatch: boolean = wiki.title.toLowerCase().includes(searchQuery.toLowerCase());
      const tagsArray: Array<string> = wiki.tags.split(',');
      const isTagMatch: boolean = tagsArray.some(tag => tag.toLowerCase().includes(searchQuery.toLowerCase()));
      return isCategoryMatch && (isNameMatch || isTagMatch);
    })
  : [];

const handleSearchInput = (event: React.ChangeEvent<HTMLInputElement>): void => setSearchQuery(event.target.value);

  return (
    <>
    <section className="bg-white dark:bg-gray-900 pt-40 px-8 sm:px-32">
             <div className="w-full flex justify-end items-center gap-4">
    <div className="flex w-[100%]">
        <label htmlFor="search-dropdown" className="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your Email</label>
        <button onClick={toggleCategories} id="dropdown-button" data-dropdown-toggle="dropdown" className="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button"><span id="dropdown-button-text">All categories</span> <svg className="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
    <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 4 4 4-4"/>
  </svg></button>
        <div className="absolute z-10 top-[13rem] bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul id="dropdown" className="hidden py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
            <li onClick={() => setSearchCategory('')}>
                <button type="button" className="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All categories</button>
            </li>
            {categories && categories.map((category: Category, index: number) => {
              return (
                <li key={index} onClick={() => setSearchCategory(category.name)}>
                <button type="button" className="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{category.name}</button>
            </li>
              )
            })}
            </ul>
        </div>
        <div className="relative w-full" onBlur={removeSearchResult}>
            <input type="search" id="search-dropdown" className="outline-none block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search for Wikis..." required onFocus={displaySearchResults} onChange={handleSearchInput}></input>
            <div id="search-result" className="hidden absolute z-10 top-[3rem] left-[3rem] bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 py-2">
            {filteredWikis.length > 0 ? (
              filteredWikis.slice(0, 5).map((wiki: Wiki, index: number) => (
                <a 
                  key={index} 
                  className="inline-flex w-full px-4 py-2 text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" 
                  href={`${process.env.REACT_APP_HOST_NAME}/wiki/${wiki.id}`}
                >
                  {wiki.title}
                </a>
              ))
            ) : (
              <div className="text-bold inline-flex w-full px-4 py-2 text-white hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">No results found</div>
            )}
            </div>
        </div>
    </div>
       <button className="flex gap-1 jutify-center items-center bg-blue-500 hover:bg-blue-600 text-slate-50 font-bold py-2 px-4 rounded focus:ring-4 focus:border-blue-200 border-blue-700" onClick={updateWikis}>
Refresh
<svg fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"><path d="M13.5 2c-5.621 0-10.211 4.443-10.475 10h-3.025l5 6.625 5-6.625h-2.975c.257-3.351 3.06-6 6.475-6 3.584 0 6.5 2.916 6.5 6.5s-2.916 6.5-6.5 6.5c-1.863 0-3.542-.793-4.728-2.053l-2.427 3.216c1.877 1.754 4.389 2.837 7.155 2.837 5.79 0 10.5-4.71 10.5-10.5s-4.71-10.5-10.5-10.5z"/></svg>
      </button>
       </div>
    </section>
      <section className="bg-white dark:bg-gray-900">
       <div className="py-8 mx-8 sm:mx-32 max-w-screen-xl lg:py-28">
        <h2 className="mb-10 text-5xl tracking-tight font-bold text-[#3B82F6]">Latest Wikis</h2>
  {(isLoading) ? <Spinner/> : wikis && wikis.slice(0, 5).map((wiki: Wiki, index: number) => {
    return (
      <div key={index}>
      <div className="max-w-screen-lg text-gray-500 sm:text-lg dark:text-gray-400">
          <h2 className="mb-4 text-4xl tracking-tight font-bold text-gray-900 dark:text-white">{wiki.title}</h2>
          <p className="lead text-gray-500 text-[1.2rem] mb-4">{wiki.content.slice(0, 285)}</p>
          <div className="flex justify-center items-start gap-2 flex-col">
          <p className="text-gray-500">tags:</p>
         <div className="flex flex-wrap gap-1">
         {wikis[index].tags && wikis[index].tags.split(',').map((tag: string, index: number) => {
                        return (
                          <div 
                          key={index} 
                          className='dark:bg-primary-900 flex py-1 rounded gap-1 px-2 text-primary-300'
                        >
                          <span className="text-xs font-medium text-primary-300">{tag}</span>
                        </div>                        
                        )
          })}
         </div>
          <a href={`${process.env.REACT_APP_HOST_NAME}/wiki/${wiki.id}`} className="flex items-center font-medium text-primary-600 hover:text-primary-800 dark:text-primary-500 dark:hover:text-primary-700">
              Read Wiki
              <svg className="ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd"></path></svg>
          </a>
          </div>
      </div>
  </div>
    )
  })}
  </div>
  <div className="mx-8 sm:mx-32 max-w-screen-xl">
        <h2 className="mb-10 text-5xl tracking-tight font-bold text-[#3B82F6]">Latest Categories</h2>
  {(isLoading) ? <Spinner/> : categories && categories.slice(0, 5).map((category: Category, index: number) => {
    return (
      <div key={index}>
      <div className="max-w-screen-lg text-gray-500 sm:text-lg dark:text-gray-400">
          <h2 className="mb-4 text-4xl tracking-tight font-bold text-gray-900 dark:text-white">{category.name}</h2>
          <p className="lead text-gray-500 text-[1.2rem] mb-4">{category.description.slice(0, 285)}</p>
          </div>
      </div>
    )
  })}
  </div>
</section>
    </>
  )
}

export default Home