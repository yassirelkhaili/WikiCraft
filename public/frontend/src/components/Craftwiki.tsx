import React, {useEffect, useState} from 'react'
import Spinner from '../utils/Spinner';
import Toast from '../utils/ToastComponent';
import { Tag } from '../data/wikis/Createwiki';
import Modal from '../utils/ModalComponent';

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

const Craftwiki = () => {
    const [wikis, setwikis] = useState<Array<Wiki>>();
    const [isLoading, setisLoading] = useState<boolean>(false);
    const [toast, settoast] = useState<React.ReactNode>(<></>);

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

      const updateWikis = (): void => {
        setisLoading(true);
        fetchWikis().then((response: ResponseProps) => {
            setwikis(response.content);
        }).catch((error) => settoast(<Toast message={`An error has occured ${error}`} type='danger'/>)).finally(() => setisLoading(false));
      }

      useEffect(() => {
        setisLoading(true);
        fetchWikis().then((response: ResponseProps) => {
            setwikis(response.content);
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

      const handleWikiDelete = (id: number) => {
        settoast(<Modal contentType='wikis' settoast={settoast} toast={toast} id={id} updateFunction={updateWikis} message="Click confirm to delete wiki" type='warning'></Modal>);
      }
    
  return (
    <>
    <section className='flex justify-center items-center pt-48 flex-col gap-4'>
   <div className='w-full flex justify-center items-start'>
   <a href="/createwiki">
      <button className="bg-blue-500 hover:bg-blue-600 text-slate-50 font-bold py-2 px-4 rounded focus:ring-4 focus:border-blue-200 border-blue-700">
        Craft Wiki
      </button>
    </a>
   </div>
                        <table className="text-sm text-left text-gray-500 dark:text-gray-400 rounded-md">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr className="border-t-1 border rounded-t-md">
                                    <th scope="col" className="p-4 border-l-1 border rounded-l-md rounded-b-none border-r-0">Wiki Title</th>
                                    <th scope="col" className="p-4">Category</th>
                                    <th scope="col" className="p-4">Author</th>
                                    <th scope="col" className="p-4">tags</th>
                                    <th scope="col" className="p-4 border-t-1 border rounded-r-md rounded-l-none border-l-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {isLoading ? (
                                <tr>
                                    <td colSpan={5} className="text-center">
                                        <Spinner />
                                    </td>
                                </tr>
                            ) : (wikis && wikis.map((wiki: Wiki, index: number) => {
                                return (<tr className="border-b bg-[#454e5b] h-8 hover:bg-gray-600" key={index}>
                                <th scope="row" className="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div className="flex items-center mr-3">
                                    {wiki.title}
                                    </div>
                                </th>
                                <td className="px-4 py-3 text-white">{wiki.category}</td>
                                <td className="px-4 py-3 font-medium">{wiki.author}</td>
                                <td className={`py-3 max-w-[260px] ${wiki.tags && wiki.tags.split(',').length > 4 ? 'flex flex-wrap gap-1 justify-start items-center' : ''}`}>
                                {wiki.tags && wiki.tags.split(',').map((tag: Tag, index: number) => (
                                <span 
                                key={index}
                                className={`${index > 0 && "ml-1"} bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300`}
                                >
                                {tag.trim()}
                                </span>
                                ))}
                                </td>
                                <td className="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div className="flex items-center space-x-4">
                                        <a href={`${process.env.REACT_APP_HOST_NAME}/edit/${wiki.id}`} data-drawer-target="drawer-update-product" data-drawer-show="drawer-update-product" aria-controls="drawer-update-product" className="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 mr-2 -ml-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fillRule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clipRule="evenodd" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href={`${process.env.REACT_APP_HOST_NAME}/wiki/${wiki.id}`} data-drawer-target="drawer-read-product-advanced" data-drawer-show="drawer-read-product-advanced" aria-controls="drawer-read-product-advanced" className="py-2 px-3 flex items-center text-sm font-medium text-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 mr-2 -ml-0.5">
                                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                <path fillRule="evenodd" clipRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                            </svg>
                                            Preview
                                        </a>
                                        <button onClick={() => handleWikiDelete(wiki.id)} type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal" className="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 h-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 mr-2 -ml-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fillRule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clipRule="evenodd" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>)
                            }))}
                            </tbody>
                        </table>
                        {toast}
                    </section>
    </>
  )
}

export default Craftwiki