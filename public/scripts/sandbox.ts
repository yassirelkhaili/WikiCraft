document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll("[data-bs-target='#editModal']") as NodeListOf<HTMLButtonElement>;
    
    editButtons.forEach((editButton: HTMLButtonElement) => {
        editButton.addEventListener("click", handleEditButtonClick);
    });
});

function handleEditButtonClick(event: MouseEvent): void {
    const editForm = document.querySelector<HTMLFormElement>("#editForm");
    const clickedButton = event.target as HTMLButtonElement;

    if (clickedButton) {
        const elementId = clickedButton.getAttribute("data-id");
        
        if (editForm && elementId) {
            updateFormAction(editForm, elementId);
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
        console.log(form)
    }
}
