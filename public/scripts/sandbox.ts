/** 
 * @author Yassir Elkhaili
 * @license MIT
*/

interface responseObject {
email: string;
id: number;
lastname: string;
name: string;
userId: string;
}

document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll("[data-bs-target='#editModal']") as NodeListOf<HTMLButtonElement>;
    
    editButtons.forEach((editButton: HTMLButtonElement) => {
        editButton.addEventListener("click", handleEditButtonClick);
    });
});

async function fetchElementById(id: string): Promise<Array<responseObject>> {
    const windowObject: Location = window.location;
    const endPoint: string = windowObject.protocol + "//" + windowObject.hostname + `/books/show/${id}`;
    try {
        const response: Response = await fetch(endPoint);
        if (!response.ok) {
            throw new Error(`Failed to fetch data. Status: ${response.status}`);
        }
        const data: Array<responseObject> = await response.json();
        return data;
    } catch (error) {
        throw new Error(`There was an error fetching the data: ${error}`);
    }
}

function populateFormFields (form: HTMLFormElement, data: Array<responseObject>): void {
    const element: responseObject = data[0];
    const inputFields = form.getElementsByTagName("input") as HTMLCollectionOf<HTMLInputElement>;
    inputFields[0].value = element.name;
    inputFields[1].value = element.email;
}

function handleEditButtonClick (event: MouseEvent): void {
    const editForm = document.querySelector<HTMLFormElement>("#editForm");
    const clickedButton = event.target as HTMLButtonElement;
    if (clickedButton) {
        const elementId = clickedButton.getAttribute("data-id");
        if (editForm && elementId) {
            updateFormAction(editForm, elementId);
            fetchElementById(elementId)
        .then(data => {
        populateFormFields(editForm, data);
        })
        .catch(error => {
        console.error("Error:", error.message);
    });        
        }
    }
}

function updateFormAction(form: HTMLFormElement, id: string): void {
    const actionAttribute = form.getAttribute("action");

    if (actionAttribute) {
        const actionParts = actionAttribute.split('/');
        
        if (actionParts.length > 3) {
            actionParts[actionParts.length - 1] = id;
        } else {
            actionParts.push(id);
        }

        const newAction = actionParts.join('/');
        form.setAttribute("action", newAction);
    }
}
