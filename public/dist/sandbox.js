"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll("[data-bs-target='#editModal']");
    editButtons.forEach((editButton) => {
        editButton.addEventListener("click", handleEditButtonClick);
    });
});
function handleEditButtonClick(event) {
    const editForm = document.querySelector("#editForm");
    const clickedButton = event.target;
    if (clickedButton) {
        const elementId = clickedButton.getAttribute("data-id");
        if (editForm && elementId) {
            updateFormAction(editForm, elementId);
        }
    }
}
function updateFormAction(form, id) {
    const actionAttribute = form.getAttribute("action");
    if (actionAttribute) {
        const actionParts = actionAttribute.split('/');
        if (actionParts.length > 3) {
            actionParts[actionParts.length - 1] = id;
        }
        else {
            actionParts.push(id);
        }
        const newAction = actionParts.join('/');
        form.setAttribute("action", newAction);
        console.log(form);
    }
}
