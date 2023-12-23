"use strict";
/**
 * @author Yassir Elkhaili
 * @license MIT
*/
document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll("[data-bs-target='#editModal']");
    editButtons.forEach((editButton) => {
        editButton.addEventListener("click", handleEditButtonClick);
    });
});
async function fetchElementById(id) {
    const windowObject = window.location;
    const endPoint = windowObject.protocol + "//" + windowObject.hostname + `/books/show/${id}`;
    try {
        const response = await fetch(endPoint);
        if (!response.ok) {
            throw new Error(`Failed to fetch data. Status: ${response.status}`);
        }
        const data = await response.json();
        return data;
    }
    catch (error) {
        throw new Error(`There was an error fetching the data: ${error}`);
    }
}
function populateFormFields(form, data) {
    const element = data[0];
    const inputFields = form.getElementsByTagName("input");
    inputFields[0].value = element.name;
    inputFields[1].value = element.email;
}
function handleEditButtonClick(event) {
    const editForm = document.querySelector("#editForm");
    const clickedButton = event.target;
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
    }
}
