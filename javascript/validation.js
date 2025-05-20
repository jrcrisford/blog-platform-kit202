console.log('validation.js script loaded and running');

// Find the form element on the page
const form = 
    document.getElementById('writePostForm') ||
    document.getElementById('loginForm') ||
    document.getElementById('registerForm');

// Visually indicates error on fields and shows message where relevant
function showError(inputField, errorMessage) {
    inputField.classList.add('input-error');
    const errorElement = document.getElementById(`${inputField.id}-error`);
    if (errorElement) {
        errorElement.textContent = errorMessage;
    }
}

// Reset previous error formatting and messages
function clearErrors(fields) {
    fields.forEach(inputField => {
        inputField.classList.remove('input-error');
        const errorElement = document.getElementById(`${inputField.id}-error`);
        if (errorElement) {
            errorElement.textContent = '';
        }
    });
}

// Listen for form submission
form.addEventListener('submit', function(event) {
    
    // Stop immediate submission of form
    console.log(`${form.id} submission detected - validating fields`);

    // Array to hold input fields
    let fields = [];

    // Get input fields metadata and store in array
    if (form.id === 'writePostForm') {
        fields = [
            {id: 'title', name: 'Title', required: true, maxLength: 80},
            {id: 'tags', name: 'Tags', required: true},
            {id: 'content', name: 'Content', required: true}
        ];
    } else if (form.id === 'loginForm') {
        fields = [
            {id: 'username', name: 'Username', required: true},
            {id: 'password', name: 'Password', required: true}
        ];
    } else if (form.id === 'registerForm') {
        fields = [
            {id: 'register-username', name: 'Username', required: true, minLength: 3, maxLength: 20},
            {id: 'email', name: 'Email', required: true, type: 'email'},
            {id: 'register-password', name: 'Password', required: true, type: 'password'},
            {id: 'confirm-password', name: 'Confirm Password', required: true, match: 'register-password'}
        ];
    }
    
    // Get values of each field and add to each field object
    fields = fields.map(f => ({
        ...f,
        element: document.getElementById(f.id),
    }));

    // Reset previous error formatting and messages
    clearErrors(fields.map(f => f.element));
    console.log('Previous errors cleared');

    // Flag for tracking validation failure
    let error = false;

    fields.forEach(f => {
        // Get the value of the field and trim whitespace
        const value = f.element.value.trim();

        // Check if field is empty and required
        if (f.required && value === '') {
            showError(f.element, `${f.name} cannot be empty`);
            console.log(`Validation failed: ${f.name} field is empty`);
            error = true;
            return;
        }

        if (f.minLength && value.length < f.minLength) {
            showError(f.element, `${f.name} must be at least ${f.minLength} characters`);
            console.log(`Validation failed: ${f.name} field is less than ${f.minLength} characters`);
            error = true;
            return;
        }

        // Check if field exceeds maxLength if defined
        if (f.maxLength && value.length > f.maxLength) {
            showError(f.element, `${f.name} cannot be more than ${f.maxLength} characters`);
            console.log(`Validation failed: ${f.name} field exceeds ${f.maxLength} characters`);
            error = true;
            return;
        }

        // Check if email format is valid if type is email
        if (f.type === 'email' && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            showError(f.element, 'Please enter a valid email address');
            console.log(`Validation failed: ${f.name} field is not a valid email`);
            error = true;
        }

        // Check if password meets password requirements
        if (f.type === 'password' && !f.match) {
            const passwordRequirements = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!passwordRequirements.test(value)) {
                showError(f.element, 'Password does not meet requirements');
                console.log(`Validation failed: ${f.name} field does not meet password requirements`);
                error = true;
            }
        } 

        // Check if password and confirm password match
        if (f.match) {
            const matchField = document.getElementById(f.match).value;
            if (value !== matchField) {
                showError(f.element, 'Passwords do not match');
                console.log(`Validation failed: ${f.name} field does not match ${f.match}`);
                error = true;
            }
        }
    });

    form.addEventListener('reset', function() {
        console.log('Form reset detected - clearing errors');
        
        let fieldIds = [];
        if (form.id === 'writePostForm') {
            fieldIds = ['title', 'tags', 'content'];
        } else if (form.id === 'loginForm') {
            fieldIds = ['username', 'password'];
        } else if (form.id === 'registerForm') {
            fieldIds = ['register-username', 'email', 'register-password', 'confirm-password'];
        }

        const fields = fieldIds.map(id => document.getElementById(id));
        clearErrors(fields);
    });

    if (error) {
        event.preventDefault();
        console.log('Form blocked due to validation errors');
    } else {
        console.log('Form passed validation');
    }

});
