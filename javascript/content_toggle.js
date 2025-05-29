console.log('content_toggle.js script loaded and running');

// Toggles visibility of content when a button is clicked
function toggleContent(button) {
    
    console.log('Button clicked');
    // Get the element directly after the button
    const content = button.nextElementSibling;      

    // Toggle the visibility of the content and update button label
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        button.textContent = 'Hide content';
        console.log('Content revealed');
    } else {
        content.classList.add('hidden');
        button.textContent = 'Show content';
        console.log('Content hidden');
    }
}

window.toggleComments = function(id) {
    const section = document.getElementById(id);
    if (section.style.display === "none" || section.style.display === "") {
        section.style.display = "block";
    } else {
        section.style.display = "none";
    }
};