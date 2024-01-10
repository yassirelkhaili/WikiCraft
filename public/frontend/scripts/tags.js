"use strict";
/**
 * @author Yassir Elkhaili
 * @license MIT
 * @todo sticky header on scroll down
 * @todo bottom border moves to nav item on hover
 * @todo handle navigation url for pages
*/

document.addEventListener("DOMContentLoaded", () => {
    alert("script added");
     //tag system
 let tags = new Array();
 let tagNames = new Array();
 //get tags container
 const tagsContainer = document.getElementById("tagsContainer");
 const createTag = (innerText) => {
     //create tag container and add classes (styles)
     const tagClasses = new Array('tag', 'bg-gray-300', 'rounded-md', 'p-2', 'm-1');
     const tagContainer = document.createElement("div");
     tagClasses.forEach(tagClass => tagContainer.classList.add(tagClass));
     //create tag innerText Container and insert text
     const innerTextContainer = document.createElement("span");
     innerTextContainer.textContent = innerText;
     //create close button
     const closeBtn = document.createElement("button");
     closeBtn.type = "button";
     closeBtn.classList.add("pl-1", "removeTag");
     const closeSvg = new Image();
     closeSvg.src = "../../images/closeBtnSvg.svg";
     closeSvg.alt = "close button icon";
     closeBtn.appendChild(closeSvg);
     //append elements and return tag
     tagContainer.appendChild(innerTextContainer);
     tagContainer.appendChild(closeBtn);
     return tagContainer;
 };
 //add tags to tag Array
 const addTag = (tag) => {
     if (tags.length > 12) {
         alert("Cannot add more than 12 tags");
         return false;
     }
     else {
         tags.push(tag);
     }
     return true;
 };
 //render tags based on tags Array
 const renderTags = () => {
     tags.slice().reverse().forEach(tag => tagsContainer.prepend(tag));
     // Add delete event listeners
     const deleteBtns = document.querySelectorAll(".removeTag");
     deleteBtns.forEach(deletebtn => deletebtn.addEventListener("click", (event) => deleteTag(event.target)));
 };
 // Delete tag
 const deleteTag = (tag) => {
     const element = tag?.parentElement?.parentElement;
     const index = tags.indexOf(element);
     if (index !== -1) {
         tags.splice(index, 1);
         tagsContainer.removeChild(element);
     }
     ;
 };
 //function to save tagNames on add
 const saveTagName = (tagName) => { tagNames.push(tagName); };
 //add tag on user enter button press
 const tagInputField = document.getElementById("taginput");
 const addTagButton = document.getElementById("submitTag");
 addTagButton && addTagButton.addEventListener("click", (event) => {
     const tagName = tagInputField.value;
     const newTag = createTag(tagName);
     if (addTag(newTag)) {
         saveTagName(tagName);
     }
     renderTags();
 });
 //render tags from tags Array
 renderTags();
 //function to post tags;
 const postTags = async () => {
     const origin = window.location.origin;
     const currentUrl = new URL(window.location.href);
     const projectID = currentUrl.searchParams.get("id");
     const endpoint = origin + "/backend/tags.php";
     try {
         const response = await fetch(endpoint, {
             method: "POST",
             headers: {
                 'Content-Type': 'application/json',
             },
             body: JSON.stringify({ projectID: projectID, tags: tagNames }),
         });
         if (!response.ok) {
             throw new Error(`Failed to post tag. Status: ${response.status}`);
         }
         const result = await response.json();
         return result.message;
     }
     catch (error) {
         throw new Error("There was an error posting the tag: " + error.message);
     }
 };
})